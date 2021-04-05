<?php
    include_once('./include/server/dbConn.php');
    include_once('./include/server/_common.php');
    
    
    
    session_start();
    
    
    if( $_SESSION["login"] == "" ) {
        header("Location: index.php"); 
        exit();
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body style="padding:0;margin:0;">
    <div style="width:100vw;height:100vh;background:url('./images/main.png') no-repeat left top;background-size:cover;">
        준비중입니다.
    </div>
</body>
</html>

<?php
    include_once('./include/server/dbClose.php');
?>