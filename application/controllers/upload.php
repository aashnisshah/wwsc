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
		$config['max_size']	= '99999';
		$config['max_width']  = '9999';
		$config['max_height']  = '9999';
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
			$uploadData = $this->upload->data();
			$data['file_name'] = $uploadData['file_name'];
			var_dump($data);
			$data['childSafe'] = $this->childSafe($data['file_name']);
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
	function childSafe($imgUrl) {
		$mashapeEndpoint = "https://sphirelabs-advanced-porn-nudity-and-adult-content-detection.p.mashape.com/v1/get/index.php?url=";
		// $imgUrl = "http://i.imgur.com/4hGni1I.jpg";
		error_log($imgUrl);
		$response = $this->unirest->get($mashapeEndpoint . $imgUrl,
		  array(
		    "X-Mashape-Key" => "6SthFMuqzxmshK1E5PaSCNyokBgxp16e0zbjsn522jIHGSDuDa",
		    "Content-Type" => "application/x-www-form-urlencoded",
		    "Accept" => "application/json"
		  )
		);

		if($response && $response->body && isset($response->body->{'Is Porn'})) {
			return strcmp($response->body->{'Is Porn'}, "True");
		} else {
			return false;
		}

	}
}
?>