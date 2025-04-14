<?php
    session_start();
    require_once '../GA/GoogleAuthenticator.php';
    include "../config/db.php";
    
    if(isset($_SESSION['id_user'])){
        $IDuser = $_SESSION['id_user'];
        if($IDuser === ''){
            unset($IDuser);
        }
    }

    $ga = new PHPGangsta_GoogleAuthenticator();

    $select_user_key = "SELECT * FROM user WHERE id_user = '$IDuser'";
    $result = mysqli_query($conn, $select_user_key);
    $key_user = mysqli_fetch_array($result);
    $secret_key_user = $key_user["secret_key"];

    $code = trim($_POST['code']);

    $checkResult = $ga->verifyCode($secret_key_user, $code, 2);
    if($checkResult){
        header ("location: ../index.php");
    } else {
        header ("location: ../form_ga.php");
        $_SESSION['message'] = 'Вы ввели неправильный код';
    }


?>