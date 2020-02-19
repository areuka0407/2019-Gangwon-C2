<style>
    .image-map {
        height: 600px;
        background-position: -10px center;
        background-size: 100% 100%;
        background-repeat: no-repeat;
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
        <form method="post">
            <div class="section-title">
                <h5>FORM</h5>
            </div>
            <div class="row">
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
            </div>
            <div class="image-map" style="background-image: url(<?=$schedules[0]->imageData?>)"></div>
            <button class="btn btn-blue mt-3">신청하기</button>
        </form>
        <div class="row mt-5">
            <div class="col-12">
                <div class="section-title">
                    <h5>LIST</h5>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", () => {
        let s_schedule = document.querySelector("#schedule_id");
        let s_booth = document.querySelector("#booth_id");
        let $image = document.querySelector("#request-booth .image-map");

        s_schedule.addEventListener("input", e => {
            updateBooth();
        });

        s_booth.addEventListener("input", e => {
            
        });

        function updateBooth(){
            if(s_schedule.value.trim() === "") {
                s_booth.innerHTML = "<option value=''>등록된 부스가 없습니다.</option>";
                return;
            }

            let xhrDone = new Promise((res, rej) => {
                let xhr = new XMLHttpRequest();
                xhr.open("post", "/get-item/schedules/"+s_schedule.value);
                xhr.onload = () => res(xhr.responseText);
                xhr.onerror = () => rej(xhr.response);
                xhr.send();
            }).then(res => {
                let item = JSON.parse(res);
                let boothList = JSON.parse(item.boothList);
                $image.style.backgroundImage = `url(${item.imageData})`;
                $image.border = 1;
                
                if(boothList.length > 0){
                    s_booth.innerHTML = "";
                    boothList.forEach(booth => {
                        let option = document.createElement("option");
                        option.innerText = option.value = booth.name;
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