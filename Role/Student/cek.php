<?php
require_once "../../Model/AssignmentSubmission.php";

$assign = new AssignmentSubmission;
$assign->setAssignmentId(24);
$assign->setStudentId(3);
$sub = $assign->getSubmissionByAssignIdAndStudentId();
var_dump($sub);
