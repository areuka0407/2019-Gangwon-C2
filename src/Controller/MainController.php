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
        $data['reserveList'] = DB::fetchAll("SELECT * FROM reserves R, schedules S WHERE R.schedule_id = S.id AND R.user_id = ?", [user()->id]);

        view("reserve", $data);
    }

    function reserve(){
        emptyCheck();
        extract($_POST);

        $q = DB::query("SELECT * FROM schedules WHERE id = ?", [$schedule_id]);
        if($q->rowCount() === 0) return back("해당 스케줄을 찾을 수 없습니다.");

        DB::query("INSERT INTO reserves(user_id, schedule_id) VALUES (?, ?)", [user()->id, $schedule_id]);

        redirect("/reserve", "예매가 완료되었습니다.", 1);
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