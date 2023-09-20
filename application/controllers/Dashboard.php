<?php
class Dashboard extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper(['login']);
        cek_login();
    }
    function index() {
        $this->load->view("dashboard/vDashboard");
    }
}
