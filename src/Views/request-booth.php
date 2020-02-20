<style>
    .image-map {
        height: 600px;
        background-position: -10px center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
    }

    option[disabled] {
        color: #aaa;
    }

    [border] {
        border-width: attr(border);
        border-color: #ddd;
        border-style: solid;
    }
</style>

<div id="visual" class="no-move" style="height: 300px;">
    <div class="images">
        <div class="img" style="filter: brightness(30%);"></div>
    </div>
    <div class="container contents text-center">
        <p>관리자 > 부스 신청</p>
        <h2>Request Booth</h2>
    </div>
</div>

<div id="request-booth">
    <div class="container padding">
        <div class="section-title">
            <h1 description="마음에 드는 부스를 골라보세요!">부스 신청하기</h1>
        </div>
        <form id="request-form" method="post">
            <input type="hidden" id="booth_size" name="booth_size" value="<?= count($schedules[0]->boothList) > 0 ? $schedules[0]->boothList[0]->size : ""?>">
            <div class="section-title mb-2">
                <h5>FORM</h5>
            </div>
            <div class="image-map mb-4" style="background-image: url(<?=$schedules[0]->imageData?>)"></div>
            <div class="row align-items-end">
                <div class="form-group col-12 col-lg-6">
                    <label for="schedule_id">원하는 행사 선택하기</label>
                    <select name="schedule_id" id="schedule_id" class="form-control" required>
                        <?php if(count($schedules) > 0): ?>
                            <?php foreach($schedules as $schedule): ?>
                                <option value="<?=$schedule->id?>"><?=scheduleName($schedule)?></option>
                            <?php endforeach;?>
                        <?php else: ?>
                            <option value="">등록된 행사 일정이 존재하지 않습니다.</option>
                        <?php endif;?>
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="booth_id">부스 선택하기</label>
                    <select name="booth_id" id="booth_id" class="form-control" required>
                        <option value="" class="default">행사를 먼저 선택하세요.</option>
                    </select>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <label for="viewList">전시할 품목</label>
                    <input type="text" id="viewList" name="viewList" class="form-control" required>
                </div>
                <div class="form-group col-12 col-lg-6">
                    <button class="btn btn-blue mt-3">신청하기</button>
                </div>
            </div>
        </form>
        <div class="row mt-5">
            <div class="col-12">
                <div class="section-title mb-3">
                    <h5>LIST</h5>
                </div>
                <table class="table mt-3">
                    <thead>
                        <tr>
                            <th>행사일정</th>
                            <th>부스신청일</th>
                            <th>부스번호</th>
                            <th>부스크기</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($myList as $item): ?>
                            <tr>
                                <td><?= scheduleName($item) ?></td>
                                <td><?= $item->requested_at ?></td>
                                <td><?= $item->name ?></td>
                                <td><?= $item->size ?>㎡</td>
                            </tr>
                        <?php endforeach;?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", () => {
        let s_schedule = document.querySelector("#schedule_id");
        let s_booth = document.querySelector("#booth_id");
        let i_size = document.querySelector("#booth_size");
        let $image = document.querySelector("#request-booth .image-map");
        let $form = document.querySelector("#request-form");

        s_schedule.addEventListener("input", e => {
            updateBooth();
        });

        s_booth.addEventListener("input", e => {
            i_size.value = s_booth.selectedOptions[0].dataset.size;
        });

        $form.addEventListener("submit", e => {
            e.preventDefault();

            if(! i_size.value || !s_booth.value || !s_schedule.value) return toast("모든 정보를 입력하세요.", "bg-danger");

            $form.submit();
        });

        

        function updateBooth(){
            if(s_schedule.value.trim() === "") {
                s_booth.innerHTML = "<option value=''>등록된 부스가 없습니다.</option>";
                return;
            }

            let getSchedule = new Promise((res, rej) => {
                let xhr = new XMLHttpRequest();
                xhr.open("post", "/get-item/schedules/"+s_schedule.value);
                xhr.onload = () => res(xhr.responseText);
                xhr.onerror = () => rej(xhr.response);
                xhr.send();
            });
            let getBooths = new Promise((res, rej) => {
                let xhr = new XMLHttpRequest();
                xhr.open("POST", "/get-list/booths");
                xhr.onload = () => res(xhr.responseText);
                xhr.onerror = () => rej(xhr.response);
                xhr.send();
            });

            Promise.all([getSchedule, getBooths]).then(res => {
                let [schedule, reservedList] = res;
                schedule = JSON.parse(schedule);
                reservedList = JSON.parse(reservedList).filter(x => x.schedule_id == s_schedule.value).map(x => x.name);

                let boothList = JSON.parse(schedule.boothList);
                $image.style.backgroundImage = `url(${schedule.imageData})`;
                $image.border = 1;
                
                if(boothList.length > 0){
                    s_booth.innerHTML = "";
                    boothList.forEach(booth => {
                        let option = document.createElement("option");
                        option.dataset.size = booth.size;
                        option.innerText = option.value = booth.name;
                        option.disabled = reservedList.includes(booth.name) ? true : false;
                        s_booth.append(option);
                    });
                }   
                else {
                    s_booth.innerHTML = "<option value=''>등록된 부스가 없습니다.</option>";
                }
            });
        }
        updateBooth();
    });
</script>