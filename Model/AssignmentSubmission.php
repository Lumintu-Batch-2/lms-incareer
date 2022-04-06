<?php
class AssignmentSubmission
{
    private $assignmentSubmissionId;
    private $submissionFileName;
    private $submissionUploadDate;
    private $assignmentId;
    private $dbConn;

    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }
    public function setAssignmentSubmissionId($id)
    {
        $this->assignmentSubmissionId = $id;
    }
    public function getAssignmentSubmissionId()
    {
        return $this->assignmentSubmissionId;
    }
    public function setSubmissionFileName($filename)
    {
        $this->submissionFileName = $filename;
    }
    public function getSubmissionFileName()
    {
        return $this->submissionFileName;
    }
    public function setSubmissionUploadDate($date)
    {
        $this->submissionUploadDate = $date;
    }
    public function getSubmissionUploadDate()
    {
        return $this->submissionUploadDate;
    }
    public function setAssignmentId($id)
    {
        $this->assignmentId = $id;
    }
    public function getAssignmentId()
    {
        return $this->assignmentId;
    }
    // public function saveSubmission() {
    //     $stmt = $this->dbConn->prepare("INSERT INTO assignment_submissions VALUES(null, :name, :start_date, :end_date, :desc, null)");

    //     $stmt->bindParam(":name", $this->assignmentName);
    //     $stmt->bindParam(":start_date", $this->assignmentStartDate);
    //     $stmt->bindParam(":end_date", $this->assignmentEndDate);
    //     $stmt->bindParam(":desc", $this->assignmentDesc);

    //     try {
    //         if($stmt->execute()) {
    //             return true;
    //         } else {
    //             return false;
    //         }

    //     } catch (Exception $e) {
    //         return $e->getMessage();
    //     }
    // }

    public function createAssignmentSubmission($file)
    {
        $is_ok = false;
        $msg = "";


        $objQuest = new AssignmentSubmission;

        $validExtention = ['pdf', 'doc', 'docx', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'ppt', 'pdf', 'rar', 'zip'];
        $fileExtention = explode(".", $file['filename']['name']);
        $fileExtention = strtolower(end($fileExtention));
        $filesize = $file['filename']['size'];

        if (!in_array($fileExtention, $validExtention)) {
            $msg = "Format file tidak didukung!";
            goto out;
        }

        if ($filesize > 2000000) {
            $msg = "Ukuran file tidak boleh lebih dari 2 Mb";
            var_dump($filesize);
            goto out;
        }

        $objQuest->setSubmissionFileName($file['filename']['name']);
        date_default_timezone_set('Asia/Jakarta');
        $objQuest->setSubmissionUploadDate(date("Y-m-d H:i:s"));

        $path = "./Upload/Assignment/Submission/Submission";
        move_uploaded_file($file['filename']['tmp_name'], $path . $file['filename']['name']);

        // $save = $this->saveSubmission();
        $upload = $objQuest->uploadFile();

        if ($upload) {
            $msg = "Berhasil membuat tugas!";
            $is_ok = true;
            goto out;
        } else {
            $msg = "Gagal membuat tugas!";
            goto out;
        }

        out: {
            return [
                "is_ok" => $is_ok,
                "msg" => $msg,
            ];
        }
    }
    public function uploadFile()
    {
        $stmt = $this->dbConn->prepare("INSERT INTO assignment_submissions VALUES (null, :filename, :upload_date, null)");
        $stmt->bindParam(":filename", $this->submissionFileName);
        $stmt->bindParam(":upload_date", $this->submissionUploadDate);

        try {
            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
    public function getAllAssignment()
    {
        $stmnt = $this->dbConn->prepare(
            'SELECT * FROM assignment_submissions'
        );


        try {
            if ($stmnt->execute()) {
                $allAssignment = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $allAssignment;
    }
}
