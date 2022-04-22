<?php 

$arr = array();

for($i = 0; $i < $_POST['count']; $i++) {
    require_once "../../Model/AssignmentSubmission.php";
    $objAssg = new AssignmentSubmission;
    date_default_timezone_set("Asia/Bangkok");
    $dateupload = date("Y-m-d H:i:s");

    $objAssg->setSubmissionFileName("");
    $objAssg->setSubmissionUploadDate($dateupload);
    $objAssg->setAssignmentId($_POST['assigId']);
    $objAssg->setStudentId($_POST['studId']);

    $save = $objAssg->saveSubmission();

    array_push($arr, $save);
}

print_r(json_encode($arr));


?>