var baseUrl = $('#baseUrl').attr('href');

$(document).ready(function(){
	//if($('.cart-page').length == 0){
		getCartModal();
		$.ajax({
				url: baseUrl + 'cart/getSelectAddress',
				type: 'GET',
				dataType: 'json'
			})
			.done(function(data) {
				$('.wrap-contries-select').append(data.countries);
				$('.wrap-provinces-select').append(data.provinces);
				$('.wrap-districts-select').append(data.districts);
				$('.wrap-wards-select').append(data.wards);
				province();
				$('select#countryId').change(function () {
					if ($(this).val() == '232' || $(this).val() == '0') {
						$('.VNoff').hide();
						$('.VNon').fadeIn();
					}
					else {
						$('.VNon').hide();
						$('.VNoff').fadeIn();
					}
				});
			});
	//}
	//else $('#cartModal').remove();
	$(document).on('click','.Addcart', function(e){
		e.preventDefault();
		var id = $(this).data('id');
		var qty = 1;
		var productChild = 0;
		if($(this).hasClass('detail-p')){
			if($('#productChildChosen').val() > 0) productChild = $('#productChildChosen').val();
			qty = $('.quantity-selector .number').text();
		}
		$.ajax({
				url: baseUrl + 'cart/add',
				type: 'POST',
				dataType: 'json',
				data: {
					id: id,
					qty: qty,
					productChild: productChild
				}
			})
			.done(function(data) {
				if(!data.error){
					$('.count_cart_page').text(data.totalItems);
					if($('.cart-page').length == 0){
						$('.checkout-info').text('');
						$('#cartModal').modal('show');
						getCartModal();
					}
				}
			})
			.fail(function() {
			});
	});

	$(document).on('click','.delcart', function(e){
		e.preventDefault();
		var this_ = $(this);
		var id = $(this).data('id');
		$.ajax({
				url: baseUrl + 'cart/delete',
				type: 'POST',
				dataType: 'json',
				data: {id: id}
			})
			.done(function(data) {
				if(!data.error){
					$('.count_cart_page').text(data.totalItems);
					this_.parents('.product-item').fadeOut().next().fadeOut();
				}
			})
			.fail(function() {
			});
	});

	$(document).on('click','.update-cart', function(e){
		e.preventDefault();
		var this_ = $(this);
		var updateCart = {};
		$.each($('.product-item'), function(index, val) {
			updateCart['qty_' + $(val).data('id')] = $(val).find('.input-qty').val();
		});
		$.ajax({
				url: baseUrl + 'cart/update',
				type: 'POST',
				dataType: 'json',
				data: updateCart
			})
			.done(function(data) {
				getCartModal();
				$('.count_cart_page').text(data.totalItems);
			})
	});

	$('.checkout').click(function(event) {
		if(!$('.open-form').is(':visible')) $('.open-form').slideDown();
		else{
			if($('.panel-body .product-item').length == 0){
				$('.checkout-info').text('Giỏ hàng rỗng!');
				return false;
			}
			$('.focus-i').focus(function(event) {
				$('.checkout-info').text('');
			});
			var phone = $('#phone').val().trim();
			if(phone == ''){
				$('.checkout-info').text('Bạn cần nhập số điện thoại để được chăm sóc!');
				return false;
			}
			$('.checkout').prop('disabled', true);
			var products = [];
			var quantity = 0;
			var price = 0;
			var orderCost = 0;
			$('.cart-box .panel-body .product-item').each(function () {
				var productId = $(this).attr('data-id');
				if($(this).attr('data-child') != '0') productId = parseInt(productId.replace($(this).attr('data-child'), ""));
				quantity = replaceCost($(this).find('.input-qty').val(), true);
				price = replaceCost($(this).find('.spanPrice').text(), true);
				orderCost += quantity * price;
				products.push({
					ProductId: productId,
					ProductChildId: parseInt($(this).attr('data-child')),
					Quantity: quantity,
					Price: price
				});
			});
			var comments = [];
			var comment = $('#note').val().trim();
			if(comment != '') comments.push(comment);

			var customerInfo = {
				CustomerEmail: '',//$('#email').val(),
				CountryId: 0,//$('#countryId').val(),
				ProvinceId: 0,//$('#provinceId').val(),
				DistrictId: 0,//$('#districtId').val(),
				WardId: 0,//$('#wardId').val(),
				CustomerAddress: $('#address').val().trim(),
				ZipCode: '',//$('#zipCode').val().trim()
			};
			var inputLinkAffId = $('input#linkAffId');
			$.ajax({
				type: "POST",
				url: baseUrl + 'customerconsult/insertFromWeb',
				data: {
					CustomerId: 0,
					ConsultTitle: 'Khách đặt hàng trên web',
					FullName: $('#name').val().trim(),
					PhoneNumber: $('#phone').val().trim(),
					CustomerInfo: JSON.stringify(customerInfo),
					CTVId: getURLParameter('ctv_id', inputLinkAffId.length > 0 ? inputLinkAffId.val() : 0),

					Products: JSON.stringify(products),
					Comments: JSON.stringify(comments),

					LinkAffId: getURLParameter('affiliate_id', inputLinkAffId.length > 0 ? $('input#ctvId').val() : 0),
					AffiliateName: getURLParameter('affiliate_name', 'Ricky'),
					OfferId: getURLParameter('offer_id', 1),
					OfferName: getURLParameter('offer_name', 'Ricky'),
					CouponCode: $("input.coupon-code").val().trim(),

				},
				success: function (response) {
					var json = $.parseJSON(response);
					if (json.code == 1){
						$('.cart-box .panel-body').text('Chúc mừng bạn đã đặt đơn hàng thành công!');
						$('.cart-box .panel-footer').slideUp();
						$('.count_cart_page').text('0');
						$.get(baseUrl + 'cart/destroy', function(){});
					}
					else $('.checkout-info').text('Có lỗi xảy ra trong quá trình thực hiện');
					$('.checkout').prop('disabled', false);

					$("input.coupon-code").val("");
				},
				error: function (response) {
					$('.checkout-info').text('Có lỗi xảy ra trong quá trình thực hiện');
					$('.checkout').prop('disabled', false);
				}
			});
		}
	});
});

function province(provinceIdStr, districtIdStr, wardIdStr) {
	if(typeof(provinceIdStr) == 'undefined'){
		provinceIdStr = 'provinceId';
		districtIdStr = 'districtId';
		wardIdStr = 'wardId';
	}
	var selPro = $('select#' + provinceIdStr);
	if (selPro.length > 0) {
		var selDistrict = $('select#' + districtIdStr);
		var selWard = $('select#' + wardIdStr);
		selDistrict.find('option').hide();
		selDistrict.find('option[value="0"]').show();
		var provinceId = selPro.val();
		if (provinceId != '0') selDistrict.find('option[data-id="' + provinceId + '"]').show();
		selPro.change(function () {
			selDistrict.find('option').hide();
			provinceId = $(this).val();
			if (provinceId != '0') selDistrict.find('option[data-id="' + provinceId + '"]').show();
			selDistrict.val('0');
			//selWard.val('0');
			selWard.html('<option value="0">--Chọn--</option>');
		});
		var districtId = selDistrict.val();
		if (districtId != '0') getListWard(districtId, selWard, selWard.attr('data-id'));
		selDistrict.change(function () {
			districtId = $(this).val();
			if (districtId != '0') getListWard(districtId, selWard, 0);
		});
	}
}

function getListWard(districtId, selWard, wardId){
	$.ajax({
		type: "POST",
		url: $('input#getListWardUrl').val(),
		data: {
			DistrictId: districtId
		},
		success: function (response) {
			var data = $.parseJSON(response);
			var html = '<option value="0">--Chọn--</option>';
			for(var i = 0; i < data.length; i++) html += '<option value="' + data[i].WardId + '">' + data[i].WardName + '</option>';
			selWard.html(html).val(wardId);
		},
		error: function (response) {
			selWard.html('<option value="0">--Chọn--</option>');
		}
	});
}

function getCartModal(){
	var cartbox = $('.cart-box.cart-page');
	if($('.cart-page').length == 0) cartbox = $('#cartModal .cart-box');
	$.ajax({
		url: baseUrl + 'cart/getCart',
		type: 'GET',
		dataType: 'json'
	})
	.done(function(data) {
		var html = '';
		var totalMoney = 0;
		var productPath = 'assets/uploads/products';
		$.each(data.carts, function(index, item) {
			totalMoney += item['price'] * item['qty'];

			html +=	'<div class="row product-item" data-child="' + item['product_child'] + '" data-id="' + item['id'] + '">';
			html +=	    '<div class="col-xs-3 col-md-1">';
			html +=	        '<img width="100px" class="img-responsive" src="' + productPath + item['image_link'] + '">';
			html +=	    '</div>';
			html +=	    '<div class="col-xs-9 col-md-3">';
			html +=	        '<h4 class="product-name"><strong>' + item['name'] + '</strong></h4>';
			html +=	        '<h4 class="product-name"><strong>' + item['child_name'] + '</strong></h4>';
			html +=	        '<h4><small>Sku: <b>' + item['sku'] + '</b></small></h4>';
			html +=	    '</div>';
			html +=	    '<div class="col-xs-5 col-md-2">';
			html +=	        '<strong>BH: ' + item['guaranteemonth'] + ' tháng</strong>';
			html +=	    '</div>';
			html +=	    '<div class="col-xs-12 col-sm-9 col-md-6 col-price">';
			html +=	        '<div class="col-xs-4 text-right col-md-4 xs-price">';
			if (item['old_price'] > 0)
			{
				html +=	            '<h6 class=" line-thr">';
				html +=	                            '<strong>'+ formatDecimal(item['old_price'].toString()) +' đ</strong>';
				html +=	                        '</h6>';
				html +=	            '<h6 class="mgt-5">';
				html +=	                            '<strong class="spanPrice">'+ formatDecimal(item['price'].toString()) +' đ </strong>';
				html +=	                        '</h6>';
			}
			else
			{
				html +=		'<h6 class="mgt-9"><strong class="spanPrice">'+ formatDecimal(item['price'].toString()) +' đ </strong></h6>'
			}
			
			html +=	        '</div>';
			html +=	        '<div class="col-xs-3 col-md-3">';
			html +=	            'x';
			html +=	            '<input type="number" class="input-qty" min="1" value="' + item['qty'] + '">';
			html +=	        '</div>';
			html +=	        '<div class="col-xs-4 mgt-7 col-md-3 xs-price">';
			html +=	            '= <strong>' + formatDecimal((item['price'] * item['qty']).toString()) + ' đ</strong>';
			html +=	        '</div>';
			html +=	        '<div class="col-xs-1 xs-pd-0 col-md-2">';
			html +=	            '<button type="button" class="btn btn-link btn-xs">';
			html +=	                '<span class="glyphicon glyphicon-trash delcart" data-id="' + item['id'] + '"></span>';
			html +=	            '</button>';
			html +=	        '</div>';
			html +=	    '</div>';
			html +=	'</div>';
			html +=	'<hr>';

		});

		if(html == '') html += 'Giỏ hàng rỗng !';
		cartbox.find('.panel-body').html(html);
		var couponCode = $("input.coupon-code").val().trim();
		if(couponCode != ""){
			var products = getAllCartProduct();
			$.ajax({
                type: 'POST',
                url: baseUrl + 'promotion/checkPromotion',
                data: {
                    Products: products,
                    PromotionCode: couponCode,
                    CustomerId: 0,
                    CustomerGroupId: 0,
                    TotalPrice: totalMoney,
                    TransportCost: 0,
                    ProvinceId: 0,
                    OrderId: 0,
                    Comment: ""
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    console.log(json);
                    $("p.checkout-coupon-code").text('');
                    if (json.code == 1) {
                        var discountCost = json.data.DiscountCost;
                        var total = parseFloat(totalMoney) - parseFloat(discountCost);
                        $('.totalMoney').text(formatDecimal(total.toString()) + 'đ');
                    }
                    else{
                    	$("p.checkout-coupon-code").text(json.message);
                    	$('.totalMoney').text(formatDecimal(totalMoney.toString()) + 'đ');
                    } 
                },
                error: function (response) {
                	$("p.checkout-coupon-code").text('Có lỗi xảy ra trong quá trình thực hiện');
                }
            });
		}else $('.totalMoney').text(formatDecimal(totalMoney.toString()) + 'đ');

	})
	.fail(function() {
	});
}

function getAllCartProduct(){
	var products = [];
	var quantity = 0;
	var price = 0;
	var orderCost = 0;
	$('.cart-box .panel-body .product-item').each(function () {
		var productId = $(this).attr('data-id');
		if($(this).attr('data-child') != '0') productId = parseInt(productId.replace($(this).attr('data-child'), ""));
		quantity = replaceCost($(this).find('.input-qty').val(), true);
		price = replaceCost($(this).find('.spanPrice').text(), true);
		orderCost += quantity * price;
		products.push({
			ProductId: productId,
			ProductChildId: parseInt($(this).attr('data-child')),
			Quantity: quantity,
			Price: price
		});
	});
	return products;
}

function replaceCost(cost, isInt) {
    cost = cost.replace(/\,/g, '');
    if (cost == '') cost = 0;
    if (isInt) return parseInt(cost);
    else  return parseFloat(cost);
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

function getURLParameter(sParam, defaultValue) {
	var sPageURL = window.location.search.substring(1);
	var sURLVariables = sPageURL.split('&');
	for (var i = 0; i < sURLVariables.length; i++) {
		var sParameterName = sURLVariables[i].split('=');
		if (sParameterName[0] == sParam) {
			return sParameterName[1];
		}
	}
	return defaultValue;
}