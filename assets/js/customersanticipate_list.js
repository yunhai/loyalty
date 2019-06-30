var app = app || {};
app.init = function () {
};
$(document).ready(function(){
    actionItemAndSearch({
        ItemName: 'Cards',
        IsRenderFirst: true,
        extendFunction: function(itemIds, actionCode){
        }
    });

    $("#tbody").on("click", "a.link_delete", function(){
        if(confirm('Bạn có thực sự muốn xóa ?')){
            var id = $(this).attr('data-id');
            $.ajax({
                type: "POST",
                url: $('input#urlDelete').val(),
                data: {
                    CustomersAnticipateId: id,
                },
                success: function (response) {
                    var json = $.parseJSON(response);
                    showNotification(json.message, json.code);
                    redirect(true, '');
                },
                error: function (response) {
                    showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
                }
            });
        }
        return false;
    });
});

function renderContents(data){
    var html = '';
    if(data!=null) {
        var labelCss = [];
        if(data.length > 0) labelCss = data[0].labelCss;
        var urlDelete = $('#urlDelete').val() + '/';
        let count = 0;
        for (var item = 0; item < data.length; item++) {
            count ++;
            html += '<tr>';
            html += '<td>'+data[item].FullName+'</td>';
            html += '<td>' + data[item].CrDateTime +'</td>';
            html += '<td>'+data[item].LotteryStationName+'</td>';
            html += '<td>'+data[item].Number+'</td>';
            html += '<td class="text-center">';
            html += '<a href="javascript:void(0)"  class="font-fix-1 text-danger link_delete" data-id="'+data[item].CustomersAnticipateId+'"><i class="fa fa-trash"></i></a>';
            html +='</td>';
            html += '</tr>';
        }
        $('#tbody').html(html);
    }
}




