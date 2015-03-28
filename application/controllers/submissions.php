<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Submissions extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('submissions_model','',TRUE);
        $session_data = $this->session->userdata('logged_in');
        $data['username'] = $session_data['username'];
        $data['id'] = $session_data['id'];
    }

    function index() {
        $this->isLoggedIn();
        $data['categories'] = $this->getCategories();
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/displayInstructions');
        $this->load->view('admin/displayCode');
        $this->load->view('admin/display', $data);
        $this->load->view('layout/footer');
    }

    function isLoggedIn() {
        if($this->session->userdata('logged_in')) {
                return true;
        } else {
            redirect('login');
        }
    }

    /**
     * Create a new submission
     */
    function add_new_submission() {
        $this->load->library('form_validation');

            $session_data = $this->session->userdata('logged_in');
            $data['imageId'] = $this->input->post('imageId');
            $data['words'] = $this->input->post('words');
            $data['sender'] = $this->session->userdata('username');
            $data['receiver'] = $this->input->post('receiver');
            $data['status'] = 'new';
            $this->submissions_model->add_new_submission($data);
            $data['status'] = "success";

            redirect('home/index', $data);
    }

    /**
     * Get all submissions that user has sent
     */
    function getSentSubmissions() {
        $categories = $this->submissions_model->get_all_submissions_sent_for_id();
        $catArray = array();
        foreach ($categories as $cat) {
            $catArray[$cat['id']] = $cat['name'];
        }
        return $catArray;
    }

    function generateCode() {

        // validate input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('show', 'Show Settings', 'trim|required|xss_clean');
        $this->form_validation->set_rules('cat', 'Categories to Show', 'xss_clean');
        $this->form_validation->set_rules('order', 'Order To Display Links', 'trim|xss_clean');
        $this->form_validation->set_rules('number', 'Number of Links to Display', 'trim|numeric|xss_clean');

        if($this->form_validation->run() == true) {
            $show = $this->input->post('show');
            $cat = $this->input->post('cat');
            $order = $this->input->post('order');
            $number = $this->input->post('number');

            include 'settings.php';

            $code = '&lt;?php ';
            $code .= '$show="' . $show . '"; ';
            $code .= '$cat="' . $cat . '"; ';
            $code .= '$order="' . $order . '"; ';
            $code .= '$number="' . $number . '"; ';
            $code .= 'include \'' . $_SERVER['DOCUMENT_ROOT']  . '/' . $tmlpath . '/display.php\';';
            $code .= ' ?&gt;';

            $data['code'] = $code;
        } else {
            $data['code'] = "There was an error generating your code.";
        }

        $data['categories'] = $this->getCategories();
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/displayInstructions');
        $this->load->view('admin/displayCode', $data);
        $this->load->view('admin/display', $data);
        $this->load->view('layout/footer');


    }

}
