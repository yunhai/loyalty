jQuery(document).ready(function(){

	jQuery('.check-box-list li > input').click(function(){
		//$('.custom-loader').show();
		jQuery(this).parent().toggleClass('active');
		Stringfilter();
	})
	$('.filter-chose a').click(function(){
		jQuery(this).toggleClass('active');
		Stringfilter();
	})
	str = "";
	var Stringfilter = function(){
		var q="", gia="",vendor="",color="", size="",total_page=0, cur_page=1;
		var handle_coll = $('#coll-handle').val();
		var str_url = 'filter=';
		q = "("+handle_coll+")";
		jQuery('#price-filter ul.check-box-list li.active').each(function(){
			gia = gia + jQuery(this).find('input').data('price') + '||';
		})
		gia=gia.substring(0,gia.length -2);
		if(gia != ""){
			gia='('+gia+')';
			q+='&&'+gia;
		}
		jQuery('#vendor-filter ul.check-box-list li.active').each(function(){
			vendor = vendor + jQuery(this).find('input').data('vendor') + '||';
		})
		vendor=vendor.substring(0,vendor.length -2);
		if(vendor != ""){
			vendor='('+vendor+')';
			q+='&&'+vendor;
		}

		jQuery('.filter-color-container a.active').each(function(){
			color = color + jQuery(this).data('color') + '||';
			//size2 = size2 + jQuery(this).data('s') + '--';
		})
		color=color.substring(0,color.length -2);
		if(color != ""){
			color='('+color+')';
			q+='&&'+color;
		}

		jQuery('.filter-size-container a.active').each(function(){
			size = size + jQuery(this).data('size') + '||';
		})
		size=size.substring(0,size.length -2);
		if(size != ""){
			size='('+size+')';
			q+='&&'+size;
		}
		str_url += encodeURIComponent(q);
		str = str_url;
		jQuery.ajax({ // lấy tổng số trang của kết quả filter
			url: "/search?q="+str_url+"&view=page",	
			async: false,
			success:function(data){
				total_page = parseInt(data);
			}
		})
		//console.log(total_page);
		if(cur_page <= total_page){
			jQuery('.pagi').show();
			jQuery.ajax({
				url : "/search?q="+str_url+"&view=filter",
				success: function(data){
					jQuery(".product-list.filter").html(data);
				}
			})
			jQuery.ajax({  // đoạn code 
				url: "/search?q="+str_url+"&view=paginate",
				async: false,
				success:function(data){
					//jQuery(".pagi-filter").html(data); // in phân trang
					jQuery(".pagi").html(data); // in phân trang

				}
			})
		}else{
			jQuery(".product-list.filter").html("<div class='col-sm-12 col-xs-12 text-center no-product'><p>Không tìm thấy sản phẩm nào phù hợp!</p></div>");
			jQuery('.pagi').hide();
		}
		jQuery('.pagi').on("click","a",function(){ // bắt sự kiện click các nút phân trang
			var link = jQuery(this).attr("data-link");
			if(link == 'm'){
				link = cur - 1;
			}
			if(link == 'p'){
				link = cur + 1;
			}
			link = parseInt(link);
			jQuery.ajax({
				url : "/search?q="+str+"&view=filter&page="+link, 
				success: function(data){
					jQuery(".product-list.filter").html(data);
					cur = link;
				}
			})
			//console.log("/search?q="+str+"&view=paginate&page="+link);
			jQuery.ajax({ 
				url: "/search?q="+str+"&view=paginate&page="+link,	
				success:function(data){
					//jQuery(".pagi-filter").html(data); // in phân trang
					jQuery(".pagi").html(data); // in phân trang
				}
			})
		})
	}
	})