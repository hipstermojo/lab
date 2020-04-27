<?php
    include "Crud.php";
    class User implements Crud{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;

        function __construct($first_name,$last_name,$city_name){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
        }

        public function setUserId($user_id)
        {
            $this->user_id = $user_id;
        }

        public function save($conn)
        {
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $res = $conn->query("INSERT INTO user(first_name,last_name,user_city) VALUES('$fn','$ln','$city')");
            if ($res=== FALSE) {
                die("Error: " . $conn->error);
            }
            return $res;
        }

        public function readAll($conn)
        {
            $users = array();
            $res = $conn->query("SELECT * FROM user");
            if ($res === FALSE) {
                    die("Error: " . $conn->error);
            }else{
                while($row = $res->fetch_assoc()){
                    array_push($users,array($row['first_name'],$row['last_name'],$row['user_city']));
                }
            }
            return $users;
        }

        public function readUnique()
        {
            return null;
        }

        public function search()
        {
            return null;
        }

        public function update()
        {
            return null;
        }

        public function removeOne()
        {
            return null;
        }

        public function removeAll()
        {
            return null;
        }
        public function valiteForm()
        {
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            if ($fn == "" || $ln == "" || $city == "") {
                return false;
            }
            return true;
        }
        public function createFormErrorSessions()
        {
            session_start();
            $_SESSION['form_errors'] = "All fields are required";
        }
    }
?>