<?php
session_start();
// require('./login.php')
if (!isset($_SESSION['user'])) {
    header("location: ../../login.php");
}

switch ($_SESSION['user']['role']) {
    case 2:
        echo "<script>alert('Akses Ditolak');
    location.replace('../Mentor/index.php')</script>";
        break;
    case 3:
        echo "<script>alert('Akses Ditolak');
    location.replace('../../login.php')</script>";
        break;

    default:
        break;
}
?>

<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
</head>

<body>
    <h1>Hello, world!</h1>

</body>

</html>