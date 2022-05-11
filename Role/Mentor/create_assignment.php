<?php
session_start();

$loginPath = "../../login.php";
if (!isset($_COOKIE['X-LUMINTU-REFRESHTOKEN'])) {
    unset($_SESSION['user_data']);
    header("location: " . $loginPath);
}

if (!isset($_SESSION['user_data'])) {
    header("location: " . $loginPath);
    die;
}


switch ($_SESSION['user_data']->{'user'}->{'role_id'}) {
    case 1:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Admin/');
        </script>
        ";
        break;
    case 3:
        echo "
        <script>
            alert('Akses ditolak!');
            location.replace('../Student/');
        </script>
        ";
        break;
    default:
        break;
}
$is_ok = false;
$msg = "";

$resp = array();

if (isset($_POST['data'])) {
    $data = json_decode($_POST['data']);
    $arrayData = array(
        "title" => $data->{'title'},
        "desc" => $data->{'description'},
        "start-date" => $data->{'startDate'},
        "end-date" => $data->{'dueDate'},
        "assign_type" => $data->{'assgType'}
    );


    require_once "../../api/get_api_data.php";
    require_once "../../api/get_request.php";


    $userData = array();
    $modulJSON = json_decode(http_request("https://lessons.lumintulogic.com/api/modul/read_modul_rows.php"));
    $token = $_COOKIE['X-LUMINTU-REFRESHTOKEN'];
    $usersData = json_decode(http_request_with_auth("https://account.lumintulogic.com/api/users.php", $token));


    for ($i = 0; $i < count($modulJSON->{'data'}); $i++) {
        if ($modulJSON->{'data'}[$i]->{'id'} == (int)$_GET['course_id']) {
            for ($j = 0; $j < count($usersData->{'user'}); $j++) {
                if ($modulJSON->{'data'}[$i]->{'batch_id'} == $usersData->{'user'}[$j]->{'batch_id'} && $usersData->{'user'}[$j]->{'role_id'} == 3) {
                    array_push($userData, $usersData->{'user'}[$j]);
                }
            }
        }
    }

    require "../../Model/Assignments.php";
    $objAsign = new Assignments;
    // $create = $objAsign->createAssignment($_POST, $_FILES, $_GET['subject_id'], $_SESSION['user']->{'user_id'}, $userData);
    $create = $objAsign->createAssignment($arrayData, $_FILES, $_GET['subject_id'], $_SESSION['user_data']->{'user'}->{'user_id'}, $userData);


    $create_status = $create['is_ok'] ? "true" : "false";

    if ($create['is_ok']) {
        $is_ok = true;
        $msg = $create['msg'];
    } else {
        $msg = $create['msg'];
    }

    $resp = array(
        "is_ok" => $is_ok,
        "msg" => $msg
    );
} else {
    $resp = array(
        "is_ok" => false,
        "msg" => "You don't have access to this file !!!"
    );
}

print_r(json_encode($resp));
