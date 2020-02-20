<?php
namespace Areuka\Controller;

use Areuka\Engine\DB;

class AdminController {
    /**
     * 사이트 관리자
     */
    function managePage(){
        view("management");
    }

    function addSchedule(){
        emptyCheck();
        extract($_POST);
        
        $_startTime = date("y-m-d", strtotime($start_time));
        $_endTime = date("y-m-d", strtotime($end_time));

        if($start_time !== $_startTime) back("행사 시작일을 올바른 양식으로 작성해 주시기 바랍니다.");
        if($end_time !== $_endTime) back("행사 시작일을 올바른 양식으로 작성해 주시기 바랍니다.");
        if(preg_match("/[^0-9]+/", $view_scale)) back("참관 가능인원을 올바른 양식으로 작성해 주시기 바랍니다.");
     
        
        $sql = "SELECT * FROM schedules WHERE timestamp(startTime) <= timestamp(?) AND timestamp(endTime) >= timestamp(?)";
        $q = DB::query($sql, [$end_time, $start_time]);
        if($q->rowCount() > 0) back("해당 시간에는 이미 일정이 잡혀있습니다.\n다른 시간을 선택해 주십시오.");
        
        DB::query("INSERT INTO schedules(imageData, startTime, endTime, viewScale, boothList) VALUES (?, ?, ?, ?, ?)", [$image_map, $start_time, $end_time, $view_scale, $booth_list]);

        return redirect("/admin/site-management", "새로운 일정이 추가되었습니다.", 1);
    }

    /**
     * 부스 신청
     */
    function requestPage(){
        $viewData['schedules'] = DB::fetchAll("SELECT * FROM schedules
                                                WHERE timestamp(startTime) > NOW()");

        $viewData['myList'] = DB::fetchAll("SELECT S.startTime, S.endTime, B.requested_at, B.size, B.name
                                            FROM schedules S, booths B
                                            WHERE S.id = B.schedule_id AND B.user_id = ?", [user()->id]);

        foreach($viewData['schedules'] as $sch) {
            $sch->boothList = json_decode($sch->boothList);
        }
        view("request-booth", $viewData);  
    }

    function request(){
        emptyCheck();
        extract($_POST);

        DB::query("INSERT INTO booths(schedule_id, user_id, name, size) VALUES (?, ?, ?, ?)", [$schedule_id, user()->id, $booth_id, $booth_size]);
        return redirect("/admin/request-booth", "요청이 완료되었습니다.");        
    }
}