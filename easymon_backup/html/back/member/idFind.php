<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    
    // 아이디 찾기를 처리하는 로직
    
    $_POST["hp"] = trim($_POST["hp"]);
    $_POST["number"] = trim($_POST["number"]);
    
    $row = mysqli_fetch_array(mysqli_query($link, "select * from authenticationNumberListTBL where hp = '{$_POST["hp"]}' and datetime > DATE_ADD(now(), INTERVAL -3 MINUTE) order by datetime desc limit 1"));
    
    if( $row["number"] == $_POST["number"] ) {
        $rowID = mysqli_query($link, "select mb_id from memberTBL where mb_hp = '{$_POST["hp"]}'");
        $array = Array();
        while( $r = mysqli_fetch_array($rowID) ) {
            array_push($array, $r["mb_id"]);
        }
        echo json_encode($array);
        exit();
    } else {
        echo "false";
        exit();
    }
    
    include_once('../../include/server/dbClose.php');
?>

