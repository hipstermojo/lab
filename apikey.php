<?php
    include_once 'DBConnector.php';
    session_start();
    if ($_SERVER['REQUEST_METHOD']!== 'POST' || !isset($_SESSION['user_id'])) {
        header('HTTP/1.0 403 Forbidden');
    } else {
        $api_key = null;
        $api_key = generateApiKey(64);
        header('Content-Type: application/json');
        echo generateResponse($api_key);
    }
    

    function generateApiKey($str_length)
    {
        $chars = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $bytes = openssl_random_pseudo_bytes(3*$str_length/4+1);
        $repl = unpack('C2', $bytes);

        $first = $chars[$repl[1] % 62];
        $second = $chars[$repl[2] % 62];
        return strtr(substr(base64_encode($bytes), 0 , $str_length),'+/',"$first$second");
    }

    function saveApiKey($user_id,$api_key): bool
    {
        $db = new DBConnector();
        $res = $db->conn->query("INSERT INTO api_keys(user_id,api_key) VALUES ($user_id, '$api_key')");
        return $res !== FALSE;
    }

    function generateResponse($api_key)
    {
        if (saveApiKey(intval($_SESSION['user_id']),$api_key)) {
            $res = ['success'=>1,'message'=>$api_key];
        } else {
            $res = ['success'=>0,'message'=>'Something went wrong. Please regenerate the API key'];
        }
        return json_encode($res);
    }
?>