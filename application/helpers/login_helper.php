<?php
function cek_login(){
    $ci=& get_instance();
    if(!$ci->session->userdata('login')){
        $ci->session->set_flashdata('pesan_error',"Anda Harus Login Terlebih Dahulu!");
        redirect("login");
    }
}
