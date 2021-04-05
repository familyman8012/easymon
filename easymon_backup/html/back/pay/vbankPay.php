<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/_common.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/back/send/SMS.php');
    
    
    // 가상계좌 발급 완료를 처리하는 로직
    
    
    session_start();
    
    
    if( $_SESSION["login"] == "" ) {
        header("Location: index.php"); 
        exit();
    }
    
    if( $_POST["tid"] == "" && $_POST["moid"] == "" && $_POST["amt"] == "" && $_POST["authDate"] == "" && $_POST["vbankBankNm"] == "" && $_POST["vbankNum"] == "" ) {
        echo "ERROR1";
    }
    
    
    mysqli_query($link, "insert into vbankPayTBL set mb_id = '{$_SESSION["login"]}', tid = '{$_POST["tid"]}', moid = '{$_POST["moid"]}', amt = {$_POST["amt"]}, authDate = '{$_POST["authDate"]}', vbankBankNm = '{$_POST["vbankBankNm"]}', vbankNum = '{$_POST["vbankNum"]}'") or die("ERROR1");
    
$smsMSG_return1 = smsMSG($member["mb_hp"], "[이지몬] 가상계좌 발급
은행명:{$_POST["vbankBankNm"]}
계좌번호:{$_POST["vbankNum"]}
금액:" . number_format($_POST["amt"]) . "원");
    
if( $smsMSG_return1 == 1 ) {
    echo "true";
} else {
    echo "false";
}
    
?>

<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbClose.php');
?>