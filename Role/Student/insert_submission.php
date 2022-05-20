<?php

$arr = array();
$token = md5(uniqid());

require_once "../../Model/AssignmentSubmission.php";
require_once "../../Model/Assignments.php";

$assignment = new Assignments;
$deadline = $assignment->getAssignmentById($_POST['assigId']);


$assign = new AssignmentSubmission;
$assign->setAssignmentId($_POST['assigId']);
$assign->setStudentId($_POST['studId']);
$now = $assign->getCurrentDate();
$sub = $assign->getSubmissionByAssignIdAndStudentId();


if (!empty($sub) and (strtotime($now['now()']) < strtotime($deadline['assignment_end_date']))) {
    if ($sub[0]['is_finish'] == 0) { //untuk pertama kali submit file
        $assign->setSubmissionFileName('N/A');
        $del = $assign->deleteNAassignmentSubmission();

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
            $objAssg->setIsFinished(0);

            $save = $objAssg->saveSubmission();

            array_push($arr, $save);
        }
    } else if ($sub[0]['is_finish'] == 1 and (strtotime($now['now()']) < strtotime($deadline['assignment_end_date']))) { //untuk update file

        date_default_timezone_set('Asia/Jakarta');
        $now =  date("Y-m-d h:i:s");
        require_once "../../Model/AssignmentSubmission.php";
        $objsubmit = new AssignmentSubmission;
        $objsubmit->setStudentId($_POST['studId']);
        $objsubmit->setAssignmentId($_POST['assigId']);
        $csub = $objsubmit->getSubmissionByAssignIdAndStudentIdGroupBy();
        if (count($csub) < 3) {
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
                $objAssg->setIsFinished(0);


                $save = $objAssg->saveSubmission();

                array_push($arr, $save);
            }
        }
    }
} else if (empty($sub) and (strtotime($now['now()']) < strtotime($deadline['assignment_end_date']))) {
    for ($i = 0; $i < $_POST['count']; $i++) {
        print_r('else');
        $objAssg = new AssignmentSubmission;
        date_default_timezone_set("Asia/Bangkok");
        $dateupload = date("Y-m-d H:i:s");

        $objAssg->setSubmissionFileName("");
        $objAssg->setSubmissionUploadDate($dateupload);
        $objAssg->setAssignmentId($_POST['assigId']);
        $objAssg->setStudentId($_POST['studId']);
        $objAssg->setSubmissionToken($token);
        $objAssg->setSubmissionStatus(1);
        $objAssg->setIsFinished(0);

        $save = $objAssg->saveSubmission();

        array_push($arr, $save);
    }
} else if ((strtotime($now['now()']) > strtotime($deadline['assignment_end_date']))) {
}

print_r(json_encode($arr));
