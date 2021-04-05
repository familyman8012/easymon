<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    
    // 회원가입을 처리하는 로직
    
    $_POST["write_email"] = trim($_POST["write_email"]); // 아이디
    $_POST["write_password"] = trim($_POST["write_password"]); // 비밀번호1
    $_POST["write_password_chk"] = trim($_POST["write_password_chk"]); // 비밀번호2
    $_POST["write_name"] = trim($_POST["write_name"]); // 이름
    $_POST["write_number"] = trim($_POST["write_number"]); // 핸드폰 번호
    $_POST["write_certi_num"] = trim($_POST["write_certi_num"]); // 인증번호
    $_POST["gender"] = trim($_POST["gender"]); // 성별
    $_POST["write_birth_num"] = trim($_POST["write_birth_num"]); // 생년월일
    $_POST["write_recome_email"] = trim($_POST["write_recome_email"]); // 추천인 아이디
    
    
    $CRow1 = mysqli_fetch_array(mysqli_query($link,"select * from memberTBL where mb_id = '{$_POST["write_email"]}'"));
    if( $CRow1["mb_id"] != "" ) {
        echo "ERROR1";
        exit();
    }
    
//    $CRow2 = mysqli_fetch_array(mysqli_query($link,"select * from memberTBL where mb_hp = '{$_POST["write_number"]}'"));
//    if( $CRow2["mb_id"] != "" ) {
//        echo "ERROR2";
//        exit();
//    }
    
    if( $_POST["write_recome_email"] != "" ) { 
        $CRow3 = mysqli_fetch_array(mysqli_query($link,"select * from memberTBL where mb_id = '{$_POST["write_recome_email"]}'"));
        if( $CRow3["mb_id"] == "" ) {
            echo "ERROR3"; // 지정한 추천인이 없을 때
            exit();
        }
    }
    
    
    $pass_hash = password_hash($_POST["write_password"], PASSWORD_DEFAULT);
    $re = mysqli_query($link,"insert into memberTBL set mb_country='KOREA', mb_id='{$_POST["write_email"]}', mb_passwd='{$pass_hash}', mb_name='{$_POST["write_name"]}', mb_hp='{$_POST["write_number"]}', mb_gender={$_POST["gender"]}, mb_birth='{$_POST["write_birth_num"]}', mb_recommender='{$_POST["write_recome_email"]}'") or die("ERR");

    if( $re ) {
        session_start();
        $_SESSION["login"] = $_POST["write_email"];
        echo "true";
        exit();
    } else {
        echo "false";
        exit();
    }
?>

<?php
    include_once('../../include/server/dbClose.php');
?>