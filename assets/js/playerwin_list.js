$(document).ready(function(){
	$('input.datepicker').datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
    });

    resetTableAll();

    $("body").on('click', '.btnShowModal', function(){
        $("#btnSearch").attr("data-id", $(this).attr("data-id")); 
        loadAjaxTableCard($("select#cardNameId").val(), $("select#cardTypeId").val());
        $("#modalAddCard").modal('show');
    }).on('click', '#btnSearch', function(){
        loadAjaxTableCard($("select#cardNameId").val(), $("select#cardTypeId").val());
    }).on('click', '.btn_add_card', function(){
        var cardId = parseInt($(this).attr('data-id'));
        var customersAnticipateId = parseInt($("#btnSearch").attr('data-id'));
        if(cardId > 0 && customersAnticipateId > 0){
            $.ajax({
                type: "POST",
                url: $('input#urlSaveWin').val(),
                data: {
                    CardId: cardId,
                    CustomersAnticipateId: customersAnticipateId
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code)
                    if(json.code == 1){
                        loadAjaxTableCard($("select#cardNameId").val(), $("select#cardTypeId").val());
                        $(".btn_add_card").attr('data-id', 0);
                        resetTableAll();
                    }
                    $("#modalAddCard").modal('hide');
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }else showNotification("Có lỗi xảy ra, vui lòng thử lại.", 0);
        return false;
    }).on('click', '.btn-search', function(){
        var date = $("input#itemSearchName").val();
        // if(date.trim() != ''){
            $.ajax({
                type: "POST",
                url: $('button#btn-filter').attr('data-href'),
                data: {
                    searchText: date,
                    filterId: 0
                },
                success: function (response) {
                    resetTableAll()
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        // }else showNotification("Vui lòng chọn ngày.", 0);
        return false;
    });
    
});

function renderContents(data){
	console.log(data)
    var html = '';
    if(data!=null) {
        var labelCss = [];
        if(data.length > 0) labelCss = data[0].labelCss;
        var urlChangeCard = $('#urlDelete').val() + '/';
        let count = 0;
        for (var item = 0; item < data.length; item++) {
            count ++;
            html += '<tr>';
            html += '<td>'+data[item].FullName+'</td>'; 
            html += '<td>'+data[item].PhoneNumber+'</td>';
            html += '<td>'+data[item].Number+'</td>';
            html += '<td>'+data[item].Raffle+'</td>';
            html += '<td>'+ data[item].LrCrDateTime +'</td>';
            html += '<td>'+ data[item].InfoCard +'</td>';
            html += '<td>'+ data[item].UserCardUse +'</td>'; 
            html += '<td class="text-center">';
            html += data[item].AddCard;
            html +='</td>';
            html += '</tr>';
        }
        html += '<tr><td colspan="8" class="paginate_table"></td></tr>';
        $('#tbody').html(html);
    }
}

function loadAjaxTableCard(cardNameId, cardTypeId){
    $.ajax({
        type: "POST",
        url: $('input#urlLoadCard').val(),
        data: {
            CardNameId: cardNameId,
            CardTypeId: cardTypeId
        },
        success: function (response) {
            console.log(response)
            var json = $.parseJSON(response);
            if(json.code == 1){
                var data = json.data;
                var html = '';
                if(data!=null) {
                    for (var item = 0; item < data.length; item++) {
                        html += '<tr>';
                        html += '<td>'+data[item].CardSeri+'</td>'; 
                        html += '<td>'+data[item].CardNumber+'</td>'; 
                        html += '<td><a href="javascript:void(0)" style="color:#ffffff" class="btn btn-success btn-xs btn_add_card" data-id="'+data[item].CardId+'">Thêm</a></td>'; 
                        html += '</tr>';
                    }
                    $('#tbodyCard').html(html);
                }
            }
        },
        error: function (response) {
            showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
        }
    });
}

function resetTableAll(){
    actionItemAndSearch({
        ItemName: 'Danh sách trúng thưởng',
        IsRenderFirst: true,
        extendFunction: function(itemIds, actionCode){
        }
    });
}