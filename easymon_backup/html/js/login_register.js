// 임시 로그인 id 와 pwd 설정 => 추후 삭제.
var gabageLogin = {
    id: 'admin',
    pwd: '1'
} 

/* 값검증 함수 */
// 아이디 - 이메일
var regEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
var regEmailMsg = '이메일 형식에 맞게 입력해주세요.'

// 비밀번호 
var regPwd = /^[a-zA-Z0-9]{8,20}$/;
var regPwdMsg = '비밀번호는 숫자와 영문자 조합으로 8~20자리를 사용해야 합니다.';

// 이름
var regName = /^[가-힣]{2,5}$/;
var regNameMsg = '이름을 정확하게 입력해주세요.'

// 연락처
var regExp = /^\d{3}-?\d{3,4}-?\d{4}$/;
var regExpMsg = '연락처를 정확하게 입력해주세요.'

// 인증번호
var regCertiNum = /^[0-9]+$/;
var regCertiNumMsg = '인증번호 숫자를 넣어주세요.'

//생년월일
var regBirth = /^(19[0-9][0-9]|20\d{2})(0[0-9]|1[0-2])(0[1-9]|[1-2][0-9]|3[0-1])$/
var regBirthMsg = '생년월일을 양식에 맞게 정확하게 입력해주세요.'

// 추천인 이메일
var regRecomEmail = /^[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*@[0-9a-zA-Z]([-_\.]?[0-9a-zA-Z])*\.[a-zA-Z]{2,3}$/i;
var regRecomEmailMsg = '추천인 이메일을 이메일 형식에 맞게 입력해주세요.'



// 정규식을 통한 값 검증 함수 - 연락처, 인증번호, 아이디, 이름을 검증할 수 있음.
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

// 정규식을 통한 비밀번호 검증 함수
function chkPW(targetEl) {
    var pw = $(targetEl).val();
    var num = pw.search(/[0-9]/g);
    var eng = pw.search(/[a-z]/ig);
    if (pw.length < 8 || pw.length > 20) {
        alert("비밀번호는 8자리 ~ 20자리 이내로 입력해주세요.");
        return false;
    }
    else if (pw.search(/\s/) != -1) {
        alert("비밀번호는 공백 없이 입력해주세요.");
        return false;
    }
    else if (num < 0 || eng < 0) {
        alert("영문,숫자를 혼합하여 입력해주세요.");
        return false;
    }
    else {
        return true;
    }
}

// 비밀번호 확인 함수
function matchPwd(target, diftarget) {
    if ($(target).val() != $(diftarget).val()) {
       alert('비밀번호가 일치하지 않습니다.')
        return false;
    } else {
        return true;
    }
}

// 인증번호 전송 버튼 클릭시 타이머에 대한 함수.
function $ComTimer() {
    //prototype extend
}

$ComTimer.prototype = {
    comSecond: ""
    , fnCallback: function () { }
    , timer: ""
    , domId: ""
    , fnTimer: function () {
        var m = Math.floor(this.comSecond / 60) + ": " + (this.comSecond % 60);	// 남은 시간 계산
        this.comSecond--;					// 1초씩 감소
        this.domId.innerText = m;
        if (this.comSecond < 0) {			// 시간이 종료 되었으면..

            this.fnStop();		// 타이머 해제
            alert("인증시간이 초과하였습니다. 다시 인증해주시기 바랍니다.");
            $('.dis_certi').removeClass('dis_certi');
        }
    }
    , fnStop: function () {
        clearInterval(this.timer);
    }
}
var AuthTimer;
function certiTimer(target) {
    if (AuthTimer === undefined) {
        AuthTimer = new $ComTimer();
        certiTimerRunning(target);
    } else {
        AuthTimer.fnStop();
        certiTimerRunning(target);
    }
}

function certiTimerRunning(target) {
    AuthTimer.comSecond = 179;
    AuthTimer.fnCallback = function () { alert("다시인증을 시도해주세요.") }
    AuthTimer.timer = setInterval(function () { AuthTimer.fnTimer() }, 1000);
    AuthTimer.domId = document.getElementById(target);
    $('.wrap_pop .btn_close').on('click', function () {
        AuthTimer.fnStop();
        $('.timer').children().empty();
        $('.dis_certi').removeClass('dis_certi');
    });
}


/* 로그인 */
function loginLogic() {
    // 빈값일때
    if ($('#login_id').val() === '' || $('#login_pwd').val() === '') {
        alert('아이디와 패스워드를 입력해주세요.')
    }
    var autoTemp = "N";
    if( $("#chk_autologin").is(":checked") == true ) {
        autoTemp = "Y";
    }
    $.ajax({
        type: "POST", //요청 메소드 방식
        url: "/back/member/login.php",
        data: 'email=' + $("#login_id").val() + "&password=" + $("#login_pwd").val() + "&auto=" + autoTemp,
        success: function (result) {
            if (result == "false") {
                $('.mask, #pop_miss_login').show();
            } else {
                location.href = '/main.php'; 
            }
        },
        error: function (a, b, c) {
            alert(a + b + c);
        }
    });
}

// 로그인 버튼을 클릭
$('#btn_login').on('click', function () {
    loginLogic()
})

// 아이디, 비번이 틀렸을때 팝업
$('#pop_miss_login .btn_pop_close').on('click', function () {
    $('#pop_miss_login, .mask').hide();
})

// 아이디 찾기
$('#btn_pop_schid').on('click', function(){
    $('.mask').show();
    $('#pop_sch_id').show();
})

// 아이디 찾기 - 인증번호 전송 버튼
$('#btn_findid_certi').on('click', function () {
    // 연락처 정보   
    
    var hpChk = certiChkfun('#sch_hp_number', regExp, regExpMsg);
    //검증성공시.
    if (hpChk) {
        if (!$(this).hasClass('dis_certi')) {
            certiTimer("timer_certi2");
        }
        $(this).addClass('dis_certi');

        $.ajax({
            type: "POST", //요청 메소드 방식
            url: "/back/send/authenticationNumberSMS.php",
            data: 'hp=' + $("#sch_hp_number").val(),
            success: function (result) {
                if (result == "false") { alert("문자발송 ERROR"); }
            },
            error: function (a, b, c) {
                alert(a + b + c);
            }
        });
    }
});


// 계정찾기 - 인증 버튼
$('#btn_findid_certi_chk').on('click', function () {
    // 인증번호 : 숫자만 넣기.
    var certiNumChk = certiChkfun('#sch_certi_num', regCertiNum, regCertiNumMsg);
    //검증성공시.
    if (certiNumChk) {

        $.ajax({
            type: "POST", //요청 메소드 방식
            url: "/back/member/idFind.php",
            data: 'hp=' + $("#sch_hp_number").val() + '&number=' + $("#sch_certi_num").val(),
            dataType: "text", //서버가 요청 URL을 통해서 응답하는 내용의 타입
            success: function (result) {
                if (result == "false") {
                    alert("인증번호가 올바르지 않습니다.");
                } else if (result != "") {
                    // 인증번호 일치

                    var tempCount = 0;
                    var array = JSON.parse(result);
                    array.forEach(function(element){
                        tempCount++;
                        var textTemp = "";
                        if( tempCount == 1 ) {
                            textTemp = "checked";
                        }
                        $("#idFindUL").append('<li><input type="radio" name="sch_result_id" id="sch_result_id'+tempCount+'" class="result_id" '+textTemp+'><label for="sch_result_id'+tempCount+'">'+element+'</label></li>');
                    });
                    
                    $('#pop_sch_id').hide();
                    $('#pop_sch_id input').val('');
                    $('#pop_sch_idresult').show();
                }
            },
            error: function (a, b, c) {
                alert(a + b + c);
            }
        });
    }
})


$('#btn_sch_loginid').on('click', function() {
    var resultId = $('.result_id:checked').closest('li').text();
    $('#login_id').val(resultId);
    $('#pop_sch_idresult, .mask').hide();
});

$('#btn_sch_loginpw').on('click', function(){
    var resultId = $('.result_id:checked').closest('li').text();
    $('#pop_sch_idresult').hide();
    $('#sch_email').val(resultId);
    $('#pop_sch_pw').show();
});

$('#btn_sch_pwresult').on('click', function(){
    $('#pop_sch_pwresult, .mask').hide();
})

// 비밀번호 찾기
$('#btn_pop_schpw').on('click', function () {
    $('.mask').show();
    $('#pop_sch_pw').show();
});

// 비밀번호 찾기 인증받기 클릭시
$('#btn_findpwd_certi').on('click', function() {
    // 이메일 값검증
    var IdChk = certiChkfun('#sch_email', regEmail, regEmailMsg);
    // 아이디 db 에 있는 지 확인 -> 개발사항.
    // 아이디 값검증이 통과되었다면 인증받기 가능.
    if (IdChk) { 
        var hpChk = certiChkfun('#sch_hp_number2', regExp, regExpMsg);
        if (hpChk) {
            $.ajax({
                type: "POST", //요청 메소드 방식
                url: "/back/send/authenticationNumberSMS.php",
                data: 'hp=' + $("#sch_hp_number2").val(),
                success: function (result) {
                    if (result == "false") { alert("문자발송 ERROR"); }
                },
                error: function (a, b, c) {
                    alert(a + b + c);
                }
            });
            
            if (!$(this).hasClass('dis_certi')) {
                certiTimer("timer_findpwd");
            }
            $(this).addClass('dis_certi');
        };
     }
})

// 비밀번호찾기  - 인증 버튼
$('#btn_findpwd_certi_chk').on('click', function () {
    // 인증번호 : 숫자만 넣기.
    var certiNumChk = certiChkfun('#sch_certi_num2', regCertiNum, regCertiNumMsg)
    if (certiNumChk) {
        $.ajax({
            type: "POST", //요청 메소드 방식
            url: "/back/member/pwFind.php",
            data: 'hp=' + $("#sch_hp_number2").val() + '&number=' + $("#sch_certi_num2").val() + "&email="+$("#sch_email").val(),
            success: function (result) {
                if (result == "false") {
                    alert("인증번호가 올바르지 않습니다.");
                } else if (result == "ERROR1") {
                    alert("일치하는 회원정보가 없습니다.");
                } else if(result != "") {
                    // 인증번호 일치
                    $("#tempPasswordEl").text(result);
                    
                    $('#pop_sch_pw').hide();
                    $('#pop_sch_pwresult').show();
                }
            },
            error: function (a, b, c) {
                alert(a + b + c);
            }
        });
    }
})

// 회원가입 클릭
$('#btn_pop_reg').on('click', function(){
    $('.box_login').hide();
    $('.wrap_reg_process').show();
})


/* 회원가입 */
/* 약관동의 */
// 약관동의 - 전체동의 해제되어있을때는 모두 체크, 체크되어있을땐 해제.
$('.all_agree input, .all_agree label').on('click', function () {
    if ($('#allagree').is(":checked")) {
        $(".list_yakwan input").prop("checked", true);
    } else {
        $(".list_yakwan input").prop("checked", false);
    }
});


// 약관동의에서 다음을 클릭했을때,
$('#btn_regyakwan_next').on('click', function () {
    /* 약관동의 사항 중 체크안된 항목이 있을 시 */
    if ($('.list_yakwan input:checked').length != $('.list_yakwan input').length) {
        alert('모든 약관에 동의하셔야합니다.');
        return false;
    }   
    /* 약관동의가 되었을때 */
    $('.wrap_reg_process').removeClass('step1').addClass('step2');
});

// 국가선택에서 다음을 클릭했을때,
$('#btn_nation_next').on('click', function () {
    $('.wrap_reg_process').removeClass('step2').addClass('step3');
});


/* 인증번호 전송 버튼 클릭시 동작 함수 */
function sendCerti(phoneinput, timeshowarea) {
    if (!$(this).hasClass('dis_certi')) {
        /* 값검증 */
        var certi1 = certiChkfun(phoneinput, regExp, regExpMsg)
        /* 값검증이 통과되었다면 인증번호 타이머 시작 및 인증번호 발송 */
        if (certi1) {
            // 인증 번호 전송이 1번 이상 클릭되지 않도록 disable 시킴. 인증시간이 지나면 다시 클릭 가능.
            // disable 된게 아니면 타이머 작동해라.

            if (!$(this).hasClass('dis_certi')) {
                certiTimer(timeshowarea);
            }
            // 타이머가 작동되면 disable 시킴.
            //$(this).addClass('dis_certi');

            $.ajax({
                type: "POST", //요청 메소드 방식
                url: "/back/send/authenticationNumberSMS.php",
                data: 'hp=' + $(phoneinput).val(),
                success: function (result) {
                    if (result == "false") { alert("문자발송 ERROR"); }
                },
                error: function (a, b, c) {
                    alert(a + b + c);
                }
            });
        }
    }
}
/* 인증 클릭시 동작 함수 */
function chkCerti(authentivalue, phoneinput) {
    if (!$(this).hasClass('dis_certi')) {
        /* 인증 번호 값검증 */
        certiChkfun(authentivalue, regCertiNum, regCertiNumMsg);

        $.ajax({
            type: "POST", //요청 메소드 방식
            url: "/back/send/authenticationNumberSMSCheck.php",
            data: 'hp=' + $(phoneinput).val() + '&number=' + $(authentivalue).val(),
            dataType: "text", //서버가 요청 URL을 통해서 응답하는 내용의 타입
            success: function (result) {
                if (result == "false") {
                    alert("인증번호가 올바르지 않습니다.");
                } else {
                    // 인증번호 일치
                    $('.btn_certifi_send, .btn_certifi').addClass('dis_certi');
                    $(phoneinput).prop('readonly', true);
                    $(authentivalue).prop('disabled', true);
                    AuthTimer.fnStop();
                    $('.timer').children().empty();
                }
            },
            error: function (a, b, c) {
                alert(a + b + c);
            }
        });
    }
}


// 정보입력 페이지에서 인증번호 전송 버튼 클릭시
$('#btn_certifi_send').on('click', function () {
    // 첫번째 인수는 휴대폰번호 입력 input, 두번째는 타이머 보여주는 공간.
    sendCerti('#write_number', "timer_certi");
});

/* 인증 버튼 클릭시 */
$('#certiBTN').on('click', function () {
    // 첫번째 인수는 인증번호 입력 input, 두번째는 연락처 input.
    chkCerti('#write_certi_num', '#write_number');
});

// 정보입력 페이지에서 성별 선택 버튼 클릭시
$('.select_custom_radio').on('click', function(){
    $('.select_custom_radio').removeClass('on');
    $(this).addClass('on');
})

// 정보입력 페이지에서 완료 버튼클릭시
$('#btn_wrapcerti_fin').on('click', function () {
    // 정보입력란에 입력안된 input 갯수 구하기. 
    var noneCertiInput = 0;
    $('.wrap_certi .list_certi input').each(function () { if ($(this).val() == '') { noneCertiInput += 1;} });
    if (noneCertiInput != 0) {
        alert('모든 정보입력란에 입력해주셔야합니다.');
        return false;
    } 

    // 이메일 값검증
    var IdChk = certiChkfun('#write_email', regEmail, regEmailMsg);
    // 아이디 값검증이 통과되었다면 패스워드 값검증
    if (IdChk) { var pwdChk = chkPW('#write_password'); }
    // 비밀번호 값검증이 통과되었다면 비밀번호와 비밀번호 확인이 같은지 체크.
    if (pwdChk) { var matchChk = matchPwd('#write_password', '#write_password_chk'); }
    // 비밀번호에 문제가 없다면, 이름 값검증.
    if (matchChk) { var userNamechk = certiChkfun('#write_name', regName, regNameMsg); }
    // 이름 값검증이 통과되었다면, 연락처 정보 값검증
    if (userNamechk) { var hpChk = certiChkfun('#write_number', regExp, regExpMsg);}
    // 연락처 정보 값검증이 통과되었다면 인증번호 값검증.
    if (hpChk) { var certiNumChk = certiChkfun('#write_certi_num', regCertiNum, regCertiNumMsg) }
    //인증 정보 값검증이 통과되었다면 인증이 맞는지 체크.
    if (certiNumChk) {
        if (!$('#certiBTN').hasClass('dis_certi')) {
            alert('인증번호가 제대로 입력되지 않았습니다.')
        } else {
            // 인증번호 값검증이 통과되었다면 생년월일 값검증.
            var userBirth = certiChkfun('#write_birth_num', regBirth, regBirthMsg) 
        }
    }
    // 생년월일 값검증이 통과되었다면 추천인 이메일 값검증
    if (userBirth) { var recom_email = certiChkfun('#write_recome_email', regRecomEmail, regRecomEmailMsg) }
    if (recom_email) { 
        $.ajax({
            type: "POST", //요청 메소드 방식
            url: "/back/member/signUp.php",
            data: $("#signUpForm").serialize(),
            dataType: "text", //서버가 요청 URL을 통해서 응답하는 내용의 타입
            success: function (result) {
                if (result == "ERROR1") {
                    alert("사용 중인 이메일입니다.");
                } else if (result == "ERROR3") {
                    alert("존재하지 않는 추천인입니다.");
                } else if (result == "false") {
                    alert("회원가입 실패");
                } else if (result == "true") {
                    window.location.href = "/main.php";
                }
            },
            error: function (a, b, c) {
                alert(a + b + c);
            }
        });
    }
});