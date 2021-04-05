<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    
    // 인증번호가 맞는 지 체크 해 주는 로직
    
    $_POST["hp"] = trim($_POST["hp"]);
    $_POST["number"] = trim($_POST["number"]);
    
    $row = mysqli_fetch_array(mysqli_query($link, "select * from authenticationNumberListTBL where hp = '{$_POST["hp"]}' and datetime > DATE_ADD(now(), INTERVAL -3 MINUTE) order by datetime desc limit 1"));
    
    if( $row["number"] == $_POST["number"] ) {
        echo "true";
        exit();
    } else {
        echo "false";
        exit();
    }
    
    include_once('../../include/server/dbClose.php');
?>

