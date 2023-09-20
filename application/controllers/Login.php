<?php
class Login extends ci_controller
{
    function __construct()
    {
        parent::__construct();
    }
    function index()
    {
        $this->load->view("login/vLogin");
    }

    function do_login()
    {
        $username = $this->input->post("username");
        $password = md5($this->input->post("password"));
        // $query = $this->db->query("select * from user where username='$username' and password='$password' ");
        $query = $this->db->query("select * from user where username=? and password=? ",[$username,$password]);
        if ($query->num_rows() == 1) {
            $row = $query->row();
            $this->session->set_userdata(["user_id" => $row->user_id, "login" => true, "username" => $username, "nama" => $row->nama, "level" => $row->user_level_id]);
            $this->db->update(
                "user",
                [
                    'user_last_login' => date('Y-m-d H:i:s'),
                    'user_last_ip' => $this->input->ip_address(),
                ],
                ['username' => $username]
            );
            redirect("dashboard");
        } else {
            $this->session->set_flashdata("pesan_error", "Gagal Login Username/Password Salah!");
            redirect("login");
        }
    }
}
