<?php
class Login extends ci_controller{
    function __construct(){
        parent::__construct();
    }
    function index(){
        $this->load->view("login/vLogin");
    }

}
