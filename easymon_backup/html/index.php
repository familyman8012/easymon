<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/_common.php');
    
    session_start();
    if( $_SESSION["login"] != "" ) {
        header("Location: main.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="./webicon/uicons-regular-straight/css/uicons-regular-straight.css">
    <title>easymon</title>
</head>
<body>
    
    <div class="wrap_login reg">
        <div class="mask" style="display:none;"></div>        
        <form id="signUpForm">
            <section class="box_login">
                <h1 class="logo"><img src="images/logo.png" alt="EasyMon" /></h1>
                <input type="email" name="email" id="login_id" class="login_inp" autocomplete="username"
                    placeholder="이메일" />
                <input type="password" name="password" id="login_pwd" class="login_inp lst"
                    autocomplete="current-password" placeholder="비밀번호" />                
                <div class="auto_login">
                    <input type="checkbox" id="chk_autologin"><label for="chk_autologin">자동로그인</label>
                </div>
                <div id="btn_login" class="btn_login">로그인</div>
                <div class="wrap_find_reg">
                    <span class="btn_pop search" id="btn_pop_schid">아이디 찾기</span>
                    <span class="btn_pop sch_pwd" id="btn_pop_schpw">비밀번호 찾기</span>
                    <span class="btn_pop reg" id="btn_pop_reg">회원가입</span>
                </div>
            </section>
            <section class="wrap_reg_process step1" style="display:none;">
                <aside class="nav_reg">
                    <span class="txt">약관 동의</span>
                    <span class="txt">국가 선택</span>
                    <span class="txt">정보 입력</span>
                </aside>
                <!-- 약관동의 -->
                <div class="wrap_yakwan">
                    <h1>약관동의</h1>
                    <div class="all_agree">
                        <input type="checkbox" id="allagree">
                        <label for="allagree">약관 전체동의</label>
                    </div>
                    <ul class="list_yakwan">
                        <li>
                            <input type="checkbox" id="doc1">
                            <label for="doc1">이용약관 동의(필수)</label>
                        </li>
                        <li>
                            <input type="checkbox" id="doc2">
                            <label for="doc2">개인정보 수집 및 이용 동의(필수)</label>
                        </li>
                    </ul>
                    <span id="btn_regyakwan_next" class="btn reg">다음</span>
                </div>
                <!-- 국가선택 -->
                <div class="wrap_select_nation">
                    <h1>국가선택</h1>
                    <ul class="list_nation">
                        <li>대한민국</li>
                        <li>미국</li>
                        <li>중국</li>
                        <li>일본</li>
                        <li>필리핀</li>
                        <li>베트남</li>
                        <li>인도네시아</li>
                        <li>홍콩</li>
                    </ul>
                    <span id="btn_nation_next" class="btn reg">다음</span>
                </div>
                <!-- 정보입력 -->
                <div class="wrap_certi">
                    <h1>정보입력</h1>
                    <ul class="list_certi">
                        <li>
                            <input type="email" name="write_email" id="write_email" placeholder="이메일" />
                        </li>
                        <li>
                            <input type="password" name="write_password" id="write_password"
                                placeholder="비밀번호 (8~15자리 영문자, 숫자)" />
                        </li>
                        <li>
                            <input type="password" name="write_password_chk" id="write_password_chk"
                                placeholder="비밀번호 확인" />
                        </li>
                        <li>
                            <input type="text" name="write_name" id="write_name" placeholder="이름" />
                        </li>
                        <li class="box_send_certi on">
                            <input type="number" name="write_number" id="write_number"  placeholder="핸드폰 번호" onkeypress="if(event.keyCode<48 || event.keyCode>57){event.returnValue=false;}" />
                            <span id="btn_certifi_send" class="btn btn_certifi_send">인증 받기</span>
                        </li>
                        <li class="box_send_certi">
                            <input type="number" name="write_certi_num" id="write_certi_num" placeholder="인증 번호" />
                            <span id="timer_certi" class="timer_area"></span>
                            <span id="certiBTN" class="btn btn_certifi">확인</span>
                        </li>
                        <li class="select_gender">
                            <label class="select_custom_radio on" for="male">
                                <input type="radio" name="gender" id="male" class="custom_radio" checked value="1"/>
                                남자
                            </label>
                            <label class="select_custom_radio" for="female">
                                <input type="radio" name="gender" id="female" class="custom_radio" value="2"/>
                                여자
                            </label>
                        </li>
                        <li>
                            <input type="number" name="write_birth_num" id="write_birth_num"
                                placeholder="생년월일 (예: 19791012)" onkeypress="if(event.keyCode<48 || event.keyCode>57){event.returnValue=false;}" />
                        </li>
                        <li>
                            <input type="email" name="write_recome_email" id="write_recome_email"
                                placeholder="추천인 이메일" />
                        </li>
                    </ul>
                    <p class="notice_recome">*입력하신 추천인은 가입 후 입력, 변경이 불가합니다. </p>
                    <span id="btn_wrapcerti_fin" class="btn reg">완료</span>
                </div>
            </section>
        </form>
        <section class="section_pop_login">
            <div id="pop_miss_login" class="pop not_correct" style="display:none;">
                <i class="fi fi-rs-cross-circle"></i>
                <p class="txt">
                    아이디 또는 비밀번호가<br />
                    일치하지 않습니다.<br /><br />
                    확인 후 다시 로그인 해 주세요.
                </p>
                <span class="btn_pop_close">확인</span>
            </div>
            <div id="pop_sch_id" class="pop sch_id" style="display:none;">
                <h2>아이디 찾기</h2>
                <ul class="list_certi">
                    <li class="box_send_certi on">
                        <input type="number" name="sch_hp_number" id="sch_hp_number" placeholder="핸드폰 번호" onkeypress="if(event.keyCode<48 || event.keyCode>57){event.returnValue=false;}" />
                        <span id="btn_findid_certi" class="btn">인증 받기</span>
                    </li>
                    <li class="box_send_certi">
                        <input type="number" name="sch_certi_num" id="sch_certi_num" placeholder="인증 번호" />
                        <span id="timer_certi2" class="timer_area"></span>
                        <span id="btn_findid_certi_chk" class=" btn">확인</span>
                    </li>
                </ul>
            </div>
            <div id="pop_sch_idresult"  class="pop sch_id_result" style="display:none;">
                <ul class="list_pop_schid" id="idFindUL">
<!--                    <li><input type="radio" name="sch_result_id" id="sch_result_id1" class="result_id" checked><label for="sch_result_id1">dkflseif@hanmail.net</label></li>
                    <li><input type="radio" name="sch_result_id" id="sch_result_id2" class="result_id"><label
                            for="sch_result_id2">sadf@hanmail.net</label></li>
                    <li><input type="radio" name="sch_result_id" id="sch_result_id3" class="result_id"><label
                            for="sch_result_id3">1231@hanmail.net</label></li>
                    <li><input type="radio" name="sch_result_id" id="sch_result_id4" class="result_id"><label
                            for="sch_result_id4">zcds@hanmail.net</label></li>
                    <li><input type="radio" name="sch_result_id" id="sch_result_id5" class="result_id"><label
                            for="sch_result_id5">htghh@hanmail.net</label></li>-->
                </ul>
                <span id="btn_sch_loginid" class="btn_pop_close">로그인</span>
                <span id="btn_sch_loginpw" class="btn_pop_schpw">비밀번호 찾기</span>
            </div>
            <div id="pop_sch_pw"  class="pop sch_pw" style="display:none;">
                <h2>비밀번호 찾기</h2>
                <ul class="list_certi">
                    <li>
                        <input type="email" name="sch_email" id="sch_email" placeholder="이메일" />
                    </li>
                    <li class="box_send_certi">
                        <input type="number" name="sch_hp_number" id="sch_hp_number2" placeholder="핸드폰 번호" onkeypress="if(event.keyCode<48 || event.keyCode>57){event.returnValue=false;}" />
                        <span id="btn_findpwd_certi" class="btn">인증 받기</span>
                    </li>
                    <li class="box_send_certi">
                        <input type="number" name="sch_certi_num" id="sch_certi_num2" placeholder="인증 번호" />
                        <span id="timer_findpwd" class="timer_area"></span>
                        <span id="btn_findpwd_certi_chk" class="btn">확인</span>
                    </li>
                </ul>
            </div>
            <div id="pop_sch_pwresult"  class="pop sch_pw_result" style="display:none;">
                <h2 id="tempPasswordEl"></h2>
                <p class="txt">
                    임시 비밀번호입니다.<br />
                    로그인 후 비밀번호를 변경해주세요.
                </p>
                <span id="btn_sch_pwresult" class="btn_pop_close">확인</span>
            </div>
        </section>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="js/login_register.js"></script>
</body>
</html>

<?php
    include_once('./include/server/dbClose.php');
?>