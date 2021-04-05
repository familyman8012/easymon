<?php
    include_once('./include/server/dbConn.php');
    include_once('./include/server/_common.php');
    
    session_start();
    

?>

<script>
    function recommend_list_search() { // 추천인 검색 이벤트 함수
        var dnCheck = "";
        if($("#dn").is(":checked") == true) {
            dnCheck = "email";
        } else if($("#dn").is(":checked") == false) {
            dnCheck = "name";
        }
        var url = "";
        if( $("#inp").val() != "" ) {
            url = "recommend_list.php?dn="+dnCheck+"&text="+$("#inp").val();
        } else {
            url = "recommend_list.php";
        }
            window.location.href = url;
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
    <div class="wrap_app wrap_recommed_list">
        <section class="section_top">
            <div class="wrap_head">
                <h1>추천인 목록</h1>
            </div>
            <div class="toggleWrapper">
                <input type="checkbox" id="dn" class="dn" <?php if($_GET["dn"]=="email") {echo "checked='true'";} ?>>
                <label for="dn" class="toggle"><span class="toggle__handler"></span></label>
            </div>
            <div class="box_search_member">
                <input type="text" name="inp" id="inp" class="inp" placeholder="회원 검색" value="<?=$_GET["text"]?>" onkeyup="if(window.event.keyCode==13){recommend_list_search()}" />
                <span class="btn" onclick="recommend_list_search()"><i class="blind">검색</i></span>
            </div>            
        </section>
        <section class="section_container">
            <?php
                $recommenderRow1; $textTemp = "";
                if( $_GET["text"] == "" ) {
                    $recommenderRow1 = mysqli_fetch_array(mysqli_query($link, "select COUNT(*) as C from memberTBL where mb_recommender = '{$member["mb_id"]}'"));
                } else {
                    if( $_GET["dn"] == "name" ) {
                        $textTemp = " and mb_name like '%{$_GET["text"]}%'";
                    } else if( $_GET["dn"] == "email" ) {
                        $textTemp = " and mb_id like '%{$_GET["text"]}%'";
                    }
                    $recommenderRow1 = mysqli_fetch_array(mysqli_query($link, "select COUNT(*) as C from memberTBL where mb_recommender = '{$member["mb_id"]}'{$textTemp}"));
                }
            ?>
            <span class="info_total_member">총 <?php echo number_format($recommenderRow1["C"]); ?>명</span>
            <ul class="list">
                
<?php
        $recommenderRe2 = mysqli_query($link, "select * from memberTBL where mb_recommender = '{$member["mb_id"]}'{$textTemp} order by no desc");
        $recoCount = 0;
        while( $recommenderRow2 = mysqli_fetch_array($recommenderRe2) ) {
            $recoCount++;
            ?>
                <li>
                    <span class="user_account">
                        <span class="name"><?=$recommenderRow2["mb_name"]?></span>
                        <span class="email"><?=$recommenderRow2["mb_id"]?></span>
                    </span>
                    <span class="user_lv">
                        <?=$recommenderRow2["accountRank"]?>
                    </span>
                </li>  
            <?php
        }
?>
            </ul>
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
        <script>
            $(function () {
                var $percentGage = $('.percentage').text().slice(0, -1) + ',' + '100';
                $('.circular-chart .circle').attr('stroke-dasharray', $percentGage);
            })
        </script>
    </div>
</body>

</html>