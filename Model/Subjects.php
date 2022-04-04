<?php

class Subjects
{
    private $SubjectId;
    private $SubjectName;
    private $SubjectDesc;
    private $courseId;
    private $dbConn;

    public function __construct()
    {
        require_once("DbConnect.php");
        $db = new DbConnect;
        $this->dbConn = $db->connect();
    }

    public function setSubjectId($id)
    {
        $this->SubjectId = $id;
    }

    public function getSubjectId()
    {
        return $this->SubjectId;
    }

    public function setSubjectName($name)
    {
        $this->SubjectName = $name;
    }

    public function getSubjectName()
    {
        return $this->SubjectName;
    }
    public function setSubjectDesc($desc)
    {
        $this->SubjectDesc = $desc;
    }

    public function getSubjectDesc()
    {
        return $this->SubjectDesc;
    }
    public function getCourseId()
    {
        return $this->courseId;
    }

    public function setCourseId($id)
    {
        $this->courseId = $id;
    }
}
