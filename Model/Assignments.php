<?php
class Assignments
{
    private $assignmentId;
    private $assignmentName;
    private $assignmentStartDate;
    private $assignmentEndDate;
    private $assignmentDesc;
    private $subjectId;
    private $assignmentType;
    private $mentorId;
    private $dbConn;

    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }
    public function setAssignmentId($id)
    {
        $this->assignmentId = $id;
    }
    public function getAssignmentId()
    {
        return $this->assignmentId;
    }
    public function setAssignmentName($name)
    {
        $this->assignmentName = $name;
    }
    public function getAssignmentName()
    {
        return $this->assignmentName;
    }
    public function setAssignmentStartDate($date)
    {
        $this->assignmentStartDate = $date;
    }
    public function getAssignmentStartDate()
    {
        return $this->assignmentStartDate;
    }
    public function setAssignmentEndDate($date)
    {
        $this->assignmentEndDate = $date;
    }
    public function getAssignmentEndDate()
    {
        return $this->assignmentEndDate;
    }
    public function setAssignmentDesc($desc)
    {
        $this->assignmentDesc = $desc;
    }
    public function getAssignmentDesc()
    {
        return $this->assignmentDesc;
    }
    public function setSubjectId($id)
    {
        $this->subjectId = $id;
    }
    public function getSubjectId()
    {
        return $this->subjectId;
    }
    public function setAssignmentType($type)
    {
        $this->assignmentType = $type;
    }
    public function getAssignmentType()
    {
        return $this->assignmentType;
    }
    public function setMentorId($id)
    {
        $this->mentorId = $id;
    }
    public function getMentorId()
    {
        return $this->mentorId;
    }

    public function saveAssignment()
    {
        $stmt = $this->dbConn->prepare("INSERT INTO assignments VALUES(null, :name, :start_date, :end_date, :desc, :assign_type, :sid,:mid)");

        $stmt->bindParam(":name", $this->assignmentName);
        $stmt->bindParam(":start_date", $this->assignmentStartDate);
        $stmt->bindParam(":end_date", $this->assignmentEndDate);
        $stmt->bindParam(":desc", $this->assignmentDesc);
        $stmt->bindParam(":assign_type", $this->assignmentType);
        $stmt->bindParam(":sid", $this->subjectId);
        $stmt->bindParam(":mid", $this->mentorId);

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
                "assignment_id" => $id,
                "is_ok" => $is_ok
            ];
        }
    }

    public function createAssignment($data, $file, $sid, $mid)
    {
        $is_ok = false;
        $msg = "";

        if (empty($data['title'])) {
            $msg = "Judul tidak boleh kosong";
            goto out;
        }

        if (!is_string($data['title'])) {
            $msg = "Judul tidak valid!";
            goto out;
        }

        if (!is_string($data['desc'])) {
            $msg = "Deskripsi tidak valid!";
            goto out;
        }

        if (empty($data['start-date'])) {
            $msg = "Tanggal mulai tidak boleh kosong!";
            goto out;
        }

        if (empty($data['end-date'])) {
            $msg = "Tanggal selesai tidak boleh kosong!";
            goto out;
        }

        if (empty($data['assign_type'])) {
            $msg = "Tipe assignment tidak boleh kosong!";
            goto out;
        }

        $this->setAssignmentName($data['title']);
        $this->setAssignmentStartDate($data['start-date']);
        $this->setAssignmentEndDate($data['end-date']);
        $this->setAssignmentDesc($data['desc']);
        $this->setAssignmentType($data['assign_type']);
        $this->setSubjectId($sid);
        $this->setMentorId($mid);

        require_once("AssignmentQuestion.php");
        $objQuest = new AssignmentQuestion;

        $validExtention = ['pdf', 'doc', 'docx', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'ppt'];
        $fileExtention = explode(".", $file['filename']['name']);
        $fileExtention = strtolower(end($fileExtention));

        if (!in_array($fileExtention, $validExtention)) {
            $msg = "Format file tidak didukung!";
            goto out;
        }

        $objQuest->setQuestionFileName($file['filename']['name']);
        date_default_timezone_set('Asia/Jakarta');
        $objQuest->setQuestionUploadDate(date("Y-m-d H:i:s"));

        // $path = "../../Upload/Assignment/Questions/";
        $path = dirname(__DIR__) . '/Upload/Assignment/Questions/';


        move_uploaded_file($file['filename']['tmp_name'], $path . $file['filename']['name']);

        $save = $this->saveAssignment();
        $upload = $objQuest->uploadFile($save['assignment_id']);

        if ($save['is_ok'] && $upload) {
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

    public function getAllAssigment()
    {
        $stmt = $this->dbConn->prepare("SELECT * FROM assignments");

        try {
            if ($stmt->execute()) {
                $assignments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $assignments;
    }

    public function updateAssignment()
    {
        $stmt = $this->dbConn->prepare(
            "UPDATE assignments SET assignment_name = :name, 
                                    assignment_start_date = :start_date,
                                    assignment_end_date = :end_date,
                                    assignment_desc = :desc,
                                    assignment_type = :assign_type
                                    WHERE assignment_id = :id"
        );

        $stmt->bindParam(":name", $this->assignmentName);
        $stmt->bindParam(":start_date", $this->assignmentStartDate);
        $stmt->bindParam(":end_date", $this->assignmentEndDate);
        $stmt->bindParam(":desc", $this->assignmentDesc);
        $stmt->bindParam(":id", $this->assignmentId);
        $stmt->bindParam(':assign_type', $this->assignmentType);

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

    public function editAssignment($data, $file)
    {
        $is_ok = false;
        $msg = "";

        if (!is_string($data['title'])) {
            $msg = "Judul tidak valid!";
            goto out;
        }

        if (!is_string($data['desc'])) {
            $msg = "Deskripsi tidak valid!";
            goto out;
        }

        if (empty($data['start-date'])) {
            $msg = "Tanggal mulai tidak boleh kosong!";
            goto out;
        }

        if (empty($data['end-date'])) {
            $msg = "Tanggal selesai tidak boleh kosong!";
            goto out;
        }

        $this->setAssignmentName($data['title']);
        $this->setAssignmentStartDate($data['start-date']);
        $this->setAssignmentEndDate($data['end-date']);
        $this->setAssignmentDesc($data['desc']);
        $this->setAssignmentId($data['id']);
        $this->setAssignmentType($data['assign_type']);

        $validExtention = ['pdf', 'doc', 'docx', 'xlsx', 'txt', 'png', 'jpg', 'jpeg', 'ppt'];
        $fileExtention = explode(".", $file['filename']['name']);
        $fileExtention = strtolower(end($fileExtention));

        if ($file['filename']['size'] > 0) {
            if (!in_array($fileExtention, $validExtention)) {
                $msg = "Format file tidak didukung!";
                goto out;
            }

            require_once("AssignmentQuestion.php");
            $objQuest = new AssignmentQuestion;

            $objQuest->setQuestionFileName($file['filename']['name']);
            date_default_timezone_set('Asia/Jakarta');
            $objQuest->setQuestionUploadDate(date("Y-m-d H:i:s"));

            $path = dirname(__DIR__) . '/Upload/Assignment/Questions/';
            move_uploaded_file($file['filename']['tmp_name'], $path . $file['filename']['name']);

            $objQuest->uploadFile($data['id']);
        }


        $edit = $this->updateAssignment();

        if ($edit) {
            $msg = "Berhasil mengubah tugas!";
            $is_ok = true;
            goto out;
        } else {
            $msg = "Gagal mengubah tugas!";
            goto out;
        }

        out: {
            return [
                "is_ok" => $is_ok,
                "msg" => $msg,
            ];
        }
    }

    public function deleteAssignment()
    {
        $stmt = $this->dbConn->prepare("DELETE FROM assignments WHERE assignment_id = :id");
        $stmt->bindParam(":id", $this->assignmentId);

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

    public function getAssignmentById($id)
    {
        $stmt = $this->dbConn->prepare("SELECT * FROM assignments WHERE assignment_id = :id");
        $stmt->bindParam(":id", $id);

        try {
            if ($stmt->execute()) {
                $assigmentData = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $assigmentData;
    }

    public function getAssignmentBySubjectId($id)
    {
        $stmt = $this->dbConn->prepare(
            "SELECT * FROM assignments WHERE subject_id = :sid"
        );

        $stmt->bindParam(":sid", $id);

        try {
            if ($stmt->execute()) {
                $assigments = $stmt->fetchAll(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $assigments;
    }
    public function getAssignmentByAssignmentId($id)
    {
        $stmt = $this->dbConn->prepare(
            "SELECT * FROM assignments WHERE assignment_id = :sid"
        );

        $stmt->bindParam(":sid", $id);

        try {
            if ($stmt->execute()) {
                $assigments = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $assigments;
    }
}
