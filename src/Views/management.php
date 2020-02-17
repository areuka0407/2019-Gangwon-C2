<!-- MANAGEMENT -->
<div id="management">
        <div class="container-fluid padding">
            <div class="section-title center">
                <h1 description="축제 진행 기간 중, 전시할 수 있는 공간을 배정합니다.">BEXCO 내 부스 관리</h1>
            </div>
            <div class="row pt-4">
                <div class="col-md-2 col-sm-12 py-3">
                    <div class="section-title mb-5 center">
                        <h5>SAVE</h5>
                    </div>
                    <div class="save-list">

                    </div>
                </div>
                <div class="col-md-8 col-sm-12 py-3">
                    <div class="section-title mb-5 center">
                        <h5>LAYOUT</h5>
                    </div>
                    <div class="contents">
                    </div>
                    <div id="booth-form">

                    </div>
                </div>
                <div class="col-md-2 col-sm-12 py-3">
                    <div class="section-title mb-5 center">
                        <h5>TYPE</h5>
                    </div>
                    <div class="type-list d-flex flex-column align-items-center">
                    </div>
                </div>
            </div>
        </div>
        <input type="checkbox" id="form-fade" hidden checked>
        <div id="manage-form">
            <label for="form-fade">
                <i class="show fa fa-chevron-up"></i>
                <i class="hide fa fa-chevron-down"></i>
            </label>
            <div class="row">
                <div class="form-group col-md-6 col-sm-12 my-2">
                    <label for="booth-id">부스 선택하기</label>
                    <select name="booth-id" id="booth-id" class="form-control">
                        <option value="">부스를 선택하세요.</option>
                    </select>
                </div>
                <div class="form-group col-md-6 col-sm-12 my-2">
                    <label>부스 색상</label>
                    <div id="booth-color"></div>
                </div>
                <div class="form-group col-md-6 col-sm-12 my-2 mb-0">
                    <label>선택한 면적</label>
                    <div id="select-size"><span class="pr-1">0</span>㎡</div>
                </div>
                <div class="form-group col-md-6 col-sm-12 my-2 d-flex align-items-end mb-0">
                    <button id="btn-save" class="mr-2 btn btn-primary">저장하기</button>
                    <button id="btn-delete" class="btn btn-light">삭제하기</button>
                </div>
            </div>
        </div>
    </div>
    <script src="/js/management/App.js"></script>
    <script src="/js/management/Canvas.js"></script>
    <script src="/js/management/Booth.js"></script>
    <script>
        window.addEventListener("load", () => {
            let boothMap = new App("#management");
        });
    </script>