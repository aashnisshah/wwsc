<?php

class Images extends CI_Controller {

    function __construct()
    {
        parent::__construct();
        $this->load->helper(array('form', 'url'));
    }

    function index()
    {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['id'] = $session_data['id'];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar',$data);
        $this->load->view('layout/images', $data);
        $this->load->view('layout/footer', $data);
    }

    function newImage() {
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['id'] = $session_data['id'];
        $this->load->view('layout/header', $data);
        $this->load->view('layout/navbar',$data);
        $this->load->view('admin/home', array('submitted' => true ));
        $this->load->view('layout/footer', $data);
    }

}

?>