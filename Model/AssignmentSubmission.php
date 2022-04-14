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
        date_default_timezone_set("Asia/Bangkok");
        $this->submissionUploadDate = $date;
    }
    public function getSubmissionUploadDate()
    {
        date_default_timezone_set("Asia/Bangkok");
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

    public function createAssignmentSubmission($file, $id)
    {
        date_default_timezone_set("Asia/Bangkok");
        $is_ok = false;
        $msg = "";
        require_once('assignments.php');
        $objassign = new Assignments;
        $assignment = $objassign->getAssignmentByAssignmentId($id);

        $objQuest = new AssignmentSubmission;

        $validExtention = ['pdf', 'doc', 'docx', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'ppt', 'pdf', 'rar', 'zip'];
        $fileExtention = explode(".", $file['filename']['name']);
        $fileExtention = strtolower(end($fileExtention));
        $filesize = $file['filename']['size'];
        date_default_timezone_set("Asia/Bangkok");
        $dateupload = date("Y-m-d H:i:s");
        if (!in_array($fileExtention, $validExtention)) {
            $msg = "Format file tidak didukung!";
            goto out;
        }

        if ($dateupload < $assignment['assignment_start_date']) {
            $msg = "Assignment Belum Dimulai";
            goto out;
        }
        if ($dateupload > $assignment['assignment_end_date']) {
            $msg = "Assignment sudah melebihi deadline";
            goto out;
        }

        if ($filesize > 2000000) {
            $msg = "Ukuran file tidak boleh lebih dari 2 Mb";
            var_dump($filesize);
            goto out;
        }

        $objQuest->setSubmissionFileName($file['filename']['name']);
        date_default_timezone_set("Asia/Bangkok");
        $date = date("Y-m-d H:i:s");
        $objQuest->setSubmissionUploadDate($date);

        // $path = "./Upload/Assignment/Submission";

        $path = "../../Upload/Assignment/Submission/";
        move_uploaded_file($file['filename']['tmp_name'], $path . $file['filename']['name']);

        // $save = $this->saveSubmission();
        $upload = $objQuest->uploadFile($id);

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
    public function uploadFile($id)

    {
        date_default_timezone_set("Asia/Bangkok");
        $stmt = $this->dbConn->prepare("INSERT INTO assignment_submissions VALUES (null, :filename, :upload_date, :asid)");
        $stmt->bindParam(":filename", $this->submissionFileName);
        $stmt->bindParam(":upload_date", $this->submissionUploadDate);
        $stmt->bindParam(":asid", $id);

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

    public function getAllAssignmentBySubject($id)
    {
        $stmnt = $this->dbConn->prepare(
            'select assignment_submissions.assignment_submission_id, assignment_submissions.submission_filename, assignment_submissions.submitted_date, users.username FROM assignment_submissions, users where assignment_submissions.assignment_id in (SELECT assignments.assignment_id FROM assignments,subjects WHERE assignments.subject_id= :id AND assignments.subject_id IN (SELECT subjects.subject_id FROM subjects, courses WHERE subjects.course_id IN (SELECT user_courses.course_id FROM user_courses WHERE user_courses.user_id in (SELECT users.user_id FROM users)))) GROUP BY assignment_submissions.assignment_submission_id'
        );
        $stmnt->bindParam(":id", $id);



        try {
            if ($stmnt->execute()) {
                $allAssignment = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $allAssignment;
    }

    public function getAllSubmissionByAssignmentId($id) {
        $stmnt = $this->dbConn->prepare(
            "SELECT * FROM `assignment_submissions` WHERE `assignment_submissions`.`assignment_id` = :id"
        );

        $stmnt->bindParam(":id", $id);

        try {
            if($stmnt->execute()) {
                $submissions = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $submissions;
    }
}
