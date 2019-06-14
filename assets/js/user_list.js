// $(document).ready(function() {
//     $("#tbodyUser").on("click", "a.link_delete", function(){
//         if (confirm('Bạn có thực sự muốn xóa ?')){
//             var id = $(this).attr('data-id');
//             $.ajax({
//                 type: "POST",
//                 url: $('input#changeStatusUrl').val(),
//                 data: {
//                     UserId: id,
//                     StatusId: 0
//                 },
//                 success: function (response) {
//                     var json = $.parseJSON(response);
//                     if (json.code == 1) $('tr#user_' + id).remove();
//                     showNotification(json.message, json.code);
//                 },
//                 error: function (response) {
//                     showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
//                 }
//             });
//         }
//         return false;
//     }).on("click", "a.link_status", function(){
//         var id = $(this).attr('data-id');
//         var statusId = $(this).attr('data-status');
//         if(statusId != $('input#statusId_' + id).val()) {
//             $.ajax({
//                 type: "POST",
//                 url: $('input#changeStatusUrl').val(),
//                 data: {
//                     UserId: id,
//                     StatusId: statusId
//                 },
//                 success: function (response) {
//                     var json = $.parseJSON(response);
//                     if (json.code == 1){
//                         $('td#statusName_' + id).html(json.data.StatusName);
//                         $('input#statusId_' + id).val(statusId);
//                     }
//                     showNotification(json.message, json.code);
//                 },
//                 error: function (response) {
//                     showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
//                 }
//             });
//         }
//         $('#btnGroup_' + id).removeClass('open');
//         return false;
//     });
// });

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

    // $("#tbody").on("click", "a.link_delete", function(){
    //     if(confirm('Bạn có thực sự muốn xóa ?')){
    //         var id = $(this).attr('data-id');
    //         $.ajax({
    //             type: "POST",
    //             url: $('input#urlDelete').val(),
    //             data: {
    //                 CustomerLikeId: id,
    //             },
    //             success: function (response) {
    //                 var json = $.parseJSON(response);
    //                 showNotification(json.message, json.code);
    //                 redirect(true, '');
    //             },
    //             error: function (response) {
    //                 showNotification('Có lỗi xảy ra trong quá trình thực hiện', 0);
    //             }
    //         });
    //     }
    //     return false;
    // });
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
            html += '<td><input class="checkTran iCheckTable iCheckItem" type="checkbox" value="' + data[item].UserId + '"></td>';
            html += '<td><a href="'+urlEdit+data[item].UserId+'">' + data[item].FullName + '</a></td>';
            html += '<td>' + data[item].PhoneNumber + '</td>';
            html += '<td>' + data[item].Email + '</td>';
            html += '<td>'+ getDayText(data[item].DayDiff) + data[item].CrDateTime +'</td>';
            html += '<td class="text-center"></td>';
            html += '<td class="text-center">';
            html += '<a href="'+urlEdit+data[item].UserId+'"  class="font-fix-1 text-primary"><i class="fa fa-edit"></i></a>&nbsp;&nbsp;';
            html += '<a href="'+urlEdit+data[item].UserId+'"  class="font-fix-1 text-danger link_delete" data-id="'+data[item].UserId+'"><i class="fa fa-trash"></i></a>';
            html +='</td>';
            html += '</tr>';
        }


        $('#tbody').html(html);
    }
    $('input.iCheckTable').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%'
    });
}




