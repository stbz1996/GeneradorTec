<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class System_Logic
{
	function __construct()
	{
	}

	public function getHoursRepresentationForView()
	{
		$data = array(1=>"7:30am - 8:20am", 2=>"8:30am - 9:20am", 3=>"9:30am - 10:20am", 4=>"10:30am - 11:20am", 5=>"1:00pm - 1:50pm", 6=>"2:00pm - 2:50pm", 7=>"3:00pm - 3:50pm", 8=>"4:00pm - 4:50pm", 9=>"4:50pm - 5:30pm", 10=>"5:30pm - 6:20pm", 11=>"6:20pm - 7:10pm", 12=>"7:25pm - 8:15pm", 13=>"8:15pm - 9:05pm", 14=>"9:05pm - 9:55pm");
		Return $data;
	}

	public function getDaysRepresentation()
	{
		$data = array("Lunes" => 1, "Martes" => 2, "Miercoles" => 3, "Jueves" => 4, "Viernes" => 5, "Sabado" => 6);
		return $data;
	}

	
	public function gethoursRepresentation()
	{
		$data = array("07:30:00"=>1, "08:30:00"=>2, "09:30:00"=>3, "10:30:00"=>4, "01:00:00"=>5, "02:00:00"=>6, "03:00:00"=>7, "04:00:00"=>8, "04:50:00"=>9, "05:30:00"=>10, "06:20:00"=>11, "07:25:00"=>12, "08:15:00"=>13, "09:05:00"=>14); 
		return $data;
	}

}

?>