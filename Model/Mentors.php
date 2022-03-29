<?php

class Mentors {
    private $mentorId;
    private $mentorFullName;
    private $mentorEmail;
    private $mentorPassword;
    private $mentorCity;
    private $mentorGender;
    private $mentorDateOfBirth;
    private $mentorLastEducation;
    private $mentorImg;

    public function getMentorId() {
        return $this->mentorId;
    }

    public function setMentorId($id) {
        $this->mentorId = $id;
    }

    public function getMentorFullName() {
        return $this->mentorFullName;
    }

    public function setMentorFullName($name) {
        $this->mentorFullName = $name;
    }

    public function getMentorEmail() {
        return $this->mentorEmail;
    }

    public function setMentorEmail($email) {
        $this->mentorEmail = $email;
    }

    public function getMentorPassword() {
        return $this->mentorPassword;
    }

    public function setMentorPassword($password) {
        $this->mentorPassword = $password;
    }

    public function getMentorCity() {
        return $this->mentorCity;
    }

    public function setMentorCity($city) {
        $this->mentorCity = $city;
    }

    public function getMentorGender() {
        return $this->mentorGender;
    }

    public function setMentorGender($gender) {
        $this->mentorGender = $gender;
    }

    public function getMentorDateOfBirth() {
        return $this->mentorDateOfBirth;
    }

    public function setMentorDateOfBirth($date) {
        $this->mentorDateOfBirth = $date;
    }

    public function getMentorLastEducation() {
        return $this->mentorLastEducation;
    }

    public function setMentorLastEducation($education) {
        $this->mentorLastEducation = $education;
    }

    public function getMentorImg() {
        return $this->mentorImg;
    }

    public function setMentorImg($img) {
        $this->mentorImg = $img;
    }
}