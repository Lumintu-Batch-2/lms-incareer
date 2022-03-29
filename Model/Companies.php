<?php

class Companies {
    private $companyId;
    private $companyFullName;
    private $companyEmail;
    private $companyPassword;
    private $companyContact;
    private $companyImg;

    public function getCompanyId() {
        return $this->companyId;
    }

    public function setCompanyId($id) {
        $this->companyId = $id;
    }

    public function getCompanyFullName() {
        return $this->companyFullName;
    }

    public function setCompanyFullName($name) {
        $this->companyFullName = $name;
    }

    public function getCompanyEmail() {
        return $this->companyEmail;
    }

    public function setCompanyEmail($email) {
        $this->companyEmail = $email;
    }

    public function getCompanyPassword() {
        return $this->companyPassword;
    }

    public function setCompanyPassword($password) {
        $this->companyPassword = $password;
    }

    public function getCompanyContact() {
        return $this->companyContact;
    }

    public function setCompanyContact($contact) {
        $this->companyContact = $contact;
    }

    public function getCompanyImg() {
        return $this->companyImg;
    }

    public function setCompanyImg($img) {
        $this->companyImg = $img;
    }
}