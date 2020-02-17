<div id="login">
    <div class="container padding">
        <div class="section-title center mb-3">
            <h5>로그인</h5>
        </div>
        <form method="post" autocomplete="FALSE" class="mx-auto col-lg-6 col-md-12">
            <div class="form-group">
                <label for="identity">아이디</label>
                <input type="text" id="identity" class="form-control" name="identity" required>
            </div>  
            <div class="form-group">
                <label for="password">비밀번호</label>
                <input type="password" id="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <p class="text-muted">계정이 없으신가요? <a href="/users/join" class="text-blue">회원가입하기</a></p>
            </div>
            <button class="btn btn-blue">로그인</button>
        </form>
    </div>
</div>