<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CourseDAO_model extends CI_Model
{
    var $table = 'Course';
    var $tableForBlock = 'CourseXBlock';
    var $tableServiceLesson = 'ServiceLesson';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    /****************************************
    - Get all the courses from the database
    ****************************************/
    public function show($idBlock)
    {
        $this->db->select('Course.idCourse as idCourse');
        $this->db->select('Course.code as code');
        $this->db->select('Course.name as name');
        $this->db->select('Course.state as state');
        $this->db->select('Course.isCareer as isCareer');
        $this->db->select('Course.lessonNumber as lessonNumber');
        $this->db->select('Block.name as blockName');
        $this->db->select('Plan.name as planName');
        $this->db->from('Block');
        $this->db->join('CourseXBlock', 'Block.idBlock = CourseXBlock.idBlock');
        $this->db->join('Course', 'Course.idCourse = CourseXBlock.idCourse');
        $this->db->join('Plan', 'Block.idPlan = Plan.idPlan');

        if ($idBlock)
        {
            $this->db->where('Block.idBlock', $idBlock);
        }

        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query;
        }
        else
        {
            return false;
        }
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

        $courseXBlock = array(
            'idCourse' => $this->db->insert_id(),
            'idBlock' => $Course['idBlock']
        );

        $this->db->insert($this->tableForBlock, $courseXBlock);
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

        $courseXBlock = array(
            'idCourse' => $Course['idCourse'],
            'idBlock' => $Course['idBlock']
        );

        $this->addCourseXBlock($courseXBlock); // Try to insert to the database.

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


    /* Try to insert in the database. */
    public function addCourseXBlock($CourseXBlock)
    {
        try{
            $this->db->select('*');
            $this->db->from($this->tableForBlock);
            $this->db->where('idCourse', $CourseXBlock['idCourse']);
            $this->db->where('idBlock', $CourseXBlock['idBlock']);
            $query = $this->db->get();
            if ($query->num_rows() == 0)
            {
                $this->db->insert($this->tableForBlock, $CourseXBlock);
            }
            return 1;
        }
        catch(Exception $e)
        {
            return 0;
        }
    }

    /****************************************
    - Delete the course in the database.
    ****************************************/
    public function delete($id)
    {
        /* Drop all the instances of the course in the block.*/
        $this->db->where('idCourse', $id);
        $this->db->delete($this->tableForBlock);
        $num_affected_rows = $this->db->affected_rows();
        
        if(!$num_affected_rows)
        {
            echo 'false';
            return;
        }

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
        /*
        //New part to add with the new table

        $this->db->join('CourseXBlock', 'Course.idCourse = CourseXBlock.idCourse');
        $this->db->join('Block', 'CourseXBlock.idBlock = Block.idBlock');
        */
        $this->db->join('Block', 'Course.idBlock = Block.idBlock');
        $this->db->where('Block.idPlan', $idPlan);
        $this->db->where('Course.isCareer', 1);
        $query = $this->db->get();
        return $query;
    }

    public function getBlockCourses($idBlock)
    {
        $this->db->select('Course.idCourse');
        $this->db->select('code');
        $this->db->select('name');
        $this->db->select('state');
        $this->db->select('lessonNumber');
        $this->db->from('Course');
        $this->db->join('CourseXBlock', 'Course.idCourse = CourseXBlock.idCourse');
        $this->db->where('CourseXBlock.idBlock', $idBlock);
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

    /****************************************
    *Function that get all active courses   *
    *                                       *
    *                                       *
    *Result:                                *
    *   Query with all plans' information   *
    *****************************************/
    public function getServiceCourses()
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('isCareer', 0);
        $query = $this->db->get();
        return $query->result();
    }


    public function serviceLessonAssigned($pIdPeriod)
    {
        $this->db->select('*');
        $this->db->from('ServiceLesson');
        $this->db->where('idPeriod', $pIdPeriod);
        return $this->db->get()->result();
    }

    public function getServiceLessonsByPeriod($pIdPeriod)
    {
        $this->db->select('Course.name');
        $this->db->select('ClassGroup.number as group');
        $this->db->select('Course.lessonNumber as numLessons');
        $this->db->select('Course.idBlock as block');
        $this->db->select('Schedule.description as lesson');
        $this->db->select('Schedule.numberSchedule');
        $this->db->from('ServiceLesson');
        $this->db->join('Course', 'Course.idCourse = ServiceLesson.idCourse');
        $this->db->join('ClassGroup', 'ClassGroup.idGroup = ServiceLesson.idGroup');
        $this->db->join('Schedule', 'Schedule.numberSchedule = ServiceLesson.numberSchedule');
        $this->db->where('ServiceLesson.idPeriod', $pIdPeriod);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    public function getIdCourse($pCourseName)
    {
        $this->db->select('idCourse');
        $this->db->from('Course');
        $this->db->where('name', $pCourseName);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }
    
    public function getIdGroup($pCourseGroup)
    {
        $this->db->select('ClassGroup.idGroup');
        $this->db->from('ClassGroup');
        $this->db->where('ClassGroup.number', $pCourseGroup);
        
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            return $query->result();
        }
        else
        {
            return false;
        }
    }

    /****************************************
    - Insert the new lesson in the database.
    ****************************************/
    public function insertLesson($lessonInfo)
    {
        $this->db->select('idCourse');
        $this->db->from('Course');
        $this->db->where('name', $lessonInfo['idCourse']);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach($query->result_array()  as $row)
            {
                $lol = $row['idCourse'];
            }
        }

        $this->db->select('idGroup');
        $this->db->from('ClassGroup');
        $this->db->where('number', $lessonInfo['idGroup']);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach($query->result_array()  as $row)
            {
                $lol2 = $row['idGroup'];
            }
        }

        $data = array(
            'numberSchedule' => $lessonInfo['numberSchedule'],
            'idPeriod' => $lessonInfo['idPeriod'],
            'idCourse' => $lol,
            'idGroup' => $lol2
         );

        $this->db->insert($this->tableServiceLesson, $data);

        echo 'true';
        return;
    }
    
    /****************************************
    - Delete a lesson in the database.
    ****************************************/
    public function deleteLesson($lessonInfo)
    {
        $this->db->select('idCourse');
        $this->db->from('Course');
        $this->db->where('name', $lessonInfo['idCourse']);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach($query->result_array()  as $row)
            {
                $lol = $row['idCourse'];
            }
        }

        $this->db->select('idGroup');
        $this->db->from('ClassGroup');
        $this->db->where('number', $lessonInfo['idGroup']);
        $query = $this->db->get();

        if ($query->num_rows() > 0)
        {
            foreach($query->result_array()  as $row)
            {
                $lol2 = $row['idGroup'];
            }
        }

        $data = array(
            'numberSchedule' => $lessonInfo['numberSchedule'],
            'idPeriod' => $lessonInfo['idPeriod'],
            'idCourse' => $lol,
            'idGroup' => $lol2
         );

        $this->db->where('numberSchedule', $data['numberSchedule']);
        $this->db->where('idPeriod', $data['idPeriod']);
        $this->db->where('idCourse', $data['idCourse']);
        $this->db->where('idGroup', $data['idGroup']);
        $this->db->delete($this->tableServiceLesson);

        echo 'true';
        return;
    }
}