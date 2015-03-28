<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Links extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('images_model','',TRUE);
    }

    function index($filter) {
        $this->isLoggedIn();
        $data['allLinks'] = $this->getLinks($filter);
        $data['header'] = $filter;

        if(isset($status)) {
            $data['status'] = $status;
        }

        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/addlink', $data);
        $this->load->view('admin/links', $data);
        $this->load->view('admin/linkstable', $data);
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
     * Get the list of images
     */
    function getLinks($filter) {
        if($filter === "all") {
            $links = $this->link_model->get_all_links();
        } else {
            $links = $this->link_model->get_status_filtered_links($filter);
        }
        return $links;
    }

    /**
     * Display new image form
     */
    function displayNewImageForm() {
        $this->load->view('layout/header');
        $this->load->view('layout/navbar');
        $this->load->view('admin/newImage');
        $this->load->view('layout/footer');
    }

    /**
     * Create a new link in the database
     */
    function newImage() {
        // validate input
        $this->load->library('form_validation');

        if($this->form_validation->run() == true) {

            $groups = $this->input->post('groups');
            $groupList = $this->stringifyGroups($groups);
            $data['url'] = $this->input->post('url');
            $data['name'] = $this->input->post('name');
            $data['groups'] = $groupList;
            $data['image'] = $this->input->post('image');
            $data['description'] = $this->input->post('description');
            $data['status'] = "Pending";
            $this->link_model->add_new_link($data);
            $data['status'] = "success";

            redirect('links/index/all', $data);
        } else {
            $data['status'] = "error";
            redirect('links/index/all', $data);
        }
    }

    function newExternalLink() {
        if(isset($_POST['vermili']) && $_POST['vermili'] == "external") {
            // validate input
            $this->load->library('form_validation');
            $this->form_validation->set_rules('url', 'URL for the Link', 'trim|required|xss_clean');
            $this->form_validation->set_rules('name', 'Link Name', 'trim|xss_clean');
            $this->form_validation->set_rules('groups', 'Groups Link Belongs To', 'xss_clean');
            $this->form_validation->set_rules('image', 'Image URL', 'trim|xss_clean');
            $this->form_validation->set_rules('description', 'Link Description', 'trim|xss_clean');

            if($this->form_validation->run() == true) {
                $data['url'] = $_POST['url'];
                $data['name'] = $_POST['name'];
                $data['groups'] = "";
                $data['image'] = $_POST['image'];
                $data['description'] = $_POST['description'];
                $data['status'] = "Pending";
                $this->link_model->add_new_link($data);
                $data['status'] = "success";

                echo "<script type=text/javascript>";
                echo "location.href='../success.php'</script>";
            } else {
                echo "<script type=text/javascript>";
                echo "location.href='../error.php'</script>";
            }
        } else {
            echo "<script type=text/javascript>";
            echo "location.href='../error.php'</script>";
        }
    }

    function stringifyGroups($groups){
        $groupList = "";
        if($groups[0] != "") {
            foreach($groups as $group) {
                if(strlen($groupList) == 0) {
                    $groupList = $group . " ";
                } else {
                    $groupList = $groupList . " " . $group;
                }
            }
        }
        return $groupList;
    }

    function updatelink() {
        // validate input
        $this->load->library('form_validation');
        $this->form_validation->set_rules('url', 'URL for the Link', 'trim|xss_clean');
        $this->form_validation->set_rules('name', 'Link Name', 'trim|xss_clean');
        $this->form_validation->set_rules('status', 'Link Status', 'trim|xss_clean');
        $this->form_validation->set_rules('groups', 'Groups Link Belongs To', 'xss_clean');
        $this->form_validation->set_rules('image', 'Image URL', 'trim|xss_clean');
        $this->form_validation->set_rules('description', 'Link Description', 'trim|xss_clean');

        if($this->form_validation->run() == true) {
            $original = $this->input->post('original');
            $groups = $this->input->post('groups');
            $originalGroups = $this->stringifyGroups($groups);

            $updated['url'] = $this->getNewValue($original['url'], $this->input->post('url'));
            $updated['name'] = $this->getNewValue($original['name'], $this->input->post('name'));
            $updated['status'] = $this->getNewValue($original['status'], $this->input->post('status'));
            $updated['groups'] = $this->getNewValue($original['groups'], $originalGroups);
            $updated['image'] = $this->getNewValue($original['image'], $this->input->post('image'));
            $updated['description'] = $this->getNewValue($original['description'], $this->input->post('description'));

            $this->link_model->update_link_information($original['id'], $updated);
            redirect('links/edit/' . $original['id']);
        } else {
            redirect('links/edit/' . $original['id']);
        }
    }

    function uploadImage() {
        $target_dir = "imagesSubmitted/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);

        $errors = false;

        $imageFileType = pathinfo($target_file, PATHINFO_EXTENSION);

        if(isset($_POST['submit'])) {
            $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
            if($check !== false) {
                echo "File is an image - " . $check["mime"] . ".";
                $errors = false;
            } else {
                echo "File is not an image";
                $errors = true;
            }
        }

        if(file_exists($target_file)) {
            echo "Sorry, file already exists";
            $errors = true;
        }

        if ($_FILES["fileToUpload"]["size"] > 500000) {
            echo "Sorry, file is too big";
            $errors = true;
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
            echo "Sorry, we only accept JPG, JPEG and PNG image types";
            $errors = true;
        }

        if($errors) {
            echo "Sorry, the file was not uploaded";
        } else {
            if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                echo "The file " . basename( $_FILES["fileToUpload"]["name"]) . "has been uploaded";
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
    }

}
