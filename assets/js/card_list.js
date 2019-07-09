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
                    CardId: id,
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

function renderContentCards(data){
    var html = '';
    if(data!=null) {
        var labelCss = [];
        if(data.length > 0) labelCss = data[0].labelCss;
        var urlEdit = $('#urlEdit').val() + '/';
        var urlDelete = $('#urlDelete').val() + '/';
        let count = 0;
        for (var item = 0; item < data.length; item++) {
            count ++;
            html += '<tr id="trItem_' + data[item].CardId + '" class="trItem">';
            html += '<td>'+data[item].CardName+'</td>';
            html += '<td>'+data[item].CardSeri+'</td>';
            html += '<td>'+data[item].CardNumber+'</td>';
            html += '<td class="text-center"><span class="' + labelCss[data[item].CardActiveId] + '">' + data[item].CardActive + '</span></td>';
            html += '<td class="text-center">';
            if(parseInt(data[item].CardActiveId) == 2){
            html += '<a href="'+urlEdit+data[item].CardId+'"  class="font-fix-1 text-primary"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            }
            if(parseInt(data[item].CardActiveId) != 3 && parseInt(data[item].CardActiveId) != 4) html += '<a href="javascript:void(0)"  class="font-fix-1 text-danger link_delete" data-id="'+data[item].CardId+'"><i class="fa fa-trash"></i></a>';
            html +='</td>';
            html += '</tr>';
        }
        html += '<tr><td colspan="8" class="paginate_table"></td></tr>';
        $('#tbody').html(html);
    }
}
