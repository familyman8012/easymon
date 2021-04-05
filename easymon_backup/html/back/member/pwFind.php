<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    
    // 비밀번호 찾기를 처리하는 로직
    
    $_POST["hp"] = trim($_POST["hp"]);
    $_POST["number"] = trim($_POST["number"]);
    $_POST["email"] = trim($_POST["email"]);
    
    $mbRow = mysqli_fetch_array(mysqli_query($link, "select * from memberTBL where mb_id = '{$_POST["email"]}' and mb_hp = '{$_POST["hp"]}'"));
    if( $mbRow["mb_id"] == "" ) {
        echo "ERROR1";
        exit();
    }
    
    $row = mysqli_fetch_array(mysqli_query($link, "select * from authenticationNumberListTBL where hp = '{$_POST["hp"]}' and datetime > DATE_ADD(now(), INTERVAL -3 MINUTE) order by datetime desc limit 1"));
    
    if( $row["number"] == $_POST["number"] ) {
        $write_password = generateRandomPassword(8, 4);
        $pass_hash = password_hash($write_password, PASSWORD_DEFAULT);
        mysqli_query($link, "update memberTBL set mb_passwd = '{$pass_hash}' where mb_id = '{$_POST["email"]}'");
        
        echo $write_password;
        exit();
    } else {
        echo "false";
        exit();
    }
    
    
    
    function generateRandomPassword($length=8, $strength=0) {
        $vowels = 'aeuy';
        $consonants = 'bdghjmnpqrstvz';
        if ($strength & 1) {
            $consonants .= 'BDGHJLMNPQRSTVWXZ';
        }
        if ($strength & 2) {
            $vowels .= "AEUY";
        }
        if ($strength & 4) {
            $consonants .= '23456789';
        }
        if ($strength & 8) {
            $consonants .= '@#$%';
        }

        $password = '';
        $alt = time() % 2;
        for ($i = 0; $i < $length; $i++) {
            if ($alt == 1) {
                $password .= $consonants[(rand() % strlen($consonants))];
                $alt = 0;
            } else {
                $password .= $vowels[(rand() % strlen($vowels))];
                $alt = 1;
            }
        }
        return $password;
    }
    
    
    include_once($_SERVER["DOCUMENT_ROOT"].'/include/server/dbClose.php');
    
    
?>

