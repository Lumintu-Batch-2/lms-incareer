<?php

    session_start();
    
    if(isset($_POST['login'])) {
        require dir(__FILE__) . "./Model/Users.php";
        $objUser = new Users;        
        $login = $objUser->loginUser($_POST);
        
        if($login['is_ok']) {
            $_SESSION['user'] = $login['data'];
            header("location: assignment.php");
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