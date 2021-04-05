<?php
    include_once($_SERVER["DOCUMENT_ROOT"] .'/include/server/dbConn.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/back/encrypt/encrypt.php');
    
    session_start();
    

    
    // 자동 로그인 체크 로직
    if( $_SESSION["login"] == "" && $_COOKIE["autoLogin_ID"] != "" && $_COOKIE["autoLogin_PW"] != "" ) {
        $decrypted1 = Decrypt($_COOKIE["autoLogin_ID"], $secret_key, $secret_iv);
        $decrypted2 = Decrypt($_COOKIE["autoLogin_PW"], $secret_key, $secret_iv);
        
        $autoLoginCheckRow = mysqli_fetch_array(mysqli_query($link, "select * from memberTBL where mb_id = '{$decrypted1}'"));
        if( password_verify($decrypted2, $autoLoginCheckRow["mb_passwd"]) ) { // 자동 로그인 아이디 비번 정보 일치
            $_SESSION["login"] = $decrypted1;
        }
    }
    
    $member = mysqli_fetch_array(mysqli_query($link, "select * from memberTBL where mb_id = '{$_SESSION["login"]}'"));
    

    
    
//    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbClose.php');
?>