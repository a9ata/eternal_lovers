<?php 
    session_start();
    include "../config/db.php";

    if (!isset($_SESSION['id_user'])) {
        $IDuser = $_SESSION['id_user'];
        if($IDuser === ''){
            unset($IDuser);
        }
    }

    $queryDelete = "UPDATE user SET secret_key='' WHERE id_user=$IDuser";
    $result = mysqli_query($conn, $queryDelete);

    header("location: ../profile.php")
?>