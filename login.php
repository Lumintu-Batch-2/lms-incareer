<?php

session_start();

// if (isset($_POST['login'])) {
//     require dirname(__FILE__) . "/Model/Users.php";
//     $objUser = new Users;
//     $login = $objUser->loginUser($_POST);

//     if ($login['is_ok']) {
//         $_SESSION['user'] = $login['data'];
//         switch ($login['data']['role']) {
//             case 1:
//                 header("location: ./Role/Student/index.php");
//                 break;
//             case 2:
//                 header("location: ./Role/Mentor/index.php");
//                 break;
//             default:
//                 # code...
//                 break;
//         }
//     }
// }

if(isset($_POST['login'])) {
    require_once "./api/get_api_data.php";

    $userData = array();

    $dataFromApi = json_decode(http_request("https://i0ifhnk0.directus.app/items/user"));

    for($i = 0; $i < count($dataFromApi->{'data'}); $i++) {        
        if($dataFromApi->{'data'}[$i]->{'user_username'} == $_POST['username']) {
            array_push($userData, $dataFromApi->{'data'}[$i]);
        }
    }

    if($userData[0]->{'user_password'} == $_POST['password']) {
        $_SESSION['user'] = $userData[0];
        switch($_SESSION['user']->{'role_id'}) {
            case 1:
                break;
            case 2:
                header("location: ./Role/Mentor/index.php");
                break;
            case 3:
                header("location: ./Role/Student/index.php");
                break;
            default:
                break;
        };
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>

<body>
    <form action="" method="POST">
        <label for="username">Username: </label>
        <input type="text" name="username" id="username" name="username">
        <label for="password">Password: </label>
        <input type="password" name="password" id="password" name="password">
        <button name="login">Login</button>
    </form>
</body>

</html>