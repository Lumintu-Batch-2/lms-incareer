<?php
class AssignmentSubmission
{
    private $assignmentSubmissionId;
    private $submissionFileName;
    private $submissionUploadDate;
    private $assignmentId;
    private $submissionToken;
    private $dbConn;
    private $studentId;

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
    public function setSubmissionToken($token)
    {
        $this->submissionToken = $token;
    }

    public function getSubmissionToken()
    {
        return $this->submissionToken;
    }

    public function setStudentId($id)
    {
        $this->studentId = $id;
    }

    public function getStudentId()
    {
        return $this->studentId;
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

    public function getAllAssignmentBySubject($assignment_id, $subject_id)
    {
        $stmnt = $this->dbConn->prepare(
            'select assignment_submissions.assignment_submission_id, assignment_submissions.submission_filename, assignment_submissions.submitted_date, users.username FROM assignment_submissions, users where assignment_submissions.assignment_id= :assignment_id AND assignment_submissions.assignment_id in (SELECT assignments.assignment_id FROM assignments,subjects WHERE assignments.subject_id= :subject_id AND assignments.subject_id IN (SELECT subjects.subject_id FROM subjects, courses WHERE subjects.course_id IN (SELECT user_courses.course_id FROM user_courses WHERE user_courses.user_id in (SELECT users.user_id FROM users)))) GROUP BY assignment_submissions.assignment_submission_id'
        );
        $stmnt->bindParam(":assignment_id", $assignment_id);
        $stmnt->bindParam(":subject_id", $subject_id);



        try {
            if ($stmnt->execute()) {
                $allAssignment = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
        return $allAssignment;
    }

    public function getAllSubmissionByAssignmentId($id)
    {
        $stmnt = $this->dbConn->prepare(
            "SELECT * FROM `assignment_submissions` WHERE `assignment_submissions`.`assignment_id` = :id"
        );

        $stmnt->bindParam(":id", $id);

        try {
            if ($stmnt->execute()) {
                $submissions = $stmnt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $submissions;
    }

    public function saveSubmission()
    {
        $stmt = $this->dbConn->prepare("INSERT INTO assignment_submissions VALUES(null, :name, :date, :token, :aid, :sid)");

        $stmt->bindParam(":name", $this->submissionFileName);
        $stmt->bindParam(":date", $this->submissionUploadDate);
        $stmt->bindParam(":aid", $this->assignmentId);
        $stmt->bindParam(":token", $this->submissionToken);
        $stmt->bindParam(":sid", $this->studentId);

        $id = "";

        try {
            if ($stmt->execute()) {
                $id = $this->dbConn->lastInsertId();
                $is_ok = true;
                goto out;
            } else {
                $is_ok = false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        out: {
            return [
                "submission_id" => $id,
                "is_ok" => $is_ok
            ];
        }
    }

    public function updateSubmission()
    {
        $stmt = $this->dbConn->prepare(
            "UPDATE assignment_submissions SET submission_filename = :name, submitted_date = :date WHERE assignment_submission_id = :id"
        );

        $stmt->bindParam(":name", $this->submissionFileName);
        $stmt->bindParam(":date", $this->submissionUploadDate);
        $stmt->bindParam(":id", $this->assignmentSubmissionId);

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
}
