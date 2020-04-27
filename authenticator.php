<?php
interface Authenticator{
    public function hashPassword();
    public function isPasswordCorrect($conn);
    public function login($conn);
    public function logout();
    public function createFormErrorSessions();
}
?>