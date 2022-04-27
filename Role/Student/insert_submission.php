<?php

$arr = array();
$token = md5(uniqid());

require_once "../../Model/AssignmentSubmission.php";

$assign = new AssignmentSubmission;
$assign->setAssignmentId($_POST['assigId']);
$assign->setStudentId($_POST['studId']);
$sub = $assign->getSubmissionByAssignIdAndStudentId();

if (!empty($sub)) {
    
    if ($sub[0]['is_finish'] == 0) {//untuk pertama kali submit file
        // $assign->setSubmissionFileName('N/A');
        // $del = $assign->deleteNAassignmentSubmission();
        
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

        

    } else if ($sub['is_finish'] == 1) {//untuk update file 
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
        
            $save = $objAssg->saveSubmission();
        
            array_push($arr, $save);
        }
    } 
}

print_r(json_encode($arr));
