<?php

//    if( smsMSG("01026591346", "안녕") == "1" ) {
//        echo "성공성공성공성공성공성공성공성공성공성공성공성공성공성공성공";
//    }
    

    

    function smsMSG( $receiver, $msg ) {
        $_apiURL    =	'https://apis.aligo.in/send/';
        $_hostInfo  =	parse_url($_apiURL);
        $_port      =	(strtolower($_hostInfo['scheme']) == 'https') ? 443 : 80;
        $_variables =	array(
            'key'      => "ukqd7brex9cf9o3ggvy3bxr37brxxkm1",
            'user_id'      => "neungsoft",
            'sender'      => "01026591346",
            'receiver'      => $receiver,
            'msg'      => $msg
        );


        $oCurl = curl_init();
        curl_setopt($oCurl, CURLOPT_PORT, $_port);
        curl_setopt($oCurl, CURLOPT_URL, $_apiURL);
        curl_setopt($oCurl, CURLOPT_POST, 1);
        curl_setopt($oCurl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($oCurl, CURLOPT_POSTFIELDS, http_build_query($_variables));
        curl_setopt($oCurl, CURLOPT_SSL_VERIFYPEER, FALSE);

        $ret = curl_exec($oCurl);
        $error_msg = curl_error($oCurl);
        curl_close($oCurl);


        // JSON 문자열 배열 변환
        $retArr = json_decode($ret);

        return $retArr->result_code; // 1이면 성공, 0이면 실패(발송 실패)

    }
    
?>