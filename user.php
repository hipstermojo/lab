<?php
    include "Crud.php";
    include "authenticator.php";
    class User implements Crud,Authenticator{
        private $user_id;
        private $first_name;
        private $last_name;
        private $city_name;

        private $username;
        private $password;

        private $created_at;
        private $utc_offset;

        function __construct($first_name,$last_name,$city_name,$username,$password,$created_at,$utc_offset){
            $this->first_name = $first_name;
            $this->last_name = $last_name;
            $this->city_name = $city_name;
            $this->username = $username;
            $this->password = $password;
            $this->created_at = date("Y-m-d H:i:s", intdiv(intval($created_at) , 1000));
            $this->utc_offset = intval($utc_offset);
        }

        public static function create()
        {
            $instance = new self("","","","","",time(),0);
            return $instance;
        }

        public function setUsername($username)
        {
            $this->username = $username;
        }

        public function getUsername()
        {
            return $this->username;
        }

        public function setPassword($password)
        {
            $this->password = $password;
        }

        public function getPassword()
        {
            return $this->password;
        }

        public function setUserId($user_id)
        {
            $this->user_id = $user_id;
        }

        public function getCreatedAt()
        {
            return $this->created_at;
        }

        public function setCreatedAt($created_at)
        {
            $this->created_at = $created_at;
        }

        public function getUTCOffset()
        {
            return $this->utc_offset;
        }

        public function setUTCOffset($offset)
        {
            $this->utc_offset = $offset;
        }

        public function save($conn)
        {
            $fn = $this->first_name;
            $ln = $this->last_name;
            $city = $this->city_name;
            $uname = $this->username;
            $this->hashPassword();
            $pass = $this->password;
            $created_at = $this->created_at;
            $offset = $this->utc_offset;
            $res = $conn->query(
                "INSERT INTO user(first_name,last_name,user_city,username,password,created_at,offset) "
                . "VALUES('$fn','$ln','$city','$uname','$pass','$created_at',$offset)"
            );
            if ($res=== FALSE) {
                die("Error: " . $conn->error);
            }
            return $res;
        }

        public function hashPassword()
        {
            $this->password = password_hash($this->password,PASSWORD_DEFAULT);
        }

        public function isPasswordCorrect($conn)
        {
            $found = false;
            $res = $conn->query("SELECT * FROM user");
            if ($res === FALSE) {
                die("Error: ".$conn->error);
            } else {
                while ($row = $res->fetch_assoc()) {
                    if (password_verify($this->getPassword(),$row['password']) && $this->getUsername() == $row['username']) {
                        $this->setUserId($row['id']);
                        $found = true;
                    }
                }
                
                return $found;
            }
        }

        public function login($conn)
        {
            if ($this->isPasswordCorrect($conn)) {
                header("Location:private_page.php");
            }
        }

        public function createUserSession(){
            session_start();
            $_SESSION['username'] = $this->getUsername();
            $_SESSION['user_id'] = $this->user_id;
        }

        public function logout()
        {
            session_start();
            unset($_SESSION['username']);
            unset($_SESSION['user_id']);
            session_destroy();
            header("Location:lab1.php");
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

        public function isUserExist($conn)
        {
            $res = $conn->query("SELECT * FROM user WHERE username = '$this->username' LIMIT 1");
            return $res->num_rows > 0;
        }
    }
?>