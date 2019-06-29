<?php $this->load->view('includes/header'); ?>
    <div class="content-wrapper">
        <div class="container-fluid">
            <section class="content-header no-pd-lr">
                <h1 class="ttl-list-order ft-seogeo"><?php echo $title; ?></h1>
                <ul class="list-inline new-stl">
                    <li><a href="<?php echo base_url('card/add'); ?>"  class="btn btn-primary">Thêm Card</a></li>
                </ul>
            </section>
            <section class="content upn ft-seogeo">
                <div class="nav-tabs-custom updaten">
                    <ul class="nav nav-tabs" id="ulFilter">
                        <li class="active" id="liFilter_0"><a href="#tab_0" data-id="0" data-toggle="tab" aria-expanded="true">Tất cả</a></li>
                    </ul>
                </div>
                <div class="input-group margin ctrl-filter updaten" style="display: none">
                    <div class="input-group-btn dropdown" id="searchGroup">
                        <div class="dropdown-menu mt10 pos-arrow-dropdown animate-scale-dropdown" role="menu">
                            <form class="form-inline">
                                <div class="form-group block-display widthauto">
                                    <button id="btn-filter" data-href="<?php echo base_url('card/searchByFilter'); ?>" type="submit" data-toggle="dropdown" class="btn btn-default">Thêm điều kiện lọc</button>
                                </div>
                            </form>
                        </div>
                    </div>
                    <input type="text" class="form-control" id="itemSearchName" placeholder="Nhập thông tin tìm kiếm" />
                    <span class="input-group-btn">
                        <button id="remove-filter" data-href="<?php echo base_url('filter/delete'); ?>" type="button" disabled class="btn btn-disable"><i class="fa fa-times"></i></button>
                    </span>
                </div>
                <div class="mb10 mgt-10">
                    <ul id="container-filters"></ul>
                </div>
                <div class="">
                    <div class="box-body table-responsive no-padding divTable">
                        <table class="table new-style table-hover table-bordered" id="table-data">
                            <thead>
                            <tr>
                                <th>Nhà mạng</th>
                                <th>Mã card</th>
                                <th>Mã vạch</th>
                                <th class="text-center">Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                            </thead>
                            <tbody id="tbody"></tbody>
                        </table>
                    </div>
                    <input type="hidden" id="urlEdit" value="<?= base_url('card/edit') ?>">
                    <input type="hidden" id="urlDelete" value="<?= base_url('card/delete') ?>">

                </div>
            </section>
        </div>
    </div>
<?php $this->load->view('includes/footer'); ?>