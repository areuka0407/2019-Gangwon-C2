<div id="join">
    <div class="container padding">
        <div class="section-title center mb-3">
            <h5>회원가입</h5>
        </div>
        <form method="post" autocomplete="FALSE" class="mx-auto col-lg-6 col-md-12">
            <div class="form-group">
                <label for="identity">아이디</label>
                <input type="text" id="identity" class="form-control" name="identity" required>
            </div>
            <div class="form-group">
                <label for="name">이름 / 업체명</label>
                <input type="text" id="name" class="form-control" name="name" required>
            </div>
            <div class="form-group">
                <label for="password">비밀번호</label>
                <input type="password" id="password" class="form-control" name="password" required>
            </div>
            <div class="form-group">
                <label for="passconf">비밀번호 확인</label>
                <input type="password" id="passconf" class="form-control" name="passconf" required>
            </div>
            <div class="form-group">
                <p class="text-muted">이미 계정을 가지고 계신가요? <a href="/users/login" class="text-blue">로그인하기</a></p>
            </div>
            <div class="form-group mb-5">
                <label>회원 구분</label>
                <div>
                    <div class="form-radio">
                        <input type="radio" id="normal" name="type" value="normal" required>
                        <label class="radio-text" for="normal">일반회원</label>
                        <label class="radio-input" for="normal"></label>
                    </div>
                    <div class="form-radio">
                        <input type="radio" id="company" name="type" value="company" required>
                        <label class="radio-text" for="company">기업회원</label>
                        <label class="radio-input" for="company"></label>
                    </div>
                </div>
            </div>
            <button class="btn btn-blue w-100">회원가입</button>
        </form>
    </div>
</div>