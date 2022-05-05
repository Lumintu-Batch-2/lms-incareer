<?php
class Scores
{
    private $scoreId;
    private $scoreValue;
    private $assignmentId;
    private $componentId;
    private $mentorId;
    private $studentId;
    private $dbConn;

    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }

    public function setScoreId($id)
    {
        $this->scoreId = $id;
    }
    public function getScoreId()
    {
        return $this->scoreId;
    }

    public function setScoreValue($value)
    {
        $this->scoreValue = $value;
    }
    public function getScoreValue()
    {
        return $this->scoreValue;
    }
    public function setAssignmentId($id)
    {
        $this->assignmentId = $id;
    }
    public function getAssignmentId()
    {
        return $this->assignmentId;
    }
    public function setComponentId($id)
    {
        $this->componentId = $id;
    }
    public function getComponentId()
    {
        return $this->componentId;
    }
    public function setMentorId($id)
    {
        $this->mentorId = $id;
    }
    public function getMentorId()
    {
        return $this->mentorId;
    }
    public function setStudentId($id)
    {
        $this->studentId = $id;
    }

    public function getStudentId()
    {
        return $this->studentId;
    }
    public function saveScore()
    {
        $stmt = $this->dbConn->prepare('INSERT INTO `scores` (`score_id`, `score_value`, `submission_id`, `mentor_id`, `component_id`) VALUES (NULL, :sv, :uid, :mid, :cid)');
        $stmt->bindParam(':sv', $this->scoreValue);
        $stmt->bindParam(':mid', $this->mentorId);
        $stmt->bindParam(':cid', $this->componentId);
        $stmt->bindParam(':uid', $this->submissionId);

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
    public function updateScore()
    {
        $stmt = $this->dbConn->prepare('UPDATE `scores` SET `score_value`= :sv WHERE score_id = :score_id');
        $stmt->bindParam(':sv', $this->scoreValue);
        $stmt->bindParam(':score_id', $this->scoreId);
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

    public function insertScore()
    {
        try {

            $stmt = $this->dbConn->prepare(
                "INSERT INTO `scores`(`score_id`, `score_value`, `assignment_id`, `mentor_id`, `student_id`) VALUES (NULL, :score_val, :assign_id, :mid, :sid)"
            );

            $stmt->bindParam(":score_val", $this->scoreValue);
            $stmt->bindParam(":assign_id", $this->assignmentId);
            $stmt->bindParam(":mid", $this->mentorId);
            $stmt->bindParam(":sid", $this->studentId);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    public function getScoreByStudentIdAndAssignmentId()
    {
        try {
            $stmt = $this->dbConn->prepare(
                "SELECT score_id, score_value FROM scores WHERE student_id = :std_id AND assignment_id = :assg_id"
            );

            $stmt->bindParam(":std_id", $this->studentId);
            $stmt->bindParam(":assg_id", $this->assignmentId);

            if ($stmt->execute()) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
            }
        } catch (Exception $e) {
            return $e->getMessage();
        }

        return $data;
    }
}
