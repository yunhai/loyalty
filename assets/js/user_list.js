var app = app || {};
app.init = function () {
};
$(document).ready(function(){
    actionItemAndSearch({
        ItemName: 'Danh sách khách hàng',
        IsRenderFirst: true,
        extendFunction: function(itemIds, actionCode){
        }
    });
});

function renderContentUsers(data){
    var html = '';
    if(data!=null) {
        var labelCss = [];
        if(data.length > 0) labelCss = data[0].labelCss;
        var urlEdit = $('#urlEdit').val() + '/';
        var urlDelete = $('#urlDelete').val() + '/';
        let count = 0;
        for (var item = 0; item < data.length; item++) {
            count ++;
            html += '<tr id="trItem_' + data[item].UserId + '" class="trItem">';
            html += '<td><a href="'+urlEdit+data[item].UserId+'">' + data[item].FullName + '</a></td>';
            html += '<td>' + data[item].PhoneNumber + '</td>';
            html += '<td>' + data[item].Email + '</td>';
            html += '<td>'+ getDayText(data[item].DayDiff) + data[item].CrDateTime +'</td>';
            html += '<td class="text-center">';
            html += '<a href="'+urlEdit+data[item].UserId+'"  class="font-fix-1 text-primary"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            html += '<a href="'+urlEdit+data[item].UserId+'"  class="font-fix-1 text-danger link_delete" data-id="'+data[item].UserId+'"><i class="fa fa-trash"></i></a>';
            html +='</td>';
            html += '</tr>';
        }
        html += '<tr><td colspan="5" class="paginate_table"></td></tr>';
        $('#tbody').html(html);
    }
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
}




