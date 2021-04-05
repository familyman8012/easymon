
// 포인트
var regPoint = /^[0-9a]{0,5}(0000)$/;
var regPointMsg = '만 포인트 단위로 입력하셔야 합니다.'
// 연락처
var regExp = /^\d{3}-?\d{3,4}-?\d{4}$/;
var regExpMsg = '연락처를 정확하게 입력해주세요.'

//신용카드
var regCard = /^(?:(94[0-9]{14})|(4[0-9]{12}(?:[0-9]{3})?)|(5[1-5][0-9]{14})|(6(?:011|5[0-9]{2})[0-9]{12})|(3[47][0-9]{13})|(3(?:0[0-5]|[68][0-9])[0-9]{11})|((?:2131|1800|35[0-9]{3})[0-9]{11}))$/
var regCardMsg = '신용카드 번호를 정확하게 입력해주세요'


// 아이디 - 이메일
var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
var regEmailMsg = '이메일 형식에 맞게 입력해주세요.'

function certiChkfun(targetEl, regCondition, msg) {
    var regChk = regCondition;
    if (!regChk.test($(targetEl).val())) {
        alert(msg);
        $(targetEl).focus();
        $(targetEl).closest('li').addClass('error');
        return false;
    } else {
        return true;
    }
}

// 사업자 번호
function checkCorporateRegistrationNumber(value) {
    var valueMap = value.replace(/-/gi, '').split('').map(function (item) {
        return parseInt(item, 10);
    });

    if (valueMap.length === 10) {
        var multiply = new Array(1, 3, 7, 1, 3, 7, 1, 3, 5);
        var checkSum = 0;

        for (var i = 0; i < multiply.length; ++i) {
            checkSum += multiply[i] * valueMap[i];
        }

        checkSum += parseInt((multiply[8] * valueMap[8]) / 10, 10);
        return Math.floor(valueMap[9]) === (10 - (checkSum % 10));
    }

    return false;
}

// gnb
$('.btn_gnb_menu').on('click', function(){
    $('.mask').show();
    $('body').addClass('noScroll');
    $('.wrap_all_menu').addClass('on').animate({
        right: '0'
    });
});
$('.mask').on('click', function () {
    if ($('.wrap_all_menu').hasClass('on')) {
        $('.mask').hide();
        $('body').removeClass('noScroll');
        $('.wrap_all_menu').removeClass('on').animate({
            right: '-300px'
        });
    }
});


/* 충전하기 */
/* 현금영수증 */
$('#inp_cash_receipt, #label_cash_receipt').on('click', function(){
    if ($('#inp_cash_receipt').is(":checked")) {
        $('.box_cash_receipt').show();
    } else {
        $('.box_cash_receipt').hide();
    }
})
/* 약관동의 */
// 약관동의 - 전체동의 해제되어있을때는 모두 체크, 체크되어있을땐 해제.
$('.all_agree input, .all_agree label').on('click', function () {
    if ($('#allagree').is(":checked")) {
        $(".list_yakwan input").prop("checked", true);
    } else {
        $(".list_yakwan input").prop("checked", false);
    }
});
$('.sel_recepite1').on('click', function(){
    $('.show_select_box').hide();
    $('#show_select_box1').show();
})  
$('.sel_recepite2').on('click', function () {
    $('.show_select_box').hide();
    $('#show_select_box2').show();
}) 


$('#btn_charge').on('click', function(){    
    // 아이디 - 이메일
    var PoinWriteReg = certiChkfun('#inp_point', regPoint, regPointMsg);
    if (PoinWriteReg) {
        if ($('#vbank_name').val() == 0) {
            alert('은행을 선택해주셔야합니다.')
            var bankChk = false;
        } else {
            var bankChk = true
        }
    }
   

    if (bankChk && $('#inp_cash_receipt').is(":checked")) {    
        // 소득공제시 
        //휴대폰번호
        if ($('#income_tax').is(":checked") && $('#show_select_box1 select').val() == 'hpnum') {
            var certiSelChk = certiChkfun('#certi_cash_receipt', regExp, regExpMsg);
        } //현금영수증카드
        else if ($('#income_tax').is(":checked") && $('#show_select_box1 select').val() == 'cashcard') {
            var certiSelChk = certiChkfun('#certi_cash_receipt', regCard, regCardMsg);
        }//현금영수증카드
        if ($('#expenditure').is(":checked") && $('#show_select_box2 select').val() == 'cashcard') {
            var certiSelChk = certiChkfun('#certi_cash_receipt2', regCard, regCardMsg);
        } //사업자번호 => 숫자로만 넣어야 합니다.
        else if ($('#expenditure').is(":checked") && $('#show_select_box2 select').val() == 'bznum') {
            var pBizno = $("#certi_cash_receipt2").val();
            if (!checkCorporateRegistrationNumber(pBizno.replaceAll("-", ""))) {
                alert("유효한 사업자번호를 입력하세요");
                $("#certi_cash_receipt").focus();
                $("#certi_cash_receipt").val("");
                var certiSelChk = false;
            } else {
                var certiSelChk = true;
            }
        }
        if (certiSelChk) {
            if (!$('#agree_cash_receipt').is(":checked")) {
                var agreeReceiptChk = false;
                alert('현금영수증 발급 신청 시 휴대폰번호 또는 현금영수증 카드 번호 수집에 동의하셔야합니다.')
            } else {
                var agreeReceiptChk = true;
            }
        }
        if (agreeReceiptChk) {
            if ($('.wrap_yakwan input:checked').length != $('.wrap_yakwan input').length) {
                alert('모든 약관에 동의하셔야합니다.');
                return false;
            }
            $('body').addClass('noScroll');
            $('.mask, #pop_virtual_account').show();
        }  
    } else if (bankChk && !$('#inp_cash_receipt').is(":checked")) {
        if ($('.wrap_yakwan input:checked').length != $('.wrap_yakwan input').length) {
            alert('모든 약관에 동의하셔야합니다.');
            return false;
        }
        $('body').addClass('noScroll');
        $('.mask, #pop_virtual_account').show();
    }
   
});


/* 계좌번호 복사 */
$('#btn_accountnum_copy').on('click', function() {
    $('#copy_accountnum').val($('.info_accountnum_copy .num').text().replace(/\-/g, ''));
    $('#copy_accountnum').select();
    document.execCommand("Copy");
    alert('복사완료');
})
/* 충전 레이어팝업에서 확인 누르면 마이오피스 화면으로 복귀 */
$('#pop_virtual_account .btn_pop_submit').on('click', function () {
    location.replace('./myoffice.html');
});

// 출석체크까지 다 완료한 경우, 일일 일과 달성 완료로 표시, 출석 달력 보기로 표시
if ($('#list_step_view').hasClass('step_fin')) {
    $('.wrap_daily_work .tit').text('일일 일과 달성 완료');
    $('.btn_achieve').text('출석 달력 보기');
}


// 달성하기 버튼 클릭.
// $('.btn_achieve').on('click', function(){
//     if (!$('#list_step_view').hasClass('step_fin')) {
//         $('body').addClass('noScroll');
//         $('.mask, #pop_daily_work').show();
//         // 레이어팝업을 띄운 후, 현재 일과 스텝이 어디까지 체킹되었는지 확인 후, 레이어에 각 해당하는 문구를 넣어줌.
//         for (let i = 0; i < $('#list_step_view li').length; i++) {
//             if ($('#list_step_view').hasClass('step'+ i)) { $('#pop_current_step').text($('.step' + i + ' li').eq(i).addClass('on').text()) }        
//         }
//     } else {
//         location.href = './calendar.html'        
//     }
// });

// 일일 일과 
// 닫기 버튼
$('#pop_daily_work .btn_close').on('click', function () {
    $('.mask, #pop_daily_work').hide();
    
});
$('.pop .btn_close').on('click', function(){
    $('body').removeClass('noScroll');
    $(this).closest('.pop').hide();
    $('.mask').hide();
})

// 레이어팝업의 다음 버튼을 클릭 할시,
$('#pop_daily_work .btn_pop_submit').on('click', function () {
    // 일일일과 오늘받을 추천 보너스까지 모두 한 상태가 아니라면,
    if (!$('#list_step_view li:last-child').hasClass('on')) {
        // -2몬 처리되는 부분을 넣어주세요. <-- 여기 작업.
        var useHasMon = 10;        
        // 
        if (useHasMon > 0) {
            // 현재 스텝의 다음 스텝에 해당하는 LI 에 ON 클래스 추가.
            $('#list_step_view .on').next().addClass('on').end().removeClass('on');
            // UL 에 STEP 이 어디까지 되었는지 표시.
            $('#list_step_view').removeAttr('class').addClass('step' + $('#list_step_view .on').index());
            // 해당하는 텍스트로 레이어내에서 변경.
            $('#pop_current_step').text($('#list_step_view .on').text());
        } else {
            $('#pop_dailywork_cannot').show();
        }
     } else {
        // 출석체크단계로 이동.
        location.href = './calendar.html'        
    }
});
$('#pop_dailywork_cannot .btn_pop_submit').on('click', function(){
    $('#pop_dailywork_cannot').hide();
});


// $('#pop_rookie_change .btn').on('click',function(){
//     $('#pop_rookie_change .btn').removeClass('on');
//     $(this).addClass('on');
// })


// 루키전환 후원인 지정
$('#pop_rookie_change .btn_pop_submit').on('click', function () {
    if ($('.support_write').attr('style', 'display: block') && $('#inp_support_is').is(":checked"))  {       
        var emailReg = certiChkfun('.inp_recomm_email', regEmail, regEmailMsg);
        if (emailReg) {
            $('#pop_upgrade_lv').show();
            $('#pop_rookie_change').hide();
        }
    } else { 
        $('#pop_upgrade_lv').addClass('no_support').show();
        $('#pop_rookie_change').hide();
    }
});
$('#inp_support_is, #label_support_is').on('click', function () {
    if ($('#inp_support_is').is(":checked")) {
        $('.support_write').show()
    } else {
        $('.support_write').hide()
    }
});
$('.support_write .btn').on('click', function(){
    $('.support_write .btn').removeClass('on');
    $(this).addClass('on');
});
$('#pop_support_no .btn_cancle').on('click', function () {
    $('#pop_support_no').hide();
    $('#pop_rookie_change').show();
})

$('#pop_support_no .btn_confirm').on('click', function(){
    $('#pop_support_no').hide();
    var userHasPoint = 15  // -> DB에서 불러옴
    if (userHasPoint > $('.lv_require_point').text()) {
        $('#pop_upgrade_fin').show();
    } else {
        $('#pop_upgrade_not').show();
    }
})

// 업그레이드 버튼 클릭
$('#pop_upgrade_lv .btn_pop_submit').on('click', function () {
    if ($('#pop_upgrade_lv').hasClass('no_support')) {
        $('#pop_upgrade_lv').hide();
        $('#pop_support_no').show();
    } else {
        $('#pop_upgrade_lv').hide();
        var userHasPoint = 15 // -> DB에서 불러옴
        if (userHasPoint > $('.lv_require_point').text()) {
            $('#pop_upgrade_fin').show();
        } else {
            $('#pop_upgrade_not').show();
        }
    }
});



$('.pop_upgrade_fin .btn_pop_submit').on('click', function () {
    $('body').removeClass('noScroll');
    $('.mask, .pop_upgrade_fin').hide();
});


$(function(){
    if ($('.current_lv h4').text() == '인턴') {
        $('.view_org').hide();
        $('.next_lv').addClass('on');
        $('.btn_upgrade').text('전환');
    }
    $('.btn_upgrade').on('click', function(){
        if ($('.current_lv h4').text() == '인턴') {
            $('body').addClass('noScroll');
            $('#inp_support_is').prop("checked", true);
            $('.mask, #pop_rookie_change').show();

        } else {
            if($('.next_lv').hasClass('on')) {
                $('body').addClass('noScroll');
                $('.mask, #pop_upgrade_lv').show();
            }
        }
    })
    $('.have_total_property .num').text($('.state_mon .num').text().replace(',',''));
    
})




//내역
$('.search_history_option li, .wrap_searchoption li').on('click', function(){
    $(this).closest('ul').find('li').removeClass('on');
    $(this).addClass('on');
})
