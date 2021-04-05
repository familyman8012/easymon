/* select Data-picker */
function dateSelect(docForm, selectIndex) {
    watch = new Date(docForm.year.options[docForm.year.selectedIndex].text, docForm.month.options[docForm.month.selectedIndex].value, 1);
    hourDiffer = watch - 86400000;
    calendar = new Date(hourDiffer);
    var daysInMonth = calendar.getDate();
}
function Today(year, mon, day) {
    if (year == "null" && mon == "null" && day == "null") {
        today = new Date();
        this_year = today.getFullYear();
        this_month = today.getMonth();
        this_month += 1;
        if (this_month < 10)
            this_month = "0" + this_month;

        this_day = today.getDate();
        if (this_day < 10)
            this_day = "0" + this_day;
    } else {
        var this_year = eval(year);
        var this_month = eval(mon);
        var this_day = eval(day);
    }


    montharray = new Array(31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    maxdays = montharray[this_month - 1];
    //아래는 윤달을 구하는 것
    if (this_month == 2) {
        if ((this_year / 4) != parseInt(this_year / 4))
            maxdays = 28;
        else
            maxdays = 29;
    }

    

}


/* Kurien / Kurien's Blog / http://blog.kurien.co.kr */
/* 주석만 제거하지 않는다면, 어떤 용도로 사용하셔도 좋습니다. */
 window.onload = function () {
    $('.btn_search_cal').click(function () {
        var year = $('select[name=year]').val()
        var mon = $('select[name=month]').val()
        var total = year + '-' + mon + '-01';
        kCalendar2('kCalendar', total, undefined)
    })
    kCalendar2('kCalendar', undefined, undefined);
     $('.btn_attendance_check').on('click', function () {
         location.href = './myoffice.html'
     })
};


/* 캘린더 구성 */

function kCalendar2(id, date, on) {
   


    var kCalendar2 = document.getElementById(id);

    if (typeof (date) !== 'undefined') {
        date = date.split('-');
        date[1] = date[1] - 1;
        date = new Date(date[0], date[1], date[2]);
    } else {
        var date = new Date();
    }
    var currentYear = date.getFullYear();
    //년도를 구함

    var currentMonth = date.getMonth() + 1;
    //연을 구함. 월은 0부터 시작하므로 +1, 12월은 11을 출력

    var currentDate = date.getDate();
    //오늘 일자.

    date.setDate(1);
    var currentDay = date.getDay();
    //이번달 1일의 요일은 출력. 0은 일요일 6은 토요일

    var dateString = new Array('sun', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat');
    var lastDate = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
    if ((currentYear % 4 === 0 && currentYear % 100 !== 0) || currentYear % 400 === 0)
        lastDate[1] = 29;
    //각 달의 마지막 일을 계산, 윤년의 경우 년도가 4의 배수이고 100의 배수가 아닐 때 혹은 400의 배수일 때 2월달이 29일 임.
    //console.log('월 구하기??흠..'+currentMonth);
    var currentLastDate = lastDate[currentMonth - 1];
    var week = Math.ceil((currentDay + currentLastDate) / 7);
    //총 몇 주인지 구함.


    if (currentMonth != 1)
        var prevDate = currentYear + '-' + (currentMonth - 1) + '-' + currentDate;
    else
        var prevDate = (currentYear - 1) + '-' + 12 + '-' + currentDate;
    //만약 이번달이 1월이라면 1년 전 12월로 출력.

    if (currentMonth != 12)
        var nextDate = currentYear + '-' + (currentMonth + 1) + '-' + currentDate;
    else
        var nextDate = (currentYear + 1) + '-' + 1 + '-' + currentDate;
    //만약 이번달이 12월이라면 1년 후 1월로 출력.

    var calendar = '';

    calendar += '<div id="header">';
    calendar += '         <span><a href="javascript:;" class="button left" onclick="kCalendar2(\'' + id + '\', \'' + prevDate + '\', undefined)"></a></span>';
    calendar += '         <span id="date">' + currentYear + '. ' + currentMonth + '</span>';
    calendar += '         <span><a href="javascript:;" class="button right" onclick="kCalendar2(\'' + id + '\', \'' + nextDate + '\', undefined)"></a></span>';
    calendar += '      </div>';
    calendar += '      <table>';
    calendar += '         <caption>' + currentYear + '년 ' + currentMonth + '월 달력</caption>';
    calendar += '         <thead>';
    calendar += '            <tr>';
    calendar += '              <th class="sun" scope="row">일</th>';
    calendar += '              <th class="mon" scope="row">월</th>';
    calendar += '              <th class="tue" scope="row">화</th>';
    calendar += '              <th class="wed" scope="row">수</th>';
    calendar += '              <th class="thu" scope="row">목</th>';
    calendar += '              <th class="fri" scope="row">금</th>';
    calendar += '              <th class="sat" scope="row">토</th>';
    calendar += '            </tr>';
    calendar += '         </thead>';
    calendar += '         <tbody class="calenBody">';

    var dateNum = 1 - currentDay;


    for (var i = 0; i < week; i++) {
        calendar += '         <tr>';
        for (var j = 0; j < 7; j++, dateNum++) {
            if (dateNum < 1 || dateNum > currentLastDate) {
                calendar += '<td class="' + dateString[j] + '"> </td>';
                continue;
            }

            calendar += '<td class="' + dateString[j] + '" id="' + dateNum + '">' + '<div class="date_num">' + dateNum +  '</div></td>';
        }
        calendar += '</tr>';
    }

    calendar += '</tbody>';
    calendar += '</table>';

  

    kCalendar2.innerHTML = calendar;
    today = new Date();
    $('.calenBody #' +today.getDate()).addClass('on');
//    var data = "year=" + currentYear + "&month=" + currentMonth + "&type=" + $("#calendarType").val();
    var data = "year=" + currentYear + "&month=" + currentMonth;

    if (on != 'Y') {
        $.ajax({
            url: 'calendar_back.php',
            type: 'POST',
            data: data,
            error: function (result) {
               

                //var json = JSON.parse(result);

                /* 캘린더 데이터 설정 - 현재는 임시 테스트 데이터 */
                var json = [[true, "2021", "04", "1"], [true, "2021", "04", "2"], [true, "2021", "04", "3"], [true, "2021", "04", "11"] ];

                if (json.length == 0) {
//                   console.log("결과가 없습니다.");
                }
                for (var i = 0; i < json.length; i++) {
                    var cont = ""                    
                    $('#' + json[i][3]).html(cont + json[i][3]);                    
                    if (json[i][0]) {        
                            $('#' + json[i][3]).addClass('isStamp');                 
                            $('#' + json[i][3]).append('<div class="stamp"><img src="../images/stamp_mon.png" alt="출석" /></div>');
                    }

                }
                $('.box_sel_mon').on('click', function () {
                    $('#kCalendar td').removeClass('fin_check');
                    $('.have_total_property .txt').text('몬');
                    $('.have_total_property .num').text($('.state_mon .num').text().replace(',', ''));
                })
                $('.box_sel_point').on('click', function () {
                    $('#kCalendar td').removeClass('fin_check');
                    $('.have_total_property .txt').text('P');
                    $('.have_total_property .num').text($('.state_point .num').text().replace(',', ''));
                })
                $('.loading_msg').removeClass('on');
                $('#kCalendar td').on('click', function() {
                    if (!$(this).hasClass('isStamp') && $('#pay_select_mon').is(":checked")) {
                        if (!$(this).hasClass('fin_check')) {
                            if ($('.have_total_property .num').text() >= 100) {
                                $(this).addClass('fin_check');
                                $('.have_total_property .num').text(Number($('.have_total_property .num').text())-100); 
                            }                           
                        } else {
                            $('.have_total_property .num').text(Number($('.have_total_property .num').text()) + 100); 
                            $(this).removeClass('fin_check');
                            
                        }
                    } else if (!$(this).hasClass('isStamp') && $('#pay_select_point').is(":checked")) {
                        if (!$(this).hasClass('fin_check')) {
                            if ($('.have_total_property .num').text() >= 5000) {
                                $(this).addClass('fin_check');
                                $('.have_total_property .num').text(Number($('.have_total_property .num').text()) - 5000);
                            }
                        } else {
                            $('.have_total_property .num').text(Number($('.have_total_property .num').text()) + 5000);
                            $(this).removeClass('fin_check');

                        }
                    }
                });   
                var arrayFinCheck = [];
                function numberWithCommas(x) {
                    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                }
                $('.wrap_daily_work .btn_achieve').on('click', function(){
                    $('.fin_check').each(function(){
                        arrayFinCheck.push($('#kCalendar #date').text().replace('. ', '-') + '-' + $(this).find('.date_num').text());
                        $('#hidden_fin_mon').val(arrayFinCheck);
                    })
                    $('.fin_check').append('<div class="stamp"><img src="../images/stamp_mon.png" alt="출석" /></div>');
                    $('#kCalendar td').removeClass('fin_check');
                    $('body').addClass('noScroll');
                    $('.mask, #pop_daily_work').show();
                    $('#pop_daily_work #fisrt_date').text(arrayFinCheck[0]);
                    $('#pop_daily_work #last_date').text(arrayFinCheck[arrayFinCheck.length - 1]);
                    if ($('#pay_select_mon').is(":checked")) {
                        $('#use_property').text(arrayFinCheck.length * 100);
                        $('#unit').text('몬');
                        $('.state_mon .num').text(numberWithCommas(Number($('.have_total_property .num').text())));
                    }
                    if ($('#pay_select_point').is(":checked")) {
                        $('#use_property').text(arrayFinCheck.length * 5000);
                        $('#unit').text('P');
                        $('.state_point .num').text(numberWithCommas(Number($('.have_total_property .num').text())));
                    }
                })
                $('#pop_daily_work .btn_pop_submit').on('click', function () {
                    $('body').removeClass('noScroll');
                    $('.mask, #pop_daily_work').hide();
                 });      
               
            }
        });
    }

}





/* 캘린더 결제금액 팝업 */
function calPop(date) {       
    $("#kCalendar_pop").load("cal_pop.php?date="+date, function () {
        $("#kCalendar_pop, .mask_cal").show();
    });
}
function calPop2(date) {
    $("#kCalendar_pop").load("cal_pop2.php?date="+date, function () {
        $("#kCalendar_pop, .mask_cal").show();
    });
}
$(document).on('click', '.balance_pop_area .btn_closepop', function(){
    $('#kCalendar_pop').empty();
    $('.mask_cal').hide();
})

