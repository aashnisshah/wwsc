<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('admin_model','',TRUE);
        $this->load->model('link_model', '', TRUE);
        $this->load->model('submissions_model', '', TRUE);
        $this->load->model('categories_model', '', TRUE);
    }

    function index() {
        if($this->session->userdata('logged_in')) {
            $session_data = $this->session->userdata('logged_in');
            $data['categories'] = $this->getCategories();
            $data['username'] = $this->session->userdata('username');
            $data['id'] = $session_data['id'];
            $data['allLinks'] = $this->submissions_model->get_all_submissions_received_for_id($data['username']);
            $this->load->view('layout/header', $data);
            $this->load->view('layout/navbar',$data);
            $this->load->view('admin/home',$data);
            $this->load->view('admin/linkstable', $data);
            $this->load->view('layout/footer', $data);
        } else {
            redirect('login', 'refresh');
        }
    }

    /**
     * Get the list of categories and their names
     */
    function getCategories() {
        $categories = $this->categories_model->get_all_categories();
        $catArray = array();
        foreach ($categories as $cat) {
            $catArray[$cat['id']] = $cat['name'];
        }
        return $catArray;
    }

    function logout() {
        $this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('username');
        $this->session->unset_userdata('id');
        $this->session->sess_destroy();
        redirect('login', 'refresh');
    }

}
