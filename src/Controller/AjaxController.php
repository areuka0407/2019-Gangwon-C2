<?php
namespace Areuka\Controller;

use Areuka\Engine\DB;

class AjaxController {
    private function output($data){
        header("Content-Type: application/json");
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
    }

    function getList($table){
        $list = DB::fetchAll("SELECT * FROM `{$table}`");
        $this->output($list);
    }

    function getItem($table, $id){
        $item = DB::find($table, $id);
        $this->output($item);
    }
}