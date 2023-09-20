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
        $this->form_validation->set_rules('username', "username", "required|valid_email");
        $this->form_validation->set_rules('password', "password", "required|min_length[3]");
        if ($this->form_validation->run()) {
            $username = $this->input->post("username");
            $password = md5($this->input->post("password"));
            //  $query = $this->db->query("select * from user where username='$username' and password='$password' ");
            $query = $this->db->query("select * from user where username=? and password=? ", [$username, $password]);
            $log_data = [
                "username" => $username,
                "login_browser" => $_SERVER['HTTP_USER_AGENT'],
                "login_ip" => $_SERVER['REMOTE_ADDR'],
            ];
            if ($query->num_rows() == 1) {
                $row = $query->row();
                $this->session->set_userdata([
                    "user_id" => $row->user_id, "login" => true, "username" => $username, "nama" => $row->nama,
                    "level" => $row->user_level_id
                ]);
                $this->db->update("user", [
                    'user_last_login' => date('Y-m-d H:i:s'),
                    'user_last_ip' => $this->input->ip_address(),
                ], ['username' => $username]);
                $log_data["status"] = 1;
                $this->db->insert("login_log", $log_data);

                redirect("dashboard");
            } else {
                $this->session->set_flashdata("pesan_error", "Gagal Login Username/Password Salah!");
                $log_data["status"] = 0;
                $this->db->insert("login_log", $log_data);
                redirect("login");
            }
        } else {
            $this->load->view('login/vLogin');
        }
    }
}
