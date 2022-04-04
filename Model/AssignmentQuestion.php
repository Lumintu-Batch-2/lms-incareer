<?php
class AssignmentQuestion
{
    private $assignmentQuestionId;
    private $questionFileName;
    private $questionUploadDate;
    private $assignmentId;
    private $dbConn;
    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }
    public function setAssignmentQuestionId($id)
    {
        $this->assignmentQuestionId = $id;
    }
    public function getAssignmentQuestionId()
    {
        return $this->assignmentQuestionId;
    }
    public function setQuestionFileName($Name)
    {
        $this->questionFileName = $Name;
    }
    public function getQuestionFileName()
    {
        return $this->questionFileName;
    }
    public function setQuestionUploadDate($date)
    {
        $this->questionUploadDate = $date;
    }
    public function getQuestionUploadDate()
    {
        return $this->questionUploadDate;
    }
    public function setAssignmentId($id)
    {
        $this->assignmentId = $id;
    }
    public function getAssignmentId()
    {
        return $this->assignmentId;
    }
}
