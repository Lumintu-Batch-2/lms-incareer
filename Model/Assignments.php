<?php
class Assignments
{
    private $assignmentId;
    private $assignmentName;
    private $assignmentStartDate;
    private $assignmentEndDate;
    private $assignmentDesc;
    private $subjectId;
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
}
