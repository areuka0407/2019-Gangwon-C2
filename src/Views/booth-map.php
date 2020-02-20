<style>
    #booth-map .form-group {
        position: absolute;
        left: 13px; bottom: 13px;
        padding: 20px 30px;
        background-color: #fffa;
        border-top: 2px solid #ddd;
        border-right: 2px solid #ddd;
        margin: 0;
    }
</style>

<div id="visual" class="no-move" style="height: 300px;">
    <div class="images">
        <div class="img" style="filter: brightness(30%);"></div>
    </div>
    <div class="container contents text-center">
        <p>관람 안내 > 부스 배치도</p>
        <h2>Festival Booth Map</h2>
    </div>
</div>

<div id="booth-map">
    <div class="container padding">
        <div class="row">
            <div class="col-12">
                <div class="section-title">
                    <h1 description="행사 내의 부스 배치를 한 눈에 알아보세요!">부스배치도</h1>
                </div>
            </div>
            <div class="col-12">
                <div class="section-title mb-3 pl-3">
                    <h5>MAP</h5>
                </div>
                <div class="position-relative">
                    <img class="image">
                    <div class="form-group">
                        <label for="s_schedule">행사 선택</label>
                        <select name="schedule" id="s_schedule" class="form-control" style="width: auto;">
                            <?php if(count($scheduleList) === 0):?>
                                <option value="">등록된 행사가 없습니다.</option>
                            <?php endif;?>
                            <?php foreach($scheduleList as $schedule):?>
                                <option value="<?=$schedule->id?>"><?=scheduleName($schedule)?></option>
                            <?php endforeach;?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="section-title pl-3 my-5">
                    <h5>LIST</h5>
                </div>
                <table class="table">
                    <thead>
                        <tr class="text-center">
                            <th>참가업체명</th>
                            <th>부스번호</th>
                            <th>전시품목</th>
                        </tr>
                    </thead>
                    <tbody class="text-center">
                        <tr>
                            <td class="text-center py-4" colspan="3">행사를 먼저 선택해 주시기 바랍니다.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    window.addEventListener("load", () => {
        let getSchedules = new Promise(res => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/get-list/schedules")
            xhr.onload = () => res(JSON.parse(xhr.responseText));
            xhr.send();
        });

        let getBooths = new Promise(res => {
            let xhr = new XMLHttpRequest();
            xhr.open("POST", "/get-list/booths")
            xhr.onload = () => res(JSON.parse(xhr.responseText));
            xhr.send();
        });

        Promise.all([getSchedules, getBooths]).then(response => {
            let [schedules, booths] = response;
            
            let $tableBody = document.querySelector("#booth-map .table tbody");
            let $image = document.querySelector("#booth-map .image");
            let s_schedule = document.querySelector("#s_schedule");
            s_schedule.addEventListener("input", () => {
                updateMap();
            });

            function updateMap(){
                if(s_schedule.value === "") return;
                let s_id = s_schedule.value;
                

                // 배치도 보여주기
                let item = schedules.find(x => x.id === s_id);
                $image.src = item.imageData;

                // 부스 보여주기
                let hasBooth = booths.filter(x => x.schedule_id === s_id);
                if(hasBooth.length > 0){
                    $tableBody.innerHTML = "";
                    hasBooth.forEach(booth => {
                        let tr = document.createElement("tr");
                        tr.innerHTML = `<td>${booth.userName}</td>
                                        <td>${booth.name}</td>
                                        <td>${booth.viewList}</td>`;
                        $tableBody.append(tr);
                    });
                }
                else $tableBody.innerHTML = `<tr> <td class="text-center py-4" colspan="3">이 행사에 참여 중인 기업이 없습니다.</td> </tr>`;
            }
            updateMap();
        });
    });
</script>