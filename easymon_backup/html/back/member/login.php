<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    include_once($_SERVER["DOCUMENT_ROOT"] . '/back/encrypt/encrypt.php');

    // 로그인을 처리하는 로직
    

    
    $_POST["email"] = trim($_POST["email"]);
    $_POST["password"] = trim($_POST["password"]);
    
    $row = mysqli_fetch_array(mysqli_query($link, "select * from memberTBL where mb_id = '{$_POST["email"]}'"));
    
    if( $row["mb_id"] != "" ) { // 아이디가 존재함
        if( password_verify($_POST["password"], $row["mb_passwd"]) ) { // 비밀번호가 일치함
            session_start();
            $_SESSION["login"] = $row["mb_id"];
            
            if( $_POST["auto"] == "Y" ) {// 자동 로그인하겠다
                $encrypted1 = Encrypt($_POST["email"], $secret_key, $secret_iv);
                $encrypted2 = Encrypt($_POST["password"], $secret_key, $secret_iv);

                setcookie("autoLogin_ID", $encrypted1, time() + 9999999999, "/");
                setcookie("autoLogin_PW", $encrypted2, time() + 9999999999, "/");
            }
            
            echo "true";
            exit();
        } else { // 비밀번호가 불 일치
            echo "false";
            exit();
        }
    } else { // 아이디가 존재하지 않음
        echo "false";
        exit();
    }
    
    
    
    
    
    
    

    
    
    
    
    
    
    
    
    
    
    include_once('../../include/server/dbClose.php');
?>