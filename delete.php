<?php
    require 'db_conn.php';
    $id = $_GET['id'];
    $result = mysqli_query($conn, "SELECT * FROM users WHERE id=$id");
    $row = mysqli_fetch_assoc($result);


    $result = mysqli_query($conn, "DELETE FROM users WHERE id=$id");
    if ($result) {
        header('location: data_users.php');
        $_SESSION['message'] = 'Data has been Deleted';
    }