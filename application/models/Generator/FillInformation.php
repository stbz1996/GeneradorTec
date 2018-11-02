<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FillInformation{

	function __construct()
	{
	}


	function serviceLessonAssigned($pIdPeriod)
	{
		$result = array();
		$courses       = new CourseDAO_model();
		$servieLessons = $courses->serviceLessonAssigned($pIdPeriod);
		foreach ($servieLessons as $sl) 
		{
			$temp = array();
			array_push($temp, $this->fillGroup($sl->idGroup));
			array_push($temp, $this->fillCourse($sl->idCourse));
			array_push($temp, $sl->numberSchedule);
			array_push($result, $temp);
		}
		return $result;
	}


	/*********************************************
	*Function that returns an activity by his id *
	*Input: 									 *
	*	-$idActivity: Integer, id of an activity *
	*											 *
	*Output: 									 *
	*	Returns an Activity 					 *
	**********************************************/
	function fillActivity($idActivity)
	{
		$activityDAO = new ActivityDAO_model();
		$activityQuery = $activityDAO->getActivity($idActivity);

		if($activityQuery)
		{
			/* Create new Activity and returns it*/
			$activity = new Activity();
			$activity->setId($activityQuery->idActivity);
			$activity->setDescription($activityQuery->description);
			$activity->setWorkPorcent($activityQuery->workPorcent);
			return $activity;
		}
		return false;
	}


	/********************************************
	*Function that returns a schedule by his id *
	*Input: 									*
	*	-$idSchedule: Integer, id of a schedule *
	*											*
	*Output: 									*
	*	Returns a Schedule 						*
	*********************************************/
	function fillSchedule($idSchedule)
	{
		$scheduleDAO = new ScheduleDAO_model();
		$scheduleQuery = $scheduleDAO->getSchedule($idSchedule);
		if($scheduleQuery)
		{
			return $scheduleQuery->numberSchedule;
		}
		return false;
	}


	/********************************************
	*Function that returns a plan by his id 	*
	*Input: 									*
	*	-$idPlan: Integer, id of a plan 		*
	*											*
	*Output: 									*
	*	Returns an Plan 	 					*
	*********************************************/
	function fillPlan($idPlan)
	{
		$planDAO = new PlanDAO_model();
		$planQuery = $planDAO->get($idPlan);
		if($planQuery)
		{
			/* Create new plan and returns it*/
			$plan = new Plan();
			$plan->setId($planQuery->idPlan);
			$plan->setName($planQuery->name);
			return $plan;
		}
		return false;
	}


	/********************************************
	*Function that returns a group by his id 	*
	*Input: 									*
	*	-$idGroup: Integer, id of a group 	 	*
	*											*
	*Output: 									*
	*	Returns an Group 	 					*
	*********************************************/
	function fillGroup($idGroup)
	{
		$groupDAO = new GroupDAO_model();
		$groupQuery = $groupDAO->getGroup($idGroup);
		if($groupQuery)
		{
			/* Create new group and returns it*/
			$group = new Group();
			$group->setId($groupQuery->idGroup);
			$group->setNumber($groupQuery->number);
			return $group;
		}
		return false;
	}


	/************************************************
	*Function that returns all the blocks of a plan *
	*Input: 									    *
	*	-$pIdPlan: Integer, id of a plan      	 	*
	*										     	*
	*Output: 									    *
	*	Returns a list of blocks     			    *
	************************************************/
	public function getNumBlocks($pIdPlan)
	{
		$result = array();
		$blockDAO_model = new BlockDAO_model();
 		$query = $blockDAO_model->show($pIdPlan);
 		return count($query->result());
	}


	/********************************************
	*Function that returns all schedules      	*
	*Output: 									*
	*	Returns a list of schedules 			*
	*********************************************/
	public function getSchedules()
	{
		$scheduleDAO_model = new ScheduleDAO_model();
 		$query = $scheduleDAO_model->getAllSchedules();
 		if (!$query)
 		{
 			return array();
 		}
 		return $query;
	}


	/********************************************
	*Function that returns a block by his id 	*
	*Input: 									*
	*	-$idBlock: Integer, id of a block 	 	*
	*											*
	*Output: 									*
	*	Returns an Block 	 					*
	*********************************************/
	function fillBlock($idBlock)
	{
		$blockDAO   = new BlockDAO_model();
		$planDAO    = new PlanDAO_model();
		$blockQuery = $blockDAO->get($idBlock);
		/* Get information of plan */
		$planQuery = $planDAO->getPlanFromBlock($idBlock)->row();
		if($blockQuery && $planQuery)
		{
			/* Create plan */
			$plan = $this->fillPlan($planQuery->idPlan);
			/* Create new block and returns it */
			$block = new Block();
			$block->setId($blockQuery->idBlock);
			$block->setName($blockQuery->name);
			$block->setNumber($blockQuery->number);
			$block->setPlan($plan);
			return $block;
		}
		return false;
	}


	/********************************************
	*Function that returns a course by his id 	*
	*Input: 									*
	*	-$idCourse: Integer, id of a course	 	*
	*											*
	*Output: 									*
	*	Returns an Course 	 					*
	*********************************************/
	function fillCourse($idCourse)
	{
		$courseDAO = new CourseDAO_model();
		$blockDAO = new BlockDAO_model();
		$courseQuery = $courseDAO->get($idCourse);

		/* Get information of block */
		$blockQuery = $blockDAO->getBlockByCourse($idCourse);
		if($courseQuery && $blockQuery)
		{
			/* Create block */
			$block = $this->fillBlock($blockQuery->idBlock);
			/* Create new Course and returns it*/
			$course = new Course();
			$course->setId($courseQuery->idCourse);
			$course->setCode($courseQuery->code);
			$course->setName($courseQuery->name);
			$course->setTotalLessons($courseQuery->lessonNumber);
			$course->setBlock($block);
			return $course;
		}
		return false;
	}


	/********************************************
	*Function that returns a professor by his id*
	*Input: 									*
	*	-$idProfessor: Integer, id of a profe- 	*
	*	ssor									*
	*Output: 									*
	*	Returns an Professor 					*
	*********************************************/
	function fillProfessor($idProfessor)
	{
		$professorDAO   = new ProfessorDAO_model();
		$formDAO        = new FormDAO_model();
		$activityDAO    = new ActivityDAO_model();
		$coursesDAO     = new CourseDAO_model();
		$scheduleDAO    = new ScheduleDAO_model();
		$professorQuery = $professorDAO->get($idProfessor);
		
		/*Get information of form, activities, courses and schedules */
		$idForm = $formDAO->getFormByProfessor($idProfessor)->idForm;
		$activitiesQuery = $activityDAO->getActivities($idForm);
		$coursesQuery = $coursesDAO->getFormCourses($idForm)->result_array();
		$schedulesQuery = $scheduleDAO->getSchedulesByForm($idForm)->result_array();
		
		if($professorQuery && $coursesQuery && $schedulesQuery)
		{
			$professor = new Professor();
			$professor->setWorkload($professorQuery->workLoad);
			$professor->setName($professorQuery->name.' '.$professorQuery->lastName);
			$professor->setId($idProfessor);
			
			//Activities
			/*Verify if they are activities*/
			if($activitiesQuery == false)
			{
				$professor->setActivities(array());
			}
			else
			{
				$activities = array();
				/* Add activities in professor class */
				foreach ($activitiesQuery as $row)
				{
					$activity = $this->fillActivity($row['idActivity']);
					$activities[] = $activity;
				}
				$professor->setActivities($activities);
			}
			
			//Courses
			$courses = array();
			/* Add courses in professor class */
			foreach ($coursesQuery as $row) 
			{
				$course = $this->fillCourse($row['idCourse']);
				$courses[] = $course;
			}
			$professor->setCourses($courses);
			
			//Schedules
			$schedules = array();
			/* Add schedules in professor class */
			foreach ($schedulesQuery as $row) {
				$schedule = $this->fillSchedule($row['idSchedule']);
				$schedules[] = $schedule;
			}
			$professor->setSchedules($schedules);
			return $professor;
		}
		return false;
	}
}
?>