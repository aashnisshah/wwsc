<?php

class Upload extends CI_Controller {

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
		$this->load->view('layout/upload_form', array('error' => ' ' ));
        $this->load->view('layout/footer', $data);
	}

	function do_upload()
	{
		$config['upload_path'] = '/Users/aashnisshah/GithubFun/wwsc/uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';

		$this->load->library('upload', $config);

		if ( ! $this->upload->do_upload())
		{
			$data['error'] = $this->upload->display_errors();

			$session_data = $this->session->userdata('logged_in');
			$data['upload_data'] = $this->upload->data();
	        $data['username'] = $session_data['username'];
	        $data['id'] = $session_data['id'];
	        $this->load->view('layout/header', $data);
	        $this->load->view('layout/navbar',$data);
			$this->load->view('layout/upload_form', $data);
	        $this->load->view('layout/footer', $data);
		}
		else
		{
			$session_data = $this->session->userdata('logged_in');
			$data['upload_data'] = $this->upload->data();
	        $data['username'] = $session_data['username'];
	        $data['id'] = $session_data['id'];
	        $this->load->view('layout/header', $data);
	        $this->load->view('layout/navbar',$data);
			$this->load->view('layout/upload_success', $data);
	        $this->load->view('layout/footer', $data);

		}
	}
}
?>