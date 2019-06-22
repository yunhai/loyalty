<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header no-pd-lr">
                <h1 class="ttl-list-order ft-seogeo"><?php echo $title; ?></h1>
            </section>
            <section class="content upn ft-seogeo">
                <div class="nav-tabs-custom updaten">
                    <ul class="nav nav-tabs" id="ulFilter">
                        <li class="active" id="liFilter_0"><a href="#tab_0" data-id="0" data-toggle="tab" aria-expanded="true">Tất cả</a></li>
                    </ul>
                </div>
                <div class="input-group margin col-sm-3">
                    <input type="text" class="form-control datepicker" id="itemSearchName" value="19/06/2019">
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-info btn-flat btn-search ">Tìm kiếm</button>
                        </span>
                  </div>
                <div class="input-group margin ctrl-filter updaten">
                    <div class="input-group-btn dropdown" id="searchGroup">
                        <div class="dropdown-menu mt10 pos-arrow-dropdown animate-scale-dropdown  none-display" role="menu" >
                            <form class="form-inline">
                                <div class="form-group none-display widthauto">
                                    <button id="btn-filter" data-href="<?php echo base_url('playerwin/searchByFilter'); ?>" type="submit" data-toggle="dropdown" class="btn btn-default">Thêm điều kiện lọc</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <!-- <input type="text" class="form-control" id="itemSearchName" placeholder="Nhập ngày" value="19/06/2019" /> -->
                </div>

                <div class="mb10 mgt-10">
                    <ul id="container-filters"></ul>
                </div>
                <div class="">
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table new-style table-hover table-bordered" id="table-data">
                            <thead>
                            <tr>
                                <th class="">Tên người <br> trúng thưởng</th>
                                <th class="">Sô điện thoại</th>
                                <th class="">Số khách <br> dự đoán</th>
                                <th class="">Số <br> đài sổ</th>
                                <th class="">Ngày xổ</th>
                                <th class="">Nhận card</th>
                                <th class="">Trạng thái <br> nhận card</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                </div>
            </section>
        </div>
    </div>
    <div class="modal fade" id="modalAddCard" tabindex="-1" role="dialog" aria-labelledby="modalItemComment">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="box-title"><i class="fa fa-comments-o"></i>Card</h4>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-sm-12 form-group">
                        <div class="row">
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">Tên nhà mạng</label>
                                    <?php $this->Mconstants->selectConstants('homeNetwork', 'CardNameId', 1, true, '-- Chọn nhà mạng --'); ?>
                                </div>
                            </div>
                            <div class="col-sm-5">
                                <div class="form-group">
                                    <label class="control-label">Mệnh giá (*)</label>
                                    <?php $this->Mconstants->selectConstants('typeCard', 'CardTypeId', 3, true, '-- Chọn mệnh giá --'); ?>
                                </div>
                            </div>
                            <div class="col-sm-2" style="top:24px;">
                                <button type="button" class="btn btn-primary" data-id='0' id="btnSearch">Tìm</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-12 form-group">
                        <table class="table new-style table-hover table-bordered">
                            <thead>
                            <tr>
                                <th class="">Số Seri</th>
                                <th class="">Mã cào</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbodyCard"></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Đóng</button>
                <input type="hidden" id="urlLoadCard" value="<?php echo base_url('card/loadListTable') ?>">
                <input type="hidden" id="urlSaveWin" value="<?php echo base_url('playerwin/update') ?>">
            </div>
        </div>
    </div>
</div>
<?php $this->load->view('includes/footer'); ?>