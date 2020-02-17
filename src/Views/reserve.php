<div id="reserve">
    <div class="container padding">
        <div class="section-title">
            <h1>예매하기</h1>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-12">
                <div class="my-5">
                    <div class="section-title mb-4">
                        <h5>FORM</h5>
                    </div>
                    <form method="post" autocomplete="false">
                        <div class="form-group">
                            <label for="schedule_id">행사 일정</label>
                            <select name="schedule_id" id="schedule_id" class="form-control">
                                <option value="">일정을 선택하세요</option>
                                <?php foreach($scheduleList as $schedule):?>
                                    <option value="<?=$schedule->id?>"><?=scheduleName($schedule)?></option>
                                <?php endforeach;?>
                            </select>
                            <button class="btn btn-blue mt-4">예매하기</button>
                        </div>
                    </form>
                </div>
                <div class="my-5">
                    <div class="section-title mb-4">
                        <h5>LIST</h5>
                    </div>
                    <table class="table">
                        <thead class="text-center">
                            <tr>
                                <th>행사 일정</th>
                                <th>예매일</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(count($reserveList) === 0):?>
                                <tr>
                                    <td colspan="3" class="text-center">예매 내역이 존재하지 않습니다.</td>
                                </tr>
                            <?php endif;?>
                            <?php foreach($reserveList as $reserve): ?>
                                <tr>
                                    <td><?=scheduleName($reserve)?></td>
                                    <td><?=date("Y년 m월 d일", strtotime($reserve->reserved_at))?></td>
                                    <td>
                                        <button class="btn btn-danger">삭제</button>
                                    </td>
                                </tr>
                            <?php endforeach;?>
                        </tbody>
                    </table>    
                </div>
            </div>
            <img src="" alt="" class="bg-primary col-lg-6 col-md-12" height="500">
        </div>
    </div>
</div>