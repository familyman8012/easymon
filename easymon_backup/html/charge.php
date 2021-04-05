<?php
    include_once('./include/server/dbConn.php');
    include_once('./include/server/_common.php');
    
    session_start();

    if( $_SESSION["login"] == "" ) {
        header("Location: index.php"); 
        exit();
    }
    
    
    $now = date("ymdHis"); //오늘의 날짜 년월일시분초 
    $rand = strtoupper(substr(md5(uniqid(time())),0,4)) ; //임의의난수발생 앞6자리 
    $orderNum = "EM" . $now . "N" .$rand ; // 가맹점 주문번호 생성
?>


<script type="text/javascript">
    function send(){
        var obj = {};
        obj["mid"] = $('input[name=mid]').val();
        obj["licenseKey"] = $('input[name=licenseKey]').val();
        obj["moid"] = $('input[name=moid]').val();
        obj["goodsCnt"] = $('input[name=goodsCnt]').val();
        obj["goodsName"] = $('input[name=goodsName]').val();
        obj["amt"] = $('input[name=amt]').val();
        obj["buyerName"] = $('input[name=buyerName]').val();
        obj["buyerTel"] = $('input[name=buyerTel]').val();
        obj["buyerEmail"] = $('input[name=buyerEmail]').val();
        obj["vbankBankCode"] = $('input[name=vbankBankCode]').val();
        obj["vbankExpDate"] = $('input[name=vbankExpDate]').val();
        obj["vbankAccountName"] = $('input[name=vbankAccountName]').val();
        obj["receiptAmt"] = $('input[name=receiptAmt]').val();
        obj["receiptServiceAmt"] = $('input[name=receiptServiceAmt]').val();
        obj["receiptType"] = $('input[name=receiptType]').val();
        obj["receiptIdentity"] = $('input[name=receiptIdentity]').val();
        obj["mallReserved"] = $('input[name=mallReserved]').val();
        obj["userId"] = $('input[name=userId]').val();
        obj["buyerCode"] = $('input[name=buyerCode]').val();
        obj["mallUserId"] = $('input[name=mallUserId]').val();
        
        

        
        var vbankRe;
        $.ajax({
            type : "POST",
            url : "https://api.innopay.co.kr/api/vbankApi",
            async : false,
            data : JSON.stringify(obj),
            contentType: "application/json; charset=utf-8",
            dataType : "json",
            success : function(data){
                vbankRe = data;
                
                if( data.resultCode != "4100" ) {
                    alert("에러가 발생했습니다.");
                    window.location.href = "charge.php";
                } else {
                    $("#vbank_re1").text("은행명 : " + data.vbankBankNm);
                    $("#vbank_re2").text(data.vbankNum);
                    $("#vbank_re3").text("예금주 : " + data.buyerName);
                    $("#vbank_re4").text("입금 기한 : 3일 이내" );
                }

                
//                $('[name="amt_result"]').val(data.amt);
//                $('[name="authCode_result"]').val(data.authCode);
//                $('[name="authDate_result"]').val(data.authDate);
//                $('[name="buyerEmail_result"]').val(data.buyerEmail);
//                $('[name="buyerName_result"]').val(data.buyerName);
//                $('[name="buyerTel_result"]').val(data.buyerTel);
//                $('[name="dutyFreeAmt_result"]').val(data.dutyFreeAmt);
//                $('[name="goodsCnt_result"]').val(data.goodsCnt);
//                $('[name="goodsName_result"]').val(data.goodsName);
//                $('[name="mid_result"]').val(data.mid);
//                $('[name="moid_result"]').val(data.goodsmoidName);
//                $('[name="resultCode_result"]').val(data.resultCode);
//                $('[name="resultMsg_result"]').val(data.resultMsg);
//                $('[name="tid_result"]').val(data.tid);
//                $('[name="userID_result"]').val(data.userID);
//                $('[name="vbankNum_result"]').val(data.vbankNum);
//                $('[name="vbankBankNm_result"]').val(data.vbankBankNm);
//                $('[name="mallReserved_result"]').val(data.mallReserved);
            },
            error : function(data){
                    console.log(data);   
                    alert("통신에러");
            }
        });
        
        if( vbankRe.resultCode == "4100" ) {
            $.ajax({
                type: "POST", //요청 메소드 방식
                url: "/back/pay/vbankPay.php",
                data: 'tid=' + vbankRe.tid + "&moid=" + vbankRe.mid + "&amt=" + vbankRe.amt + "&authDate=" + vbankRe.authDate + "&vbankBankNm=" + vbankRe.vbankBankNm + "&vbankNum=" + vbankRe.vbankNum,
                success: function (result) {
                    if (result == "ERROR1") {
                        alert("에러가 발생 했습니다."); 
                    }
                },
            });
        }

    }
</script>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="./webicon/uicons-regular-straight/css/uicons-regular-straight.css">
    <title>easymon</title>
</head>
<body>
    <div class="wrap_app wrap_myoffice">
        <div class="mask" style="display:none;"></div>
        <section class="section_top">
            <div class="wrap_head">
                <h1>충전하기</h1>
            </div>
            <div class="wrap_state">
                <div class="have_state">
                    <div class="state_point"><?php echo number_format($member["mb_point"]); ?> P</div>
                </div>
            </div>
        </section>
        <section class="section_container">            
            <div class="wrap_cont wrap_charge">
                <form>
                    <input type="number" placeholder="충전할 포인트를 입력하세요." id="inp_point" class="inp_point" />
                    <p class="notice">*만 포인트 단위로 입력 가능합니다.</p>
                    <dl class="payment_money">
                        <dt>결제금액</dt>
                        <dd>0원<span class="note">(VAT 포함)</span></dd>
                    </dl>
                    <div class="wrap_payment_option">
                        <select class="vbank_name" id="vbank_name" name="vbank_name">
                            <option value="0">은행 선택</option>
                            <option value="003">기업은행</option>
                            <option value="004">국민은행</option>
                            <option value="005">외환은행</option>
                            <option value="007">수협중앙회</option>
                            <option value="011">농협은행</option>
                            <option value="020">우리은행</option>
                            <option value="023">SC은행</option>
                            <option value="027">한국씨티은행</option>
                            <option value="031">대구은행</option>
                            <option value="032">부산은행</option>
                            <option value="034">광주은행</option>
                            <option value="035">제주은행</option>
                            <option value="037">전북은행</option>
                            <option value="039">경남은행</option>
                            <option value="071">우체국</option>
                            <option value="081">하나은행</option>
                            <option value="088">신한은행</option>
                            <option value="089">케이뱅크</option>
                            <option value="090">카카오뱅크</option>
                        </select>       
                        <div class="wrap_cash_receipt">
                            <input type="checkbox" id="inp_cash_receipt">
                            <label for="inp_cash_receipt" id="label_cash_receipt">현금영수증 신청</label>
                        </div>
                    </div>
                    <div class="box_cash_receipt" style="display:none;">
                        <div class="box_option_receipt">
                            <div class="sel_recepite1">
                                <input type="radio" id="income_tax" name="radio_cash_receipt" value="1" checked>
                                <label for="income_tax">소득공제</label>
                            </div>
                            <div class="sel_recepite2">
                                <input type="radio" id="expenditure" name="radio_cash_receipt" value="2">
                                <label for="expenditure">지출증빙</label>
                            </div>
                        </div>
                        <div class="box_hp">
                            <div id="show_select_box1" class="show_select_box">
                                <select name="sel_certi_recepit">
                                    <option value="hpnum">휴대폰 번호</option>
                                    <option value="cashcard">현금영수증 카드</option>
                                </select>
                                <input type="number" id="certi_cash_receipt" class="certi_cash_receipt" onkeypress="if(event.keyCode<48 || event.keyCode>57){event.returnValue=false;}" />
                            </div>
                            <div id="show_select_box2" class="show_select_box" style="display:none;">
                                <select name="sel_certi_recepit">
                                    <option value="bznum">사업자번호</option>
                                    <option value="cashcard">현금영수증 카드</option>
                                </select>
                                <input type="number" id="certi_cash_receipt2" class="certi_cash_receipt2" />
                            </div>
                        </div>
                        <div class="box_notice_receipt">
                            <input type="checkbox" id="agree_cash_receipt">
                            <label for="agree_cash_receipt">현금영수증 발급을 위하여 휴대폰번호 또는 현
                                금영수증카드번호를 수집하며, 5년간 처리에
                                동의합니다.</label>
                        </div>
                    </div>
                    <div class="wrap_yakwan">
                        <div class="all_agree">
                            <input type="checkbox" id="allagree">
                            <label for="allagree">약관 전체동의</label>
                        </div>
                        <ul class="list_yakwan">
                            <li>
                                <input type="checkbox" id="doc1">
                                <label for="doc1">전자금융거래 기본약관</label>
                                <span id="btn_doc1" class="btn">전체보기</span>
                            </li>
                            <li>
                                <input type="checkbox" id="doc2">
                                <label for="doc2">개인정보 수집 및 이용 동의 </label>
                                <span id="btn_doc2"  class="btn">전체보기</span>
                            </li>
                            <li>
                                <input type="checkbox" id="doc2">
                                <label for="doc2">개인정보제공 및 위탁 동의</label>
                                <span id="btn_doc3"  class="btn">전체보기</span>
                            </li>
                        </ul>
                    </div>
                    <div id="pop_virtual_account" class="pop pop_charge_comm pop_virtual_account" style="display:none;">
                        <h2>가상계좌</h2>
                        <ul class="list">
                            <li id="vbank_re1">은행명 : K뱅크</li>
                            <li class="box_accountnum">
                                <strong class="info_accountnum_copy">계좌 번호 : <span
                                        class="num" id="vbank_re2">210534-35-5280</span></strong>
                                <input type="text" id="copy_accountnum" value="" />
                                <span id="btn_accountnum_copy" class="btn_accountnum_copy">
                                    <i class="blind">복사</i>
                                </span>
                            </li>
                            <li id="vbank_re3">예금주 : 능이소프트</li>
                            <li class="end_line" id="vbank_re4">입금 기한 : 2021년 3월 29일 23:59분 까지</li>
                        </ul>
                        <p class="notice">
                            입금기한까지 입금하지 않을 경우<br />
                            구매가 자동취소 됩니다.
                        </p>
                        <div class="btn_pop_submit">확인</div>
                    </div>
                </form>
                <span id="btn_charge" class="btn_charge">충전하기</span>
            </div>            
        </section>        
        <nav class="bottom_menu">
            <ul class="list">
                <li>
                    <a href="#">매거진</a>
                </li>
                <li>
                    <a href="#">마이오피스</a>
                </li>
                <li>
                    <a href="#">멤버</a>
                </li>
                <li>
                    <a href="#">추천인 목록</a>
                </li>
                <li>
                    <a href="#">로또</a>
                </li>
            </ul>
        </nav>        
    </div>
     <script src="js/easymon.js"></script>
     
     
    <form id="frm" name="frm" style="display:none;">
            <table id="payTable">
                    <tr>
                            <td>상점 아이디</td>
                            <td>
                                    <input name="mid" value="pgshopcmsm"> <!-- 필수: 인피니소프트에서 발급한 상점 아이디 (테스트: testpay01m) -->
                            </td>
                    </tr>
                    <tr>
                            <td>라이센스키</td>
                            <td>
                                    <input name="licenseKey" value="zU8B0POXzP5cjX83KRBK/09Nhnf/lnVBqCunY1CDf0kb8L3YIWLRxzZ0JPiYksB5P/YlUKeeCfFyoUhxHQEjgQ=="> <!-- 필수: 상점 라이센스키(인피니소프트 발급) -->
                            </td>
                    </tr>
                    <tr>
                            <td>가맹점 주문번호</td>
                            <td>
                                    <input name="moid" value="<?=$orderNum?>"> <!-- 필수: 가맹점 주문번호 (중복방지, 영문 or 숫자) -->
                            </td>
                    </tr>
                    <tr>
                            <td>상품수량</td>
                            <td>
                                    <input name="goodsCnt" value="1"> <!-- 선택: 상품 수량 (숫자만 가능) -->
                            </td>
                    </tr>
                    <tr>
                            <td>상품명</td>
                            <td>
                                    <input name="goodsName" value="이지몬"> <!-- 필수: 상품명 (한글 기준 20자 이하) -->
                            </td>
                    </tr>
                    <tr>
                            <td>결제금액</td>
                            <td>
                                    <input name="amt" id="in_amt" value=""> <!-- 필수: 결제요청금액 (숫자만 가능) -->
                            </td>
                    </tr>
                    <tr>
                            <td>결제자명</td>
                            <td>
                                    <input name="buyerName" value="<?=$member["mb_name"]?>"> <!-- 필수: 결제자 이름 -->
                            </td>
                    </tr>
                    <tr>
                            <td>결제자 연락처</td>
                            <td>
                                    <input name="buyerTel" value=""> <!-- 선택: 결제자 휴대폰번호 (숫자) -->
                            </td>
                    </tr>
                    <tr>
                            <td>결제자 이메일</td>
                            <td>
                                    <input name="buyerEmail" value=""> <!-- 선택: 결제자 이메일 주소(결제 후 영수증 발송) -->
                            </td>
                    </tr>
                    <tr>
                            <td>은행코드</td>
                            <td>
                                    <input name="vbankBankCode" id="in_vbankBankCode" value=""> <!-- 필수: 가상계좌 은행코드(은행코드 표 참조) -->
                            </td>
                    </tr>
                    <tr>
                            <td>입금기한</td>
                            <td>
                                    <input name="vbankExpDate" value=""> <!-- 선택: 가상계좌 임금기한(YYYYMMDD) -->
                            </td>
                    </tr>
                    <tr>
                            <td>입금자명</td>
                            <td>
                                    <input name="vbankAccountName" value="<?=$member["mb_name"]?>"> <!-- 필수: 가상계좌 임금자명 -->
                            </td>
                    </tr>
                    <tr>
                            <td>현금영수증 금액</td>
                            <td>
                                    <input name="receiptAmt" id="in_receiptAmt" value=""> <!-- 선택: 현금영수증 금액 -->
                            </td>
                    </tr>
                    <tr>
                            <td>현금영수증 봉사료</td>
                            <td>
                                    <input name="receiptServiceAmt" value=""> <!-- 선택: 현금영수증 봉사료 -->
                            </td>
                    </tr>
                    <tr>
                            <td>증빙구분</td>
                            <td>
                                    <input name="receiptType" id="in_receiptType" value=""> <!-- 선택: 1:소득공제, 2:지출증빙 -->
                            </td>
                    </tr>
                    <tr>
                            <td>식별번호</td>
                            <td>
                                    <input name="receiptIdentity" id="in_receiptIdentity" value=""> <!-- 선택: 현금영수증 발급번호 (숫자만 가능) -->
                            </td>
                    </tr>
                    <tr>
                            <td>예비 필드</td>
                            <td>
                                    <input name="mallReserved" value=""> <!-- 예비 필드(결제완료 후 리턴받을 가맹점별 데이터) -->
                            </td>
                    </tr>
                    <tr>
                            <td>영업사원 아이디</td>
                            <td>
                                    <input name="userId" value=""> <!-- 선택: 영업사원 아이디 -->
                            </td>
                    </tr>
                    <tr>
                            <td>거래처코드</td>
                            <td>
                                    <input name="buyerCode" value=""> <!-- 선택: 거래처코드 -->
                            </td>
                    </tr>
                    <tr>
                            <td>가맹점 구매자 아이디</td>
                            <td>
                                    <input name="mallUserId" value="<?=$member["mb_id"]?>"> <!-- 선택: 가맹점 구매자 아이디 -->
                            </td>
                    </tr>
            </table>
    </form>     
     
</body>
</html>


<?php
    include_once('./include/server/dbClose.php');
?>