<?php

require_once "./api/get_request.php";
require_once "./api/post_request.php";

session_start();

if (isset($_POST['login'])) {
    $arr = array(
        "email" => $_POST['email'],
        "password" => $_POST['password']
    );

    $login = json_decode(post_request("https://account.lumintulogic.com/api/login.php", json_encode($arr)));
    $access_token = $login->{'data'}->{'accessToken'};
    $expiry = $login->{'data'}->{'expiry'};

    if ($login->{'success'}) {
        $userData = json_decode(http_request_with_auth("https://account.lumintulogic.com/api/user.php", $access_token));
        $_SESSION['user_data'] = $userData;
        setcookie('X-LUMINTU-REFRESHTOKEN', $access_token, strtotime($expiry));

        switch ($userData->{'user'}->{'role_id'}) {
            case 1:
                // Admin
                break;
            case 2:
                // Mentor
                // var_dump($_SESSION['user_data']->{'user'}->{'role_id'});
                header("location: ./Role/Mentor/");
                break;
            case 3:
                // Student
                header("location: ./Role/Student/");
                break;
            default:
                break;
        }

        // var_dump($_SESSION['user_data']);
        // var_dump($_COOKIE['X-LUMINTU-REFRESHTOKEN']);
    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>

</head>

<body>
    <form action="" method="POST">
        <label for="email">Email: </label>
        <input type="text" name="email" id="email">
        <br>
        <label for="password">Password: </label>
        <input type="text" name="password" id="password">
        <br>
        <button type="submit" id="login" name="login">Login</button>
    </form>

</body>

</html>