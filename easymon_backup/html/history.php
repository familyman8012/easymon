<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="./webicon/uicons-regular-straight/css/uicons-regular-straight.css">
    <title>easymon</title>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.8.18/themes/base/jquery-ui.css" type="text/css" />
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.8.18/jquery-ui.min.js"></script>
</head>

<body>
    <div class="wrap_app wrap_history">
        <section class="section_top">
            <div class="wrap_head">
                <h1>내역</h1>
            </div>
            <ul class="search_history_option">
                <li class="on">전체</li>
                <li>입금</li>
                <li>출금</li>
            </ul>
            <div class="wrap_calendar">
                <div class="box">
                    <input type="text" placeholder="시작일" name="fr_date" id="Datepicker1" class="frm_input" size="11"
                        maxlength="10" value="2021-04-01">
                    <label for="fr_date" class="label_frdate">
                        <i class="blind">시작일</i>
                    </label>
                </div>
                <span class="txt_tilde">~</span>
                <div class="box">
                    <input type="text" placeholder="종료일" name="la_date" id="Datepicker2" class="frm_input" size="11"
                        maxlength="10" value="2021-04-01">
                    <label for="fr_date" class="label_frdate">
                        <i class="blind">종료일</i>
                    </label>
                </div>               
            </div>
            <span class="btn_search">조회하기</span>
        </section>
        <section class="section_container">
            <div class="total_search">
                <dl>
                    <dt>검색결과 총합</dt>
                    <dd>565,000 P</dd>
                </dl>
            </div>
            <div class="wrap_history_box wrap_income">
                <dl class="check_date">
                    <dt>입금</dt>
                    <dd>2021-03-31 11:44:09</dd>
                </dl>
                <div class="desc"><span class="tit">직급 보너스</span><span class="point">10,050 P</span></div>
            </div>
            <div class="wrap_history_box wrap_income">
                <dl class="check_date">
                    <dt>입금</dt>
                    <dd>2021-03-31 11:44:09</dd>
                </dl>
                <div class="desc"><span class="tit">추천 보너스</span><span class="point">213,050 P</span></div>
            </div>
            <div class="wrap_history_box wrap_income">
                <dl class="check_date">
                    <dt>입금</dt>
                    <dd>2021-03-31 11:44:09</dd>
                </dl>
                <div class="desc"><span class="tit">특별 배당</span><span class="point">90,780 P</span></div>
            </div>
            <div class="wrap_history_box wrap_income">
                <dl class="check_date">
                    <dt>입금</dt>
                    <dd>2021-03-31 11:44:09</dd>
                </dl>
                <div class="desc"><span class="tit">영업 수익</span><span class="point">0 P</span></div>
                <div class="desc"><span class="tit">충전</span><span class="point">0 P</span></div>
            </div>
            <div class="wrap_history_box wrap_income">
                <dl class="check_date">
                    <dt>입금</dt>
                    <dd>2021-03-31 11:44:09</dd>
                </dl>
                <div class="desc"><span class="tit">충전</span><span class="point">0 P</span></div>
            </div>
             <div class="wrap_history_box wrap_outcome">
                 <dl class="check_date">
                     <dt>출금</dt>
                     <dd>2021-03-30 23:44:09</dd>
                 </dl>
                 <ul class="list">
                     <li><span class="tit">업그레이드</span><span class="point">-1,000,000 P</span></li>
                 </ul>
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
         <script src="js/easymon.js"></script>
        <script>
            $(function () {
                $("#Datepicker1").datepicker({
                    changeMonth: true,
                    dayNames: ['월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일'],
                    dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'],
                    monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월',
                        '12월'
                    ],
                    dateFormat: 'yy-mm-dd'
                });
                $("#Datepicker2").datepicker({
                    changeMonth: true,
                    dayNames: ['월요일', '화요일', '수요일', '목요일', '금요일', '토요일', '일요일'],
                    dayNamesMin: ['월', '화', '수', '목', '금', '토', '일'],
                    monthNamesShort: ['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12'],
                    monthNames: ['1월', '2월', '3월', '4월', '5월', '6월', '7월', '8월', '9월', '10월', '11월',
                        '12월'
                    ],
                    dateFormat: 'yy-mm-dd'
                });
            });
        </script>
    </div>
</body>

</html>