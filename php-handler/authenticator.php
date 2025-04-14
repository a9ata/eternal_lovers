<?php 
    session_start();
    include "../config/db.php";

    if (!isset($_SESSION['id_user'])) {
        $IDuser = $_SESSION['id_user'];
        if($IDuser === ''){
            unset($IDuser);
        }
    }

    include_once("../GA/GoogleAuthenticator.php");

    $ga = new PHPGangsta_GoogleAuthenticator();
    $secret = $ga->createSecret();

    $add_secret = "UPDATE user SET secret_key='$secret' WHERE id_user='$IDuser'";
    $result = mysqli_query($conn, $add_secret);

    header("location: verify_code.php")
?>