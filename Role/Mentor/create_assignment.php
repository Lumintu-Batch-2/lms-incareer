<?php
session_start();

$loginPath = "../../login.php";

if (!isset($_SESSION['user'])) {
    header("location: " . $loginPath);
    die;
}

switch ($_SESSION['user']->{'role_id'}) {
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../../Admin/');
        </script>
        ";
        break;
    case 3:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../../Student/');
        </script>
        ";
        break;
    default:
        break;
}

if (isset($_POST['upload'])) {

    require_once "../../api/get_api_data.php";

    $userData = array();
    $modulJSON = json_decode(http_request("https://ppww2sdy.directus.app/items/modul_name"));
    $userBatchJSON = json_decode(http_request("https://i0ifhnk0.directus.app/items/user_batch"));
    $userJSON = json_decode(http_request("https://i0ifhnk0.directus.app/items/user"));


    for ($i = 0; $i < count($modulJSON->{'data'}); $i++) {
        if ($modulJSON->{'data'}[$i]->{'id'} == (int)$_GET['course_id']) {
            for ($j = 0; $j < count($userBatchJSON->{'data'}); $j++) {
                if ($modulJSON->{'data'}[$i]->{'batch_id'} == $userBatchJSON->{'data'}[$j]->{'batch_batch_id'}) {
                    for ($k = 0; $k < count($userJSON->{'data'}); $k++) {
                        if ($userBatchJSON->{'data'}[$j]->{'user_user_id'} == $userJSON->{'data'}[$k]->{'user_id'} && $userJSON->{'data'}[$k]->{'role_id'} == 3) {
                            array_push($userData, $userJSON->{'data'}[$k]);
                        }
                    }
                }
            }
        }
    }

    require "../../Model/Assignments.php";
    $objAsign = new Assignments;
    // $create = $objAsign->createAssignment($_POST, $_FILES, $_GET['subject_id'], $_SESSION['user']->{'user_id'}, $userData);
    $create = $objAsign->createAssignment($_POST, $_FILES, $_GET['subject_id'], 0, $userData);


    // var_dump($create);
    // die;
    $create_status = $create['is_ok'] ? "true" : "false";

    if ($create['is_ok']) {
        echo "
        <script>
            alert('" . $create['msg'] . "');
            location.replace('assignment.php?course_id=" . $_GET['course_id'] . "&subject_id=" . $_GET['subject_id'] . "')
        </script>";
    } else {
        echo "
        <script>
            alert('" . $create['msg'] . "');
            location.replace('create_assignment.php?subject_id=" . $_GET['subject_id'] . "')
        </script>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create new Assigment</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.4.1/dist/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

</head>

<body>
    <form method="POST" enctype="multipart/form-data">
        <label for="title">Assignment Title: </label>
        <input type="text" id="title" name="title">
        <br>
        <label for="start-date">Tanggal mulai: </label>
        <input type="datetime-local" name="start-date" id="start-date">
        <label for="end-date">Tanggal akhir: </label>
        <input type="datetime-local" name="end-date" id="end-date">
        <label for="assign_type">Assignment Type: </label>
        <select name="assign_type" id="assign_type">
            <option value="" default>---</option>
            <option value="1">Exam</option>
            <option value="2">Task</option>
        </select>
        <div class="form-group">
            <label for="exampleFormControlFile1">Tambahkan file</label>
            <input type="file" class="form-control-file" id="exampleFormControlFile1" name="filename">
        </div>
        <label for="desc">Deksripsi: </label>
        <br>
        <textarea name="desc" id="desc" cols="30" rows="10"></textarea>
        <br>
        <button class="btn btn-primary" type="submit" name="upload">Upload assignment</button>
    </form>
</body>

</html>