<?php

include_once 'DB.php';
include_once 'Session.php';
include_once 'helper/Helper.php';

class Login {

    private $dbObj;
    private $helpObj;

    public function __construct() {

        $this->dbObj = new DB();
        $this->helpObj = new Helper();
    }

    public function login($data) {
        $username = $data['username'];
        $password = $data['password'];
        $user_identity = $data['user_identity'];
        $message = '';
        if (empty($username) || empty($password) || empty($user_identity)) {
            return $message = "<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>&nbsp;Username or Password Must Not be Empty</p>";
        } else {
            $username = $this->helpObj->validAndEscape($username);
            $password = md5($this->helpObj->validAndEscape($password));


            if ($user_identity == 'admin') {
                $query = "select * from tbl_user where username ='$username' and password = '$password'";
                $status = $this->dbObj->select($query);
                if ($status) {
                    $data = $status->fetch_assoc();
                    // Session::init();
                    Session::set('login', true);
                    Session::set('username', $data['username']);
                    Session::set('userid', $data['userid']);
                    Session::set('email', $data['email']);
                    Session::set('name', $data['name']);
                    echo "<script>window.location='index.php'</script>"; //redirecting to home page(index.php)
                } else {
                    return $message = "<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>&nbsp;Username or Password Not Matched</p>";
                }
            }
            if ($user_identity == 'user') {
                $query = "select * from tbl_user where username ='$username' and password = '$password'";
                $status = $this->dbObj->select($query);
                if ($status) {
                    $data = $status->fetch_assoc();
                    // Session::init();
                    Session::set('login', true);
                    Session::set('username', $data['username']);
                    Session::set('userid', $data['userid']);
                    Session::set('name', $data['name']);
                    Session::set('email', $data['email']);
                    echo "<script>window.location='index.php'</script>"; //redirecting to home page(index.php)
                } else {
                    return $message = "<p class='alert alert-danger' id='message'><i class='fa fa-times'></i>&nbsp;Username or Password Not Matched</p>";
                }
            }
        }
    }

}
