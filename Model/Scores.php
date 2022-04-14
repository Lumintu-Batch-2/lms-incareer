<?php
class Scores
{
    private $scoreId;
    private $scoreValue;
    private $assignmentUploadId;
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
    public function setAssignmentUploadId($id)
    {
        $this->assignmentUploadId = $id;
    }
    public function getAssignmentUploadId()
    {
        return $this->assignmentUploadId;
    }
}
