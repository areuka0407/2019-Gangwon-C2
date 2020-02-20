<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BIMOS 2020 | 부산국제모터쇼</title>
    <script src="/js/jquery-3.4.1.slim.min.js"></script>
    <link rel="stylesheet" href="/bootstrap-4.4.1-dist/css/bootstrap.min.css">
    <script src="/bootstrap-4.4.1-dist/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="/fontawesome-free-5.1.0-web/css/all.css">
    <script src="/fontawesome-free-5.1.0-web/js/all.js"></script>
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/app.js"></script>
    <?php if(session()->has("toast-message")):?>
        <script>
            window.onload = function(){
                toast(`<?= session()->get("toast-message") ?>`, "<?=session()->get("toast-type") ? "bg-primary" : "bg-danger"?>");
            }
        </script>
    <?php endif;?>
</head>
<body>
     <input type="checkbox" id="sidebar-fade" hidden>
      <!-- HEADER -->
      <div id="top" class="d-none d-lg-block">
        <div class="container-lg d-flex justify-content-between align-items-center flex-lg-row">
            <div class="my-2">
                <?php if(user()):?>
                    <p class="mb-0 d-inline-block"><span class="text-blue"><?= user()->name ?></span>님 안녕하세요!</p>
                    <p class="mb-0 d-inline-block ml-2"><a href="/users/logout">로그아웃</a></p>
                <?php else: ?>
                    <p class="mb-0 d-inline-block"><a href="/users/login">로그인</a> 후 모든 서비스를 이용하실 수 있습니다.</p>
                    <p class="ml-2 mb-0 d-inline-block text-gray">계정이 없으신가요? <a href="/users/join">회원가입하기</a></p>
                <?php endif;?>
            </div>
            <div class="icons my-2">
                <button><i class="fab fa-facebook-f"></i></button>
                <button><i class="fab fa-twitter"></i></button>
                <button><i class="fab fa-google-plus-g"></i></button>
            </div>
        </div>
    </div>
    <div id="header">
        <div class="container d-flex h-100 align-items-center justify-content-between position-relative">
            <a href="/">
                <img src="/images/logo.png" alt="부산국제모터쇼">
            </a>
            <div id="nav" class="d-lg-flex d-none">
                <div class="item">
                    <a href="/bimos/info">부산국제모터쇼</a>
                    <div class="sub-nav">
                        <a href="/bimos/info">행사소개</a>
                        <a href="/bimos/history">모터쇼 연혁</a>
                    </div>
                </div>
                <div class="item"><a href="/reserve">예매하기</a></div>
                <div class="item">
                    <a href="/booth-map">관람안내</a>
                    <div class="sub-nav">
                        <a href="/booth-map">부스배치도</a>
                    </div>
                </div>
                <div class="item">
                    <a href="/admin/site-management">관리자</a>
                    <div class="sub-nav">
                        <a href="/admin/site-management">사이트 관리자</a>
                        <a href="/admin/request-booth">부스신청</a>
                    </div>
                </div>
            </div>
            <label id="sidebar-fader" for="sidebar-fade" class="d-lg-none m-0">
                <div></div>
                <div></div>
                <div></div>
            </label>
        </div>
    </div>
    <div id="mobile-sidebar" class="d-lg-none">
        <div class="contents">
            <h5 class="font-weight-bold">Page</h5>
            <div class="list">
                <div class="item">
                    <a href="/info.html">부산국제모터쇼</a>
                    <div class="sub-list" data-no="2">
                        <a href="/info.html">행사소개</a>
                        <a href="/#">모터쇼 연혁</a>
                    </div>
                </div>
                <div class="item">
                    <a href="/#">예매하기</a>
                </div>
                <div class="item">
                    <a href="/#">관람안내</a>
                    <div class="sub-list" data-no="1">
                        <a href="/#">부스배치도</a>
                    </div>
                </div>
                <div class="item">
                    <a href="/site-mangement.html">관리자</a>
                    <div class="sub-list" data-no="2">
                        <a href="/site-mangement.html">사이트 관리자</a>
                        <a href="/#">부스신청</a>
                    </div>
                </div>
            </div>
            <h5 class="mt-3 font-weight-bold">Acount</h5>
            <div class="list">
                <div class="item"><a href="/#">로그인</a></div>
                <div class="item"><a href="/#">회원가입</a></div>
            </div>
            <h5 class="mt-3 font-weight-bold">Shere</h5>
            <div class="icons">
                <button><i class="fab fa-twitter"></i></button>
                <button><i class="fab fa-facebook-f"></i></button>
                <button><i class="fab fa-google-plus-g"></i></button>
            </div>
        </div>
    </div>