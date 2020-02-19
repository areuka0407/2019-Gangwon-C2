<?php
namespace Areuka\Controller;

use Areuka\Engine\DB;

class MainController {
    function indexPage(){
        view("index");
    }

    function infoPage(){
        view("info");
    }

    function historyPage(){
        view("history");
    }

    function reservePage(){
        $tomorrow = date("Y-m-d", time() + 3600 * 24);
        
        # 조건
        # 1. 종료일이 하루는 남아있는 일정

        $sql = "SELECT * FROM schedules S WHERE timestamp(S.endTime) > timestamp(?)";
        $data['scheduleList'] = DB::fetchAll($sql, [$tomorrow]);
        $data['reserveList'] = DB::fetchAll("SELECT S.startTime, S.endTime, R.reserved_at, R.id FROM reserves R, schedules S WHERE R.schedule_id = S.id AND R.user_id = ?", [user()->id]);

        view("reserve", $data);
    }

    function reserve(){
        emptyCheck();
        extract($_POST);

        $schedule = DB::fetch("SELECT * FROM schedules WHERE id = ?", [$schedule_id]);
        if(!$schedule) return back("해당 스케줄을 찾을 수 없습니다.");
        
        $resCount = DB::fetch("SELECT COUNT(*) cnt FROM reserves WHERE schedule_id = ?", [$schedule->id])->cnt;
        if($schedule->viewScale <= $resCount + 1) return back("이 행사는 예매인원이 초과되어 예약할 수 없습니다.");

        DB::query("INSERT INTO reserves(user_id, schedule_id) VALUES (?, ?)", [user()->id, $schedule_id]);

        redirect("/reserve", "예매가 완료되었습니다.", 1);
    }   

    function removeReserve($reserve_id){
        $tomorrow = strtotime(date("Y-m-d")) + 3600 * 24;
        $reserve = DB::find("reserves", $reserve_id);
        if(!$reserve) return back("취소할 예매 내역을 찾지 못했습니다.");
        if($reserve->user_id != user()->id) return back("권한이 없습니다.");

        $schedule = DB::find("schedules", $reserve->schedule_id);
        if(!$schedule) return back("해당 행사를 찾을 수 없습니다.");
        if(strtotime($schedule->endTime) <= $tomorrow) return back("행사 종료일이 최소 1일 이상 남을 경우에 한해서 취소가 가능합니다.");

        DB::query("DELETE FROM reserves WHERE id = ?", [$reserve_id]);
        return redirect("/reserve", "예매 취소가 완료되었습니다.", 1);
    }

    function reserveGraph($schedule_id){
        $schedule = DB::fetch("SELECT * FROM schedules WHERE id = ?", [$schedule_id]);

        if(!$schedule) return;

        /**
         * Setting
         */
        $viewScale = $schedule->viewScale;
        $resCount = DB::fetch("SELECT COUNT(*) cnt FROM reserves WHERE schedule_id = ?", [$schedule->id])->cnt;

        $width = 500;
        $height = 500;
        $fontFile = __PUBLIC.DS."fonts".DS."NanumSquareR.ttf";
        
        $img = imagecreatetruecolor($width, $height);
        
        $background = imagecolorallocatealpha($img, 255, 255, 255, 0);
        $textColor = imagecolorallocate($img, 255, 255, 255);
        $selected = \imagecolorallocate($img, 64, 103, 231);
        $non_selected = \imagecolorallocate($img, 224, 224, 224);
        $padding = 30;

        // background
        imagefilledrectangle($img, 0, 0, $width, $height, $background);
        
        // circle
        $reserveEND = (int)ceil(360 * $resCount / $viewScale);
        imagefilledarc($img, $width / 2, $height / 2, $width - $padding, $height - $padding, 0, 360, $non_selected, IMG_ARC_PIE);
        ($reserveEND !== 0) && imagefilledarc($img, $width / 2, $height / 2, $width - $padding, $height - $padding, 0, $reserveEND, $selected, IMG_ARC_PIE);

        // infomation
        $t_padding = 20;
        $textGap = 13;
        $t_width = 170;
        $t_height = 100;
        $t_x = $width - $t_width;
        $t_y = $height - $t_height;
        $t_background = imagecolorallocatealpha($img, 0, 0, 0, 64);
        imagefilledrectangle($img, $t_x, $t_y, $width, $height, $t_background);
        
        $fontSize = 10;
        $rectSize = 10;
        $startX = $t_x + $t_padding;
        $startY = $t_y + $t_padding;
        imagefilledrectangle($img, $startX, $startY, $startX + $rectSize, $startY + $rectSize, $non_selected);
        imagettftext($img, $fontSize, 0, $startX + $rectSize + $textGap / 2, $startY + $fontSize, $textColor, $fontFile, "예매 가능인원: {$viewScale}");

        imagefilledrectangle($img, $startX, $startY + $textGap + $rectSize , $startX + $rectSize, $startY + $textGap + $rectSize * 2, $non_selected);
        imagettftext($img, $fontSize, 0, $startX + $rectSize + $textGap / 2, $startY + $textGap + $rectSize + $fontSize, $textColor, $fontFile, "현재 예매인원: {$resCount}");

        $reservePercent = number_format($resCount * 100 / $viewScale, 2);
        imagettftext($img, $fontSize, 0, $startX, $startY + $textGap * 3 + $rectSize * 2, $textColor, $fontFile, "예매 비율: {$reservePercent}%");

        // echo
        header("Content-Type: image/png");
        imagepng($img);
    }

    
}