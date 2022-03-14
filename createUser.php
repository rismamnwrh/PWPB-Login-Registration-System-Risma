<?php
    require 'db_conn.php';
    // get data from database in id
    if (isset($_POST['create'])) {
        $name = $_POST['name'];
        $uname = $_POST['uname'];

        $pass = $_POST['password'];
        $re_pass = $_POST['confirm_password'];

        $errors = [];

        empty($name) ? array_push($errors, "Field Name is required") : '';
        empty($uname) ? array_push($errors, "Field Username is required") : '';
        empty($pass) ? array_push($errors, "Field Password is required") : '';
        empty($re_pass) ? array_push($errors, "Field Confirm Password is required") : '';

        $pass != $re_pass ? array_push ($errors, "Password you typed doesn't match") : '';

        if (count($errors) == 0) {
            $user_check_query = "SELECT * FROM users WHERE user_name='$name' LIMIT 1";
            $result = mysqli_query($conn, $user_check_query);
            $user = mysqli_fetch_assoc($result);

            // Checking user in database
            if ($user) {
                if ($user['uname'] === $uname) {
                    array_push($errors, "Username already exists");
                }
            }

            $password = md5($password);
            $query = "INSERT INTO users (name, user_name, password) VALUES ('$name', '$uname', '$pass')";
            mysqli_query($conn, $query);
            $_SESSION['message'] = 'Data has been Created';
            header('location: data_users.php');
        }
    }

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container py-5">
        <h2>Create User</h2>
        <?php global $errors;
            if ($errors) {
                foreach ($errors as $err) {
                    echo "<p class='alert alert-danger py-1'>$err</p>";
                }
            }
        ?>
        <form class="col col-sm-5 col-lg-6 col-md-7" action="" method="POST">
            <div class="mb-3">
                <label class="form-label">Name</label>
                <input type="text" name="name" placeholder="Full Name" class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Username</label>
                <input type="text" name="uname" placeholder="Username"  class="form-control">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="password" name="password" placeholder="Password" class="form-control">
            </div>
            <div class="mb-2">
                <label for="name">Confirm Password</label>
                <input class="form-control" type="password" name="confirm_password">
            </div>
            <button type="submit" name="create" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>
</html>