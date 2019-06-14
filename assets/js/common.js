$(document).ready(function () {
    var siteName = $('input#siteName').val();
    if (siteName != '') {
        siteName = $('title').text() + ' - ' + siteName;
        $('title').text(siteName);
        $('input#siteName').val(siteName);
    }
    if ($('select.select2').length > 0) $('select.select2').select2();
    if ($('div.divTable').length > 0) {
        if ($(window).width() > 760) $('div.divTable').removeClass('table-responsive');
        else $('div.divTable').addClass('table-responsive');
        $(window).resize(function () {
            if ($(window).width() > 760) $('div.divTable').removeClass('table-responsive');
            else $('div.divTable').addClass('table-responsive');
        });
    }
    $(document).ajaxStart(function () {
        Pace.restart();
    });

    //admin menu
    if ($('.sidebar-menu').length > 0) {
        var curentPathName = window.location.pathname;
        var rootPath = $('input#rootPath').val();
        curentPathName = curentPathName.replace(rootPath, '');
        var hostname = window.location.hostname;
        $('.sidebar-menu li a').each(function () {
            var pageLink = $(this).attr('href');
            if (pageLink != undefined) {
                pageLink = pageLink.replace('https://', '');
                pageLink = pageLink.replace('http://', '');
                pageLink = pageLink.replace(hostname, '');
                pageLink = pageLink.replace(rootPath, '');
                if (pageLink == curentPathName) {
                    $(this).parent('li').addClass('active');
                    var ul = $(this).parent('li').parent('ul').parent('li').parent('ul');
                    if (ul.length > 0) {
                        $(this).parent('li').parent('ul').css('display', 'block');
                        $(this).parent('li').parent('ul').parent('li').addClass('active');
                        ul.css('display', 'block');
                        ul.parent('li').addClass('active');
                    }
                    else $(this).parent('li').parent('ul').parent('li').addClass('active');
                    return false;
                }
            }
        });
        if(localStorage.getItem('ricky_menu_collapsed') == '1') $('body').addClass('sidebar-collapse');
        else $('body').removeClass('sidebar-collapse');
        $('.sidebar-toggle').click(function (e) {
            e.preventDefault();
            if(localStorage.getItem('ricky_menu_collapsed') == '1') localStorage.setItem('ricky_menu_collapsed', '0');
            else localStorage.setItem('ricky_menu_collapsed', '1');
        });
        $('section.sidebar').slimScroll({
            height: ($(document).height() - 30) + 'px',
            color : '#2C3B41'
        });
        //remind
        // getReminds();
        // setInterval(getReminds, 60000 * 5); //5p
    }
});

function getReminds(){
    $.ajax({
        type: "POST",
        url: $('input#getRemindUrl').val(),
        success: function (response) {
            var json = $.parseJSON(response);
            if(json.code == 1){
                //PNotify.desktop.permission();
                var remindId = 0;
                var customerConsultId = 0;
                var flag = true;
                var data = json.data;
                for(var i = 0; i < data.length; i++){
                    remindId = data[i].RemindId;
                    customerConsultId = data[i].CustomerConsultId;
                    flag = true;
                    $('#divInputRemindIds input').each(function() {
                        if ($(this).val() == remindId && $(this).attr('data-id') == customerConsultId) {
                            flag = false;
                            return false;
                        }
                    });
                    if(flag) {
                        var detailRemindUrl = $('input#detailRemindUrl').val() + '/';
                        var detailConsultUrl = $('input#detailConsultUrl').val() + '/';
                        var href = (remindId != '0') ? (detailRemindUrl + remindId) : (detailConsultUrl + customerConsultId);
                        new PNotify({
                            title: '<a href="' + href + '" target="_blank">Nhắc nhở <span class="pull-right">' + getDayText(data[i].DayDiff) + data[i].RemindDate + '</span></a>',
                            text: '<a href="' + href + '" target="_blank">' + data[i].RemindTitle + '</a>',
                            hide: false,
                            buttons: {
                                sticker: false
                            }
                            /*desktop: {
                             desktop: true,
                             icon: null
                             }*/
                        });
                        $('#divInputRemindIds').append('<input type="text" hidden="hidden" value="' + remindId + '" data-id="' + customerConsultId + '">');
                    }
                }
            }
        },
        error: function (response) {}
    });
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

function checkKeyCodeNumber(e){
    return !((e.keyCode >= 48 && e.keyCode <= 57) || (e.keyCode >= 96 && e.keyCode <= 105) || e.keyCode == 8 ||  e.keyCode == 35 || e.keyCode == 36 || e.keyCode == 37 || e.keyCode == 39 || e.keyCode == 46);
}

/* type = 1 - success
 other - error
 */
function showNotification(msg, type) {
    var typeText = 'error';
    if (type == 1) typeText = 'success';
    var notice = new PNotify({
        title: 'Thông báo',
        text: msg,
        type: typeText,
        delay: 2000,
        addclass: 'stack-bottomright',
        stack: {"dir1": "up", "dir2": "left", "firstpos1": 15, "firstpos2": 15}
    });
}

function showConfirm(msg, funcOk, funcCancel){
    (new PNotify({
        title: 'Xác nhận',
        text: msg,
        icon: 'glyphicon glyphicon-question-sign',
        type: 'info',
        hide: false,
        confirm: {
            confirm: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {
            'dir1': 'down',
            'dir2': 'right',
            'modal': true
        }
    })).get().on('pnotify.confirm', function() {
        funcOk();
    }).on('pnotify.cancel', function() {
        funcCancel();
    });
}

function showPrompt(title, msg, fn){
    (new PNotify({
        title: title,
        text: msg,
        icon: 'glyphicon glyphicon-question-sign',
        hide: false,
        confirm: {
            prompt: true
        },
        buttons: {
            closer: false,
            sticker: false
        },
        history: {
            history: false
        },
        addclass: 'stack-modal',
        stack: {
            'dir1': 'down',
            'dir2': 'right',
            'modal': true
        }
    })).get().on('pnotify.confirm', function(e, notice, val) {
        fn(val);
    }).on('pnotify.cancel', function(e, notice) {

    });
}

function redirect(reload, url) {
    if (reload) {
        window.setTimeout(function () {
            window.location.reload(true);
        }, 2000);
    }
    else {
        window.setTimeout(function () {
            window.location.href = url;
        }, 2000);
    }
}

function scrollTo(eleId) {
    $('html, body').animate({
        scrollTop: $(eleId).offset().top - 200
    }, 1000);
    $(eleId).focus();
}

//validate
function validateEmpty(container) {
    var flag = true;
    $(container + ' .hmdrequired').each(function () {
        if ($(this).val().trim() == '') {
            showNotification($(this).attr('data-field') + ' không được bỏ trống', 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}

function validateNumber(container, isInt, msg) {
    if(typeof(msg) == 'undefined') msg = ' không được bé hơn 0';
    var flag = true;
    var value = 0;
    $(container + ' .hmdrequiredNumber').each(function () {
        value = replaceCost($(this).val(), isInt);
        if (value <= 0) {
            showNotification($(this).attr('data-field') + msg, 0);
            $(this).focus();
            flag = false;
            return false;
        }
    });
    return flag;
}

function checkEmptyEditor(text) {
    text = text.replace(/\&nbsp;/g, '').replace(/\<p>/g, '').replace(/\<\/p>/g, '').trim();
    return text.length > 0;
}

function makeSlug(str) {
    var slug = str.trim().toLowerCase();
    // change vietnam character
    slug = slug.replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a');
    slug = slug.replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e');
    slug = slug.replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i');
    slug = slug.replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o');
    slug = slug.replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u');
    slug = slug.replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y');
    slug = slug.replace(/đ/gi, 'd');
    // remove special character
    slug = slug.replace(/\`|\~|\!|\@|\#|\||\$|\%|\^|\&|\*|\(|\)|\+|\=|\,|\.|\/|\?|\>|\<|\'|\"|\:|\;|_/gi, '');
    // change space to -
    slug = slug.replace(/ /gi, "-");
    slug = slug.replace(/\-\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-\-/gi, '-');
    slug = slug.replace(/\-\-\-/gi, '-');
    slug = slug.replace(/\-\-/gi, '-');
    slug = '@' + slug + '@';
    slug = slug.replace(/\@\-|\-\@|\@/gi, '');
    return slug;
}

function getCurrentDateTime(typeId, now){
    if(typeof(now) == 'undefined') now = new Date();
    var date = now.getDate();
    var month = now.getMonth() + 1;
    var hour = now.getHours();
    var minute = now.getMinutes();
    var second = now.getSeconds();
    if(date < 10) date = '0' + date;
    if(month < 10) month = '0' + month;
    if(hour < 10) hour = '0' + hour;
    if(minute < 10) minute = '0' + minute;
    if(second < 10) second = '0' + second;
    if(typeId == 1) return hour + ":" + minute + ' ' + date + "/" + month + "/" + now.getFullYear();
    else if(typeId == 2) return date + "/" + month + "/" + now.getFullYear() + " " + hour + ":" + minute;
    else if(typeId == 3) return date + "/" + month + "/" + now.getFullYear();
    else if(typeId == 4) return hour + ":" + minute;
    else if(typeId == 5) return now.getFullYear() + "-" + month + "-" + date  + " " + hour + ":" + minute + ":" + second;
    else if(typeId == 6) return 'Hôm nay ' + hour + ":" + minute;
    return date + "/" + month + "/" + now.getFullYear() + " " + hour + ":" + minute + ":" + second;
}

function getDayText(dayDiff){
    var dayText = '';
    if(dayDiff == 0) dayText = 'Hôm nay ';
    else if(dayDiff == 1) dayText = 'Hôm qua ';
    else if(dayDiff == 2) dayText = 'Hôm kia ';
    else if(dayDiff == -1) dayText = 'Ngày mai ';
    else if(dayDiff == -2) dayText = 'Ngày kia ';
    return dayText;
}

function dateRangePicker(fn){
    $(".daterangepicker").daterangepicker({
        forceUpdate: false,
        ranges:{
            'Hôm nay': [moment(), moment()],
            'Hôm qua': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Tuần hiện tại': [moment().startOf('isoWeek'),moment().endOf('isoWeek')],
            'Tuần trước': [moment().subtract(1, 'weeks').startOf('weeks'),moment().subtract(1, 'weeks').endOf('weeks')],
            //'7 ngày trước': [moment().subtract(6, 'days'), moment()],
            '30 ngày trước': [moment().subtract(29, 'days'), moment()],
            //'90 ngày trước': [moment().subtract(89, 'days'), moment()],
            'Tháng hiện tại': [moment().startOf('month'), moment().endOf('month')],
            'Tháng trước': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
            'Năm trước': [moment().subtract(1, 'year').add(1,'day'), moment()],
            'Năm hiện tại': [moment().startOf('year'), moment().endOf('year')],
            'Quý 1 năm nay':[moment().month(0).startOf('month'),moment().month(2).endOf('month')],
            'Quý 2 năm nay':[moment().month(3).startOf('month'),moment().month(5).endOf('month')],
            'Quý 3 năm nay':[moment().month(6).startOf('month'),moment().month(8).endOf('month')],
            'Quý 4 năm nay':[moment().month(9).startOf('month'),moment().month(11).endOf('month')]
            //'Tất cả': 'all-time',
            //'Tùy chọn': 'custom'
        },
        callback: function(startDate, endDate, period){
            var beginDate = "";
            if(moment().format('DD/MM/YYYY') == startDate.format('DD/MM/YYYY') || moment().add(-1, 'days').format('DD/MM/YYYY') == startDate.format('DD/MM/YYYY')){
                // lấy ngày hôm nay // lấy ngày hôm qua    
                beginDate = startDate.format('DD/MM/YYYY');
            }
            else{
                beginDate = moment(startDate, "DD/MM/YYYY").add(1, 'days').format('DD/MM/YYYY');
            }
            $(this).val(beginDate + ' - ' + endDate.format('DD/MM/YYYY'));
            if(typeof(fn) != 'undefined') fn(beginDate + ' - ' + endDate.format('DD/MM/YYYY'));
        }
    });
}

function genItemComment(comment){
    var html = '<div class="box-customer mb10"><table><tbody><tr><th rowspan="2" class="user-wrapper" valign="top" style="width: 50px;"><div class="user-link"><img class="user-img" width="29" src="' + $('input#userImagePath').val() + $('input#avatarLoginId').val() + '" alt=""></div></th>';
    html +='<th><a href="javascript:void(0)" class="name">' + $('input#fullNameLoginId').val() + '</a></th>';
    html += '<th class="time">' + getCurrentDateTime(6) + '</th></tr><tr><td colspan="2"><p class="pComment">' + comment + '</p></td></tr></tbody></table></div>';
    return html;
}

//pagging
function pagging(pageId) {
    $('input#pageId').val(pageId);
    $('input#submit').trigger('click');
}

function chooseFile(resourceType, fn){
    var finder = new CKFinder();
    finder.resourceType = resourceType;
    finder.selectActionFunction = function(fileUrl) {
        fn(fileUrl);
    };
    finder.popup();
}

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