<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FillInformation{

	function __construct()
	{}

	function printHello()
	{
		echo "Hello World";
	}

	function fillActivity($idActivity)
	{
		$activityDAO = new ActivityDAO_model();
		$activityQuery = $activityDAO->getActivity($idActivity);

		if($activityQuery)
		{
			$activity = new Activity();
			$activity->setId($activityQuery->idActivity);
			$activity->setDescription($activityQuery->description);
			$activity->setWorkPorcent($activityQuery->workPorcent);
			return $activity;
		}
		return false;
	}

	function fillSchedule($idSchedule)
	{
		$scheduleDAO = new ScheduleDAO_model();
		$scheduleQuery = $scheduleDAO->getSchedule($idSchedule);

		if($scheduleQuery)
		{
			$schedule = new Schedule();
			$schedule->setDay($scheduleQuery->dayName);
			$schedule->setInitialHour($scheduleQuery->initialTime);
			$schedule->setFinalHour($scheduleQuery->finishTime);
			
			return $schedule;
		}

		return false;
	}

	function fillPlan($idPlan)
	{
		$planDAO = new PlanDAO_model();
		$planQuery = $planDAO->get($idPlan);

		if($planQuery)
		{
			$plan = new Plan();
			$plan->setId($planQuery->idPlan);
			$plan->setName($planQuery->name);
			return $plan;
		}

		return false;
	}

	function fillGroup($idGroup)
	{
		$groupDAO = new GroupDAO_model();
		$groupQuery = $groupDAO->getGroup($idGroup);

		if($groupQuery)
		{
			$group = new Group();
			$group->setId($groupQuery->idGroup);
			$group->setNumber($groupQuery->number);
			return $group;
		}

		return false;
	}

	function fillBlock($idBlock)
	{
		$blockDAO = new BlockDAO_model();
		$planDAO = new PlanDAO_model();

		$blockQuery = $blockDAO->get($idBlock);
		$planQuery = $planDAO->getPlanFromBlock($idBlock)->row();


		if($blockQuery && $planQuery)
		{
			$plan = $this->fillPlan($planQuery->idPlan);

			$block = new Block();
			$block->setId($blockQuery->idBlock);
			$block->setName($blockQuery->name);
			$block->setPlan($plan);

			return $block;
		}

		return false;
	}

	function fillCourse($idCourse)
	{
		$courseDAO = new CourseDAO_model();
		$blockDAO = new BlockDAO_model();

		$courseQuery = $courseDAO->get($idCourse);
		$blockQuery = $blockDAO->getBlockByCourse($idCourse);

		if($courseQuery && $blockQuery)
		{
			$block = $this->fillBlock($blockQuery->idBlock);

			$course = new Course();
			$course->setId($courseQuery->idCourse);
			$course->setName($courseQuery->code);
			$course->setCode($courseQuery->name);
			$course->setTotalLessons($courseQuery->lessonNumber);
			$course->setBlock($block);

			return $course;
		}
		return false;
	}

	function fillProfessor($idProfessor)
	{
		$professorDAO = new ProfessorDAO_model();
		$formDAO = new FormDAO_model();
		$activityDAO = new ActivityDAO_model();
		$coursesDAO = new CourseDAO_model();
		$scheduleDAO = new ScheduleDAO_model();

		$professorQuery = $professorDAO->get($idProfessor);

		$idForm = $formDAO->getFormByProfessor($idProfessor)->idForm;
		
		$activitiesQuery = $activityDAO->getActivities($idForm)->result_array();
		$coursesQuery = $coursesDAO->getFormCourses($idForm)->result_array();
		$schedulesQuery = $scheduleDAO->getSchedulesByForm($idForm)->result_array();

		if($professorQuery && $coursesQuery && $schedulesQuery)
		{
			$professor = new Professor();
			$professor->setWorkload($professorQuery->workLoad);
			$professor->setName($professorQuery->name);

			//Activities
			if(!$activitiesQuery)
			{
				$professor->setActivities(array());
			}
			else
			{
				$activities = array();
				foreach ($activitiesQuery as $row)
				{
					$activity = $this->fillActivity($row['idActivity']);
					$activities[] = $activity;
				}
				$professor->setActivities($activities);
			}

			//Courses

			$courses = array();
			foreach ($coursesQuery as $row) {
				$course = $this->fillCourse($row['idCourse']);
				$courses[] = $course;
			}
			$professor->setCourses($courses);

			//Schedules
			$schedules = array();
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