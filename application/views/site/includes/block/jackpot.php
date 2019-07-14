<div id="services" class="services">
    <div class="container">
        <h2>NHẬP SỐ DỰ ĐOÁN</h2>
        <h3>CHỌN 2 SỐ VÀ NHẤN "<span>NHẬP SỐ</span>"</h3>
        <?php echo form_open('site/update', array('id' => 'inputNumberForm')); ?>
            <div class="input-group-t">
                <div class="services-left">
                    <div class="serw3agile-grid">
                        <span class="hi-icon hi-icon-archive glyphicon">
                            <input type="text" name="NumberOne" maxlength="1" class="cost hmdrequired" data-field="Số dự thưởng" />
                        </span>
                    </div>
                </div>
                <div class="services-right">
                    <div class="serw3agile-grid">
                        <span class="hi-icon hi-icon-archive glyphicon">
                            <input type="text" name="NumberTwo" maxlength="1" class="cost hmdrequired" data-field="Số dự thưởng" />
                        </span>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <button type="submit" class="btn btn-primary submit">NHẬP SỐ</button>
        </div>
        <div class="text-center">
            <div class="fb-share-button" data-href="<? echo base_url() ?>" data-layout="button" data-size="large">
            </div>
        </div>
        <?php echo form_close(); ?>
    </div>
</div>