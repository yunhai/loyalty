<?php if($user): ?>
<div id="rewarded" class="rewarded">
    <div class="container" id="container-bac" style="display: none">
        <h1 class="title">Lịch sử trúng thưởng</h1>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th class="col-xs-6">Ngày chơi</th>
                    <th class="text-center col-xs-6">Giải thưởng</th>
                </tr>
            </thead>
            <tbody id="tbody-bac"></tbody>
        </table>
    </div>
</div>
<?php $this->load->view('site/includes/popup/jackpot'); ?>
<?php endif ?>