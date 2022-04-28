<?php

$arr = array();
$token = md5(uniqid());

require_once "../../Model/AssignmentSubmission.php";

$assign = new AssignmentSubmission;
$assign->setAssignmentId($_POST['assigId']);
$assign->setStudentId($_POST['studId']);
$sub = $assign->getSubmissionByAssignIdAndStudentId();
// print_r($_POST['count']);
// // print_r(!empty($sub));
// die();


if (!empty($sub)) {

    if ($sub['is_finish'] == 0) { //untuk pertama kali submit file
        $assign->setSubmissionFileName('N/A');
        $del = $assign->deleteNAassignmentSubmission();
        // print_r('true');
        // die();

        for ($i = 0; $i < $_POST['count']; $i++) {
            // print_r('true');
            // die();
            $objAssg = new AssignmentSubmission;
            date_default_timezone_set("Asia/Bangkok");
            $dateupload = date("Y-m-d H:i:s");

            $objAssg->setSubmissionFileName("");
            $objAssg->setSubmissionUploadDate($dateupload);
            $objAssg->setAssignmentId($_POST['assigId']);
            $objAssg->setStudentId($_POST['studId']);
            $objAssg->setSubmissionToken($token);
            $objAssg->setSubmissionStatus(1);
            $objAssg->setIsFinished(1);

            $save = $objAssg->saveSubmission();

            array_push($arr, $save);
        }
    } else if ($sub['is_finish'] == 1) { //untuk update file
        $assign->setSubmissionStatus('nonaktif');
        $assign->setIsFinished(0);
        $assign->updateStatusAssignmentSubmission();
        for ($i = 0; $i < $_POST['count']; $i++) {
            $objAssg = new AssignmentSubmission;
            date_default_timezone_set("Asia/Bangkok");
            $dateupload = date("Y-m-d H:i:s");

            $objAssg->setSubmissionFileName("");
            $objAssg->setSubmissionUploadDate($dateupload);
            $objAssg->setAssignmentId($_POST['assigId']);
            $objAssg->setStudentId($_POST['studId']);
            $objAssg->setSubmissionToken($token);
            $objAssg->setSubmissionStatus(1);
            $objAssg->setIsFinished(1);


            $save = $objAssg->saveSubmission();

            array_push($arr, $save);
        }
    }
}

print_r(json_encode($arr));
