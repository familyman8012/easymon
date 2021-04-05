<?php
    include_once($_SERVER["DOCUMENT_ROOT"] . '/include/server/dbConn.php');
    include_once('./SMS.php');
    
    $rand = GenerateString(4); // 임의의 4자리 수 뽑기
    
    $_POST["hp"] = trim($_POST["hp"]);
    
    
    $smsMSG_return1 = smsMSG($_POST["hp"], "[이지몬] 인증번호 : {$rand}");


    if( $smsMSG_return1 == 1 ) {
        mysqli_query($link, "insert into authenticationNumberListTBL set number = '{$rand}', hp = '{$_POST["hp"]}'");
        echo "true";
        exit();
    } else {
        echo "false";
        exit();
    }
    
?>


<?php
    function GenerateString($length) {  
       $characters  = "0123456789";

       $string_generated = "";  

       $nmr_loops = $length;  
       while ($nmr_loops--)  
       {  
           $string_generated .= $characters[mt_rand(0, strlen($characters) - 1)];  
       }  

       return $string_generated;  
   }  

    include_once('../../include/server/dbClose.php');
?>