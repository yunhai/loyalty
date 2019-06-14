$(document).ready(function () {
    $(".fancybox").fancybox({
        openEffect: 'none',
        closeEffect: 'none'
    });
    $.each($('.list-color >span'), function (index, val) {
        $(val).css('background', $(val).data('color'));
    });

    var nav = $('#detail-two');
    $(window).scroll(function () {
        if ($(this).scrollTop() > 815) nav.addClass("fixed");
        else nav.removeClass("fixed");
    });
    $(".product-thumb img").click(function () {
        $(".product-thumb").removeClass('active');
        $(this).parents('li').addClass('active');
        $(".product-image-feature").attr("src", $(this).attr("data-image"));
        $(".product-image-feature").attr("data-zoom-image", $(this).attr("data-zoom-image"));
    });
    $(".product-thumb").first().addClass('active');


    //function select attribute
    $('.attribute_chosen span').click(function (event) {
        var parent_ = $(this).parent();
        if (parent_.find('.active').length > 0)
            parent_.find('.active').removeClass('active');
        $(this).addClass('active');
        if ($('.attribute_chosen span.active').length == $('.attribute_chosen').length) findProductInfo();
    });
    //update Product infomation
    function findProductInfo() {
        var productName = [];
        var productInfo = null;
        $.each($('.attribute_chosen span.active'), function (index, val) {
            productName.push($(val).text());
        });
        productName = productName.join(' - ');

        for (var i = 0; i < variantProduct.length; i++) {
            if (variantProduct[i]['ProductName'] == productName)
                productInfo = variantProduct[i];
        }
        if (productInfo != null) updateProductInfo(productInfo);
    }

    $('span.check_active').each(function () {
        var productInfo = null;
        var txtSpan = $(this).text();
        var activeSpan = $(this);
        for (var i = 0; i < variantProduct.length; i++) {
            if (variantProduct[i]['Price'] == minPrice) {
                productInfo = variantProduct[i]['ProductName'];
            }
        }

        var strx = productInfo.split(' - ');
        var array = [];
        array = array.concat(strx);
        $.each(array, function (key, value) {
            if (value == txtSpan) {
                activeSpan.addClass("active");
            }
        });
    });

    var productPath = $('#productPath').val();
    function updateProductInfo(productInfo) {
        $('.current').text(formatDecimal(productInfo.Price) + '₫');
        $('.sku-product b').text(productInfo.Sku);
        $('.swiper-slide-active img').attr('src', productPath + productInfo.ProductImage);
        $('#productChildChosen').attr('value', productInfo.ProductChildId);
    }

    function formatDecimal(value) {
        value = value.replace(/\,/g, '');
        while (value.length > 1 && value[0] == '0' && value[1] != '.') value = value.substring(1);
        if (value != '' && value != '0') {
            if (value[value.length - 1] != '.') {
                if (value.indexOf('.00') > 0) value = value.substring(0, value.length - 3);
                value = addCommas(value);
                return value;
            }
            else return value;
        }
        else return 0;
    }


    function addCommas(nStr) {
        nStr += '';
        var x = nStr.split('.');
        var x1 = x[0];
        var x2 = x.length > 1 ? '.' + x[1] : '';
        var rgx = /(\d+)(\d{3})/;
        while (rgx.test(x1)) {
            x1 = x1.replace(rgx, '$1' + ',' + '$2');
        }
        return x1 + x2;
    }


    $('.btn-consult').click(function (event) {
        $('#ConsultModal').modal('show');
    });

    $('.btn-consult-submit').click(function () {
        var nameConsult = $('#nameConsult').val().trim();
        var phoneConsult = $('#phoneConsult').val().trim();
        if (phoneConsult == '' || phoneConsult.length < 6 || isNaN(phoneConsult)) {
            $('.consultInform').text('Hãy nhập thông tin chính xác để chúng tôi có thể liên lạc với bạn!');
            return false
        }
        var products = [{
            ProductId: $('.btn-consult').attr('data-id'),
            ProductChildId: 0,
            Comment: ''
        }];
        $.ajax({
                url: $('#baseUrl').attr('href') + 'customerconsult/update',
                type: 'POST',
                dataType: 'json',
                data: {
                    CustomerConsultId: 0,
                    ConsultTitle: 'Xin tư vấn lại sản phẩm ' + $('h1.product-title').text(),
                    FullName: nameConsult,
                    PhoneNumber: phoneConsult,
                    Products: JSON.stringify(products),
                    Comments: '[]',
                    IsFront: 1
                }
            })
            .done(function (data) {
                if (data.code == 1) $('.form-consult').slideUp();
                $('.consultInform').text(data.message);
            })
    });

    $('#nameConsult, #phoneConsult').on('keypress', function () {
        $('.consultInform').text('');
    });
});
