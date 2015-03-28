<?php
class Submissions_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
    }

    /**
     * Add new link into the database
     */
    function add_new_submission($data) {
        return $this->db->insert("submissions",
                                 array('imageId' => $data['imageId'],
                                       'words' => $data['words'],
                                       'sender' => $data['sender'],
                                       'receiver' => $data['receiver'],
                                       'status' => $data['status'],
                                    ));
    }

    /**
     * Get all information about all submissions sent to $receiverId
     */
    function get_all_submissions_received_for_id($receiverId) {
        $query = $this->db->get_where('submissions', array('receiver' => $receiverId));
		$data = $query->result_array();
        return $data;
    }

    /**
     * Get all information about all submissions sent by $senderId sender
     */
    function get_all_submissions_sent_for_id($senderId) {
        $query = $this->db->get_where('submissions', array('receiver' => $senderId));
        $data = $query->result_array();
        return $data;
    }

    /**
     * Delete the submission with the provided id
     */
    function delete_submissions($id) {
        $this->db->delete('submissions', array('id' => $id));
    }

    /**
     *
     */
    function update_submission($id, $data) {
        $this->db->where('id', $id);
        $this->db->update('submissions', $data);
    }
}
?>
