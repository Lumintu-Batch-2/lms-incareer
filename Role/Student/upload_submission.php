<?php

    $validTypeFile = [
        "image/png", // png
        "image/jpg", // jpg
        "image/jpeg", // jpeg
        "text/plain", // txt or html
        "application/pdf", // pdf
        "application/vnd.ms-powerpoint",
        "application/vnd.openxmlformats-officedocument.wordprocessingml.document", // docx
        "application/vnd.openxmlformats-officedocument.spreadsheetml.sheet", // xlsx
        "application/vnd.openxmlformats-officedocument.presentationml.presentation", // pptx
        "application/vnd.ms-excel", // xls
        "application/msword", // doc
        "application/zip", // zip
        "application/x-rar" // rar
    ];

    if (!in_array($_FILES['data']['type'], $validTypeFile)) {
        $msg = "Format file tidak didukung!";
        goto out;
    }

    $path = '../../Upload/Assignment/Submission/';
    $move = move_uploaded_file($_FILES['data']['tmp_name'], $path . $_FILES['data']['name']);

    if($move) {

        require_once "../../Model/AssignmentSubmission.php";
        $objAssig = new AssignmentSubmission;
        date_default_timezone_set("Asia/Jakarta");
        $dateupload = date("Y-m-d H:i:s");

        $is_ok = false;
        $msg = "";

        $filesize = $_FILES['data']['size'];    

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
        $data = [
            "is_ok" => $is_ok,
            "msg" => $msg,
        ];

        print_r(json_encode($data));
    }

?>