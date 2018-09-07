<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CourseDAO_model extends CI_Model
{
    var $table = 'Course';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function getCourses()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    public function getCourse($id)
    {
        $this->db->from($this->table);
        $this->db->where('idCourse', $id);
        $query = $this->db->get();
        return $query->row();
    }

    public function addCourse($data)
    {
        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function updateCourse($where, $data)
    {
        $this->db->update($this->table, $data, $where);
        return $this->db->affected_rows();
    }

    public function deleteCourse($id)
    {
        $this->db->where('idCourse', $id);
        $this->db->delete($this->table);
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

    public function getCareerCourses()
    {
        $this->db->select('*');
        $this->db->from('Course');
        $this->db->where('isCareer', 1);
        $this->db->where('state', 1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) return $query->result_array();
        else return false;
    }
}

