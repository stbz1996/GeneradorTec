<?php
    class CourseDAO_Model extends CI_Model
    {
        public function __construct()
        {
            $this->load->database();
        }

        public function getCourses()
        {
            $this->db->select('code');
            $this->db->select('name');
            $this->db->select('idBlock');
            $this->db->from('Course');
            $this->db->where('state', 1);
            $query = $this->db->get();		
            if ($query->num_rows() > 0) return $query->result_array();
            else return false;
        }
    }