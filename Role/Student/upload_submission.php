<?php

print_r($_FILES);
// print_r($_POST['submission_id']);
$path = '../../Upload/Assignment/Submission/';
$move = move_uploaded_file($_FILES['data']['tmp_name'], $path . $_FILES['data']['name']);

if($move) {

    require_once "../../Model/AssignmentSubmission.php";
    $objAssig = new AssignmentSubmission;
    date_default_timezone_set("Asia/Jakarta");
    $dateupload = date("Y-m-d H:i:s");

    $is_ok = false;
    $msg = "";

    $validExtention = ['pdf', 'doc', 'docx', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'ppt', 'pdf', 'rar', 'zip'];
    $fileExtention = explode(".", $_FILES['data']['name']);
    $fileExtention = strtolower(end($fileExtention));
    $filesize = $_FILES['data']['size'];
    if (!in_array($fileExtention, $validExtention)) {
        $msg = "Format file tidak didukung!";
        goto out;
    }

    // if ($dateupload < $assignment['assignment_start_date']) {
    //     $msg = "Assignment Belum Dimulai";
    //     goto out;
    // }
    // if ($dateupload > $assignment['assignment_end_date']) {
    //     $msg = "Assignment sudah melebihi deadline";
    //     goto out;
    // }

    if ($filesize > 2000000) {
        $msg = "Ukuran file tidak boleh lebih dari 2 Mb";
        var_dump($filesize);
        goto out;
    }

    $objAssig->setSubmissionFileName($_FILES['data']['name']);
    $objAssig->setSubmissionUploadDate($dateupload);
    $objAssig->setAssignmentSubmissionId((int) $_POST['submission_id']);

    $update = $objAssig->updateSubmission();

    if($update) {
        $msg = "Berhasil mengirim tugas!";
        $is_ok = true;
        goto out;
    } else {
        $msg = "Gagal mengirim tugas!";
        goto out;
    }

    
}

out: {
    return [
        "is_ok" => $is_ok,
        "msg" => $msg,
    ];
}

?>