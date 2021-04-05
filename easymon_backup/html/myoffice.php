<?php
    include_once('./include/server/dbConn.php');
    include_once('./include/server/_common.php');
    
    session_start();
    
    
    if( $_SESSION["login"] == "" ) {
        header("Location: index.php"); 
        exit();
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="./webicon/uicons-regular-straight/css/uicons-regular-straight.css">
    <link rel="stylesheet" href="css/calendar.css">
    <script type="text/javascript" src="./js/calendar.js"></script>
    <title>easymon</title>
</head>
<body>
    <div class="wrap_app wrap_myoffice">
        <div class="mask" style="display:none;"></div>
        <div class="btn_floatin_btn">
            <i class="blind">광고보기</i>
        </div>
        <section class="section_top">
            <div class="wrap_head">
                <h1>마이오피스</h1>
            </div>
            <div class="wrap_state">
                <h2><span class="name"><?=$member["mb_name"]?></span>님</h2>
                <div class="have_state">
                    <div class="state_mon"><span class="num"><?php echo number_format($member["mb_mon"]); ?></span>몬</div>
                    <div class="state_point"><span class="num"><?php echo number_format($member["mb_point"]); ?></span>P</div>
                </div>
                <a href="./charge.php" class="btn_change">충전하기 ></a>
            </div>
            <div class="wrap_total_income">
                <h3>총 수입금</h3>
                <table>
                    <thead>
                        <tr>
                            <th></th>
                            <th>전일</th>
                            <th>누적</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>직급 보너스</td>
                            <td>345,800</td>
                            <td>923,123,000</td>
                        </tr>
                        <tr>
                            <td>추천 보너스</td>
                            <td>23,123,000</td>
                            <td>3,123,000</td>
                        </tr>
                        <tr>
                            <td>특별 배당</td>
                            <td>23,000</td>
                            <td>123,000</td>
                        </tr>
                        <tr>
                            <td>영업 수익</td>
                            <td>23,000</td>
                            <td>123,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
        <section class="section_container">
            <div class="wrap_cont wrap_daily_work">
                <h3 class="tit">출석 체크</h3>
                <div class="wrap_pay_select">
                    <h4>차감 방식 선택</h4>
                    <ul class="list_sel_property">
                        <li class="box_sel_mon">
                            <input type="radio" name="sel_pay_select" id="pay_select_mon" checked />
                            <label for="pay_select_mon">몬</label>
                        </li>
                        <li class="box_sel_point">
                            <input type="radio" name="sel_pay_select" id="pay_select_point" />
                            <label for="pay_select_point">포인트</label>
                        </li>
                    </ul>
                    <div class="have_total_property">
                        <span class="num">1234</span><span class="txt">몬</span>
                    </div>
                    <p class="txt">*하루 일과는 100몬 또는 5,000 P가 차감됩니다.</p>                    
                </div>
                <div class="wrap_kCalendar">
                    <div id="kCalendar"></div>
                    <div id="kCalendar_pop"></div>
                    <div class="mask_cal"></div>
                </div>
                <input type="hidden" id="hidden_fin_mon" />
                <div class="btn btn_achieve">일과 달성하기</div>
            </div>
            <div class="wrap_cont wrap_lv_info">
                <h3>레벨 정보</h3>
                <div class="current_lv">
                    <h4>인턴</h4> <!-- h4 안의 직급을 db 에서 불러와서 바꾸면 레이아웃과 해당 스크립트 작동도 바뀝니다. (ex <h4>시니어 LV.1<h4> 로 수정해보세요.-->
                    <div class="view_org">
                        <span class="total_contribution">기여도 2,048</span>
                        <div class="wrap_people_info">
                            <span class="left">12,048명</span> 
                            <span class="right">112,048명</span>
                        </div>
                    </div>
                </div>
                <div class="next_lv on"> <!-- 조건 충족시 on ex) next_lv on -->
                    <h4>루키</h4> <!-- <h4>안의 직급은 current_lv 다음 직급을 넣어주시면 됩니다. -->
                    <div class="view_org">
                        <span class="total_contribution">기여도 4,096</span>
                        <div class="wrap_people_info">
                            <span class="before_lv">시니어 Lv.1</span>
                            <span class="left">충족</span>
                            <span class="right under">부족</span>                        
                        </div>
                    </div>
                    <span class="btn_upgrade">업그레이드</span>
                </div>
            </div>
            <div class="wrap_cont wrap_bonus">
                <h3>추천 보너스</h3>
                <div class="box_chart">
                    <div class="flex-wrapper">
                        <div class="single-chart">
                            <!--추천 보너스 원형 차트입니다. <text x="18" y="19" class="percentage">10%</text> 에서 10% 만 숫자가 바뀌면 자동으로
                            차트가 바뀔 수 있게 스크립트 작업을 해두었습니다. 예를들어 <text x="18" y="19" class="percentage">20%</text> 로 바꾸어보세요
                             <text x="18" y="25" class="percentage_txt">121,231</text> 의 121,231 는 마음대로 바꾸셔도 됩니다. -->
                            <svg viewBox="0 0 36 36" class="circular-chart">
                                <path class="circle-bg" d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <path class="circle" d="M18 2.0845
                                a 15.9155 15.9155 0 0 1 0 31.831
                                a 15.9155 15.9155 0 0 1 0 -31.831" />
                                <text x="18" y="19" class="percentage">10%</text>
                                <text x="18" y="25" class="percentage_txt">121,231</text>
                            </svg>
                        </div>
                </div>
            </div>           
        </section>
        <div id="pop_daily_work" class="pop pop_charge_comm pop_daily_work" style="display:none;">
            <span class="btn_close"><i class="blind">팝업닫기</i></span>
            <h2>일일 일과</h2>
            <p class="txt_useinfo">
                <span id="fisrt_date"></span> ~ <span id="last_date"></span><br />
                일과 달성 완료
            </p>
            <strong>총 <span id="use_property"></span><span class="unit"></span>을 사용하셨습니다.</strong>            
            <div class="btn_pop_submit">확인</div>
        </div>
        <!-- <div id="pop_daily_work" class="pop pop_charge_comm pop_daily_work" style="display:none;">
            <span class="btn_close"><i class="blind">팝업닫기</i></span>
            <h2>일일 일과</h2>
            <p class="txt_useinfo">
                <span id="pop_current_step">내일 받을 직급 보너스</span>를 위해<br />
                준비하세요.
            </p>
            <div class="info_use_mon">-2몬</div>
            <p class="txt_notice">*몬은 광고 시청 후 받을 수 있습니다.</p>
            <div class="btn_pop_submit">다음</div>
        </div> -->
        <div id="pop_dailywork_cannot" class="pop pop_charge_comm pop_dailywork_cannot" style="display:none;">
            <p class="txt">몬이 부족하여<br />
                다음 단계로 넘어갈 수 없습니다.</p>
            <div class="btn_pop_submit">확인</div>
        </div>
        <div id="pop_rookie_change" class="pop pop_charge_comm pop_rookie_change" style="display:none;">
            <span class="btn_close"><i class="blind">팝업닫기</i></span>
            <h2>루키 전환</h2>
            <div class="wrap_support_is">
                <input type="checkbox" id="inp_support_is" checked>
                <label for="inp_support_is" id="label_support_is">후원인 지정</label>
            </div>
            <div class="support_write">
                <input type="email" placeholder="후원인 이메일" class="inp_recomm_email"  />
                <p class="notice">*입력하신 후원인은 가입 후 입력, 변경이 불가합니다.</p>
                <div class="btn_box">
                    <span class="btn on">좌측</span>
                    <span class="btn">우측</span>
                </div>
            </div>
            <div class="btn_pop_submit">다음</div>
        </div>
        <!-- 레벨정보의 업그레이드 버튼 클릭시, 인턴에서 루키전환을 사용할때도, 다른직급 예를들어 시니어lv.1 에서 시니어lv.2 로 바뀔때도 이 팝업이 뜹니다.
          <h2></h2> 안의 내용과 <p class="txt_contribution"></p> <span class="lv_require_point"></span> 의 내용이 해당사항에 맞게 바꾸어주세요.-->
        <div id="pop_upgrade_lv" class="pop pop_charge_comm pop_upgrade_lv" style="display:none;">
            <span class="btn_close"><i class="blind">팝업닫기</i></span>
            <h2>루키 전환</h2>            
            <p class="txt_contribution">기여도 4,096</p>
            <p class="info_upgrade_point">
                업그레이드에 필요한 포인트는<br />
                <span class="lv_require_point">10</span>만
                <!-- <span class="lv_require_point">100만</span>  -->
                포인트입니다.
            </p>
            <p class="notice">
                사용된 포인트는 환불 및 철회 불가합니다.<br />
                신중히 선택해 주세요.
            </p>
            <div class="btn_pop_submit">업그레이드</div>
        </div>
        <div id="pop_upgrade_fin" class="pop pop_charge_comm pop_upgrade_fin" style="display:none;">
            <p class="txt">업그레이드가 완료되었습니다.</p>
            <div class="btn_pop_submit">확인</div>
        </div>        
        <div id="pop_support_no" class="pop pop_charge_comm pop_support_no" style="display:none;">
            <p class="txt">후원인 없이 진행하시겠습니까?<br />
                <span class="notice">후원인 임의배정됩니다.</span>
            </p>
            <div class="btn_box">
                <span class="btn btn_cancle">취소</span>
                <span class="btn btn_confirm">확인</span>
            </div>
        </div>
        <div id="pop_upgrade_not" class="pop pop_charge_comm pop_upgrade_fin" style="display:none;">
            <p class="txt">업그레이드가 불가합니다.<br />
                포인트 잔액을 확인해주세요.</p>
            <div class="btn_pop_submit">확인</div>
        </div>
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
        
         <script src="js/easymon.js"></script>
        <script>
            $(function(){
                var $percentGage = $('.percentage').text().slice(0,-1)+ ',' + '100';
                $('.circular-chart .circle').attr('stroke-dasharray', $percentGage);
            })
        </script>
    </div>
</body>
</html>

<?php
    include_once('./include/server/dbClose.php');
?>