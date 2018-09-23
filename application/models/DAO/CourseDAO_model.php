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
        echo 'true';
        return;
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
        $query = $this->db->update($this->table, $changes);

        if($query)
        {
            echo 'true';
            return;
        }
        else
        {
            echo 'false';
            return;
        }
    }

    /****************************************
    - Delete the block in the database.
    ****************************************/
    public function delete($id)
    {
        $this->db->where('idCourse', $id);
        $this->db->delete($this->table);
        
        if($this->db->affected_rows())
        {
            echo 'true';
            return;
        }
        else
        {
            echo 'false';
            return;
        }
    }

    /****************************************
    - Activate or desactivate the course.
    ****************************************/
    public function changeState($Course)
    {
        $changes = array(
            'state' => $Course['state']
        );
        $this->db->where('idCourse', $Course['idCourse']);
        $this->db->update($this->table, $changes);
    }

    /****************************************
    *Function that get all active plans     *
    *                                       *
    *Input:                                 *
    *   -$idPlan: Integer, id of a plan     *
    *                                       *
    *Result:                                *
    *   Query with all plans' information   *
    *****************************************/
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

    /****************************************
    *Function that returns query of courses *
    *assigned by professor.                 *
    *                                       *
    *Input:                                 *
    *   -$idForm: Integer, id of Form       *
    *Result:                                *
    *   Query with all courses assigned by  *
    *   professor.                          *
    *****************************************/
    public function getFormCourses($idForm)
    {
        $this->db->select('idCourse');
        $this->db->select('priority');
        $this->db->from('CourseXForm');
        $this->db->where('idForm', $idForm);
        $query = $this->db->get();
        return $query;
    }

    /****************************************
    *Function that get all active courses   *
    *                                       *
    *                                       *
    *Result:                                *
    *   Query with all plans' information   *
    *****************************************/
    public function getActiveCourses()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('state', 1);
        $this->db->where('isCareer', 1);
        $query = $this->db->get();
        return $query->result();
    }
}