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

    /****************************************
    - Get all the courses from the database
    ****************************************/
    public function show()
    {
        $this->db->from($this->table);
        $query = $this->db->get();
        return $query->result();
    }

    /****************************************
    - Get all the courses that belongs to a specific block.
    ****************************************/
    public function showById($idBlock)
    {
        $this->db->from($this->table);
        $this->db->where('idBlock', $idBlock);
        $query = $this->db->get();
        return $query->result();
    }

    /****************************************
    - Get a unique course from the database
    ****************************************/
    public function get($id)
    {
        $this->db->from($this->table);
        $this->db->where('idCourse', $id);
        $query = $this->db->get();
        return $query->row();
    }

    /****************************************
    - Insert the new course in the database.
    ****************************************/
    public function insert($Course)
    {
        $this->db->insert($this->table, $Course);
        return $this->db->insert_id();
    }

    /****************************************
    - Edit all the changes in the database.
    ****************************************/
    public function edit($Course)
    {
        $changes = array(
            'code' => $Course['code'],
            'name' => $Course['name'],
            'state' => $Course['state'],
            'isCareer' => $Course['isCareer'],
            'lessonNumber' => $Course['lessonNumber'],
            'idBlock' => $Course['idBlock']
        );
        $this->db->where('idCourse', $Course['idCourse']);
        $this->db->update($this->table, $changes);
        return $this->db->affected_rows();
    }

    /****************************************
    - Delete the block in the database.
    ****************************************/
    public function delete($id)
    {
        $this->db->where('idCourse', $id);
        $this->db->delete($this->table);
    }

    public function getPlanCourses($idPlan)
    {
        $this->db->select('idCourse');
        $this->db->select('code');
        $this->db->select('Course.name as name');
        $this->db->select('lessonNumber');
        $this->db->select('Course.state as state');
        $this->db->from('Course');
        $this->db->join('Block', 'Course.idBlock = Block.idBlock');
        $this->db->where('Block.idPlan', $idPlan);
        $this->db->where('Course.isCareer', 1);
        $query = $this->db->get();
        return $query;
    }
}