function chooseProduct(fnChooseProduct){
    var panelProduct = $('#panelProduct');
    var pageIdProduct = $('input#pageIdProduct');
    $(document).on('click','.open-search',function(){
        panelProduct.removeClass('active');
        $('.wrapper').removeClass('open-search');

    }).on('click', '.panel-default.active', function(e) {
        e.stopPropagation();
    });
    var statusSearch = null;
    $('#txtSearchProduct').click(function(){
        if(panelProduct.hasClass('active')){
            panelProduct.removeClass('active');
            panelProduct.find('.panel-body').css("width", "99%");
        }
        else{
            panelProduct.addClass('active');
            setTimeout(function (){
                panelProduct.find('.panel-body').css("width", "100%");
                $('.wrapper').addClass('open-search');
            }, 100);
            pageIdProduct.val('1');
            getListProducts();
        }
    }).keydown(function () {
        if (statusSearch != null) {
            clearTimeout(statusSearch);
            statusSearch = null;
        }
    }).keyup(function () {
        if (statusSearch == null) {
            statusSearch = setTimeout(function () {
                if(!panelProduct.hasClass('active')){
                    panelProduct.addClass('active');
                    setTimeout(function (){
                        panelProduct.find('.panel-body').css("width", "100%");
                        $('.wrapper').addClass('open-search');
                    }, 100);
                }
                pageIdProduct.val('1');
                getListProducts();
            }, 500);
        }
    });
    $('select#categoryId').change(function(){
        pageIdProduct.val('1');
        getListProducts();
    });
    $('#btnPrevProduct').click(function(){
        var pageId = parseInt(pageIdProduct.val());
        if(pageIdProduct > 1){
            pageIdProduct.val(pageId - 1);
            getListProducts();
        }
    });
    $('#btnNextProduct').click(function(){
        var pageId = parseInt(pageIdProduct.val());
        pageIdProduct.val(pageId + 1);
        getListProducts();
    });
    $('#tbodyProductSearch').on('click', 'tr', function () {
        panelProduct.removeClass('active');
        panelProduct.find('.panel-body').css("width", "99%");
        $('#txtSearchProduct').val('');
        $('select#categoryId').val('0');
        pageIdProduct.val('1');
        fnChooseProduct($(this));
    });
}

function getListProducts(){
    var loading = $('#panelProduct .search-loading');
    loading.show();
    $('#tbodyProductSearch').html('');
    $.ajax({
        type: "POST",
        url: $('input#getListProductUrl').val(),
        data: {
            SearchText: $('input#txtSearchProduct').val().trim(),
            CategoryId: $('select#categoryId').val(),
            PageId: parseInt($('input#pageIdProduct').val()),
            Limit: 10
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1){
                loading.hide();
                var data = json.data;
                var html = '';
                var i, j;
                var productPath = $('input#productPath').val();
                var noImage = 'logo.png';
                for(i = 0; i < data.length; i++){
                    html += '<tr class="pProduct" data-id="' + data[i].ProductId + '" data-child="0">';
                    html += '<td><img src="' + productPath + (data[i].ProductImage == '' ? noImage : data[i].ProductImage) + '" class="productImg"></td>';
                    html += '<td class="productName">' + data[i].ProductName + '</td>';
                    html += '<td>' + data[i].BarCode + '</td>';
                    html += '<td class="text-right">' + formatDecimal(data[i].Price.toString()) + '</td>';
                    html += '<td>' + data[i].GuaranteeMonth + ' tháng</td></tr>';
                    if(data[i].Childs.length > 0){
                        for(j = 0; j < data[i].Childs.length; j++){
                            html += '<tr class="cProduct" data-id="' + data[i].ProductId + '" data-child="' + data[i].Childs[j].ProductChildId + '">';
                            html += '<td><img src="' + productPath + (data[i].Childs[j].ProductImage == '' ? noImage : data[i].Childs[j].ProductImage) + '" class="productImg"></td>';
                            html += '<td class="productName">' + data[i].ProductName + ' (' + data[i].Childs[j].ProductName + ')</td>';
                            html += '<td>' + data[i].Childs[j].BarCode + '</td>';
                            html += '<td class="text-right">' + formatDecimal(data[i].Childs[j].Price.toString()) + '</td>';
                            html += '<td>' + data[i].GuaranteeMonth + ' tháng</td></tr>';
                        }
                    }
                }
                $('#tbodyProductSearch').html(html);
                $('#panelProduct .panel-body').slimScroll({
                    height: '300px',
                    alwaysVisible: true,
                    wheelStep: 20,
                    touchScrollStep: 500
                });
            }
            else loading.text('Có lỗi xảy ra').show();
        },
        error: function (response) {
            //showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            loading.text('Có lỗi xảy ra').show();
        }
    });
}

function chooseCustomer(fnChooseCustomer, customerKindId){
    if(typeof(customerKindId) == 'undefined') customerKindId = 0;
    var panelCustomer = $('#panelCustomer');
    var pageIdCustomer = $('input#pageIdCustomer');
    $(document).on('click','.open-search-customer',function(){
        panelCustomer.removeClass('active');
        $('.wrapper').removeClass('open-search-customer');

    }).on('click', '.panel-default.active', function(e) {
        e.stopPropagation();
    });
    var statusSearch = null;
    $('#txtSearchCustomer').click(function () {
        if (panelCustomer.hasClass('active')) {
            panelCustomer.removeClass('active');
            panelCustomer.find('panel-body').css("width", "99%");
        }
        else {
            panelCustomer.addClass('active');
            setTimeout(function () {
                panelCustomer.find('panel-body').css("width", "100%");
                $('.wrapper').addClass('open-search-customer');
            }, 100);
            pageIdCustomer.val('1');
            getListCustomers(customerKindId);
        }
    }).keydown(function () {
        if (statusSearch != null) {
            clearTimeout(statusSearch);
            statusSearch = null;
        }
    }).keyup(function () {
        if (statusSearch == null) {
            statusSearch = setTimeout(function () {
                if(!panelCustomer.hasClass('active')){
                    panelCustomer.addClass('active');
                    setTimeout(function (){
                        //$("#panelProduct .panel-body").css("width", "100%");
                        panelCustomer.find('.panel-body').css("width", "100%");
                        $('.wrapper').addClass('open-search');
                    }, 100);
                }
                pageIdCustomer.val('1');
                getListCustomers(customerKindId);
            }, 500);
        }
    });
    $('#btnPrevCustomer').click(function () {
        var pageId = parseInt(pageIdCustomer.val());
        if (pageId > 1) {
            pageIdCustomer.val(pageId - 1);
            getListCustomers(customerKindId);
        }
    });
    $('#btnNextCustomer').click(function () {
        var pageId = parseInt(pageIdCustomer.val());
        pageIdCustomer.val(pageId + 1);
        getListCustomers(customerKindId);
    });
    $('#ulListCustomers').on('click', 'li.row', function () {
        panelCustomer.removeClass('active');
        //$("#panelCustomer .panel-body").css("width", "99%");
        panelCustomer.find('panel-body').css("width", "99%");
        $('#txtSearchCustomer').val('');
        pageIdCustomer.val('1');
        fnChooseCustomer($(this));
    });
}

function getListCustomers(customerKindId){
    var loading = $('#panelCustomer .search-loading');
    loading.show();
    $('#ulListCustomers').html('');
    $.ajax({
        type: "POST",
        url: $('input#getListCustomerUrl').val(),
        data: {
            SearchText: $('input#txtSearchCustomer').val().trim(),
            CustomerKindId: customerKindId,
            PageId: parseInt($('input#pageIdCustomer').val()),
            Limit: 10
        },
        success: function (response) {
            var json = $.parseJSON(response);
            if (json.code == 1){
                loading.hide();
                var data = json.data;
                var html = '';
                for(var i = 0; i < data.length; i++){
                    html += '<li class="row" data-id="' + data[i].CustomerId + '"><div class="wrap-img inline_block vertical-align-t radius-cycle"><img class="thumb-image radius-cycle" src="assets/vendor/dist/img/users.png" title="" /></div><div class="inline_block ml10">';
                    html += '<p class="pCustomerName">' + data[i].FullName + '</p><p>' + data[i].PhoneNumber;
                    if(data[i].PhoneNumber2 != '') html += ' - ' + data[i].PhoneNumber2;
                    html += '</p></div></li>';
                }
                $('#ulListCustomers').html(html).slimScroll({
                    height: '250px',
                    alwaysVisible: true,
                    wheelStep: 20,
                    touchScrollStep: 500,
                    color: '#3c8dbc'
                });
            }
            else loading.text('Có lỗi xảy ra').show();
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
            loading.hide();
        }
    });
}