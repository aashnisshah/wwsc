<?php

class Upload extends CI_Controller {

	function __construct()
	{
		parent::__construct();
		$this->load->helper(array('form', 'url'));
		$this->load->library('unirest');
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
		$date = new DateTime();
		$config['upload_path'] = $_SERVER['DOCUMENT_ROOT'] . '/as/uploads';
		$config['allowed_types'] = 'gif|jpg|png';
		$config['max_size']	= '10000';
		$config['max_width']  = '1024';
		$config['max_height']  = '768';
		$config['file_name'] = $date->getTimestamp();

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
			$data['childSafe'] = $this->childSafe();
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

	/** this function checks to see if the image is child-friendly **/
	function childSafe() {

		$response = $this->unirest->get("https://sphirelabs-advanced-porn-nudity-and-adult-content-detection.p.mashape.com/v1/get/index.php?url=http%3A%2F%2Fthumbs1.ebaystatic.com%2Fd%2Fl225%2Fpict%2F251356261220_1.jpg",
		  array(
		    "X-Mashape-Key" => "6SthFMuqzxmshK1E5PaSCNyokBgxp16e0zbjsn522jIHGSDuDa",
		    "Content-Type" => "application/x-www-form-urlencoded",
		    "Accept" => "application/json"
		  )
		);

		return !$response->body->{'Is Porn'};

	}
}
?>