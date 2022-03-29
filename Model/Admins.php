<?php
class Admins
{
    private $adminId;
    private $adminFullName;
    private $adminEmail;
    private $adminPassword;
    private $dbConn;
    //koneksi databse
    public function __construct()
    {
        require_once('DBconn.php');
        $db = new DBConn();
        $this->dbConn = $db->connect();
    }
    function setAdminId($id)
    {
        $this->adminId = $id;
    }
    function getAdminId()
    {
        return $this->adminId;
    }
    function setAdminFullName($full_name)
    {
        $this->adminFullName = $full_name;
    }
    function getAdminFullName()
    {
        return $this->adminFullName;
    }
    function setAdminEmail($email)
    {
        $this->adminEmail = $email;
    }
    function getAdminEmail()
    {
        return $this->adminEmail;
    }
    function setAdminPassword($password)
    {
        $this->adminPassword = $password;
    }
    function getAdminPassword()
    {
        return $this->adminPassword;
    }
}
