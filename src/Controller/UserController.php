<?php
namespace Areuka\Controller;

use Areuka\Engine\DB;

class UserController {
    public function joinPage(){
        view("join");
    }

    public function join(){
        emptyCheck();
        extract($_POST);

        if(!preg_match("/^([a-zA-Z0-9]+)@([a-zA-Z0-9]+)\.([a-zA-Z]{2,4})$/", $identity)) back("아이디가 이메일 형식이 아닙니다.");
        if(strlen($password) < 4) back("비밀번호는 최소 4자리 이상이여야 합니다.");
        if($password !== $passconf) back("비밀번호와 비밀번호 확인이 일치하지 않습니다.");

        $result = DB::query("INSERT INTO users(identity, name, password, type) VALUES (?, ?, ?, ?)", [$identity, $name, hash("sha256", $password), $type]);

        if($result->rowCount() !== 1) back("회원정보를 추가하는 도중 문제가 발생했습니다.");
        else redirect("/users/login" ,"회원가입 되었습니다.", 1);
    }

    public function loginPage(){
        view("login");
    }

    public function login(){
        emptyCheck();
        extract($_POST);

        $userInfo = DB::fetch("SELECT * FROM users WHERE identity = ?", [$identity]);
        if(!$userInfo) return back("해당 아이디와 일치하는 유저를 찾을 수 없습니다.");
        if($userInfo->password !== hash("sha256", $password)) return back("비밀번호가 일치하지 않습니다.");

        session()->set("user", $userInfo);
        redirect("/", "로그인 되었습니다.", 1);
    }

    public function logout(){
        session()->remove("user");
        redirect("/", "로그아웃 되었습니다.", 1);
    }
}