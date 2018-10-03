<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Generator_Logic{


	function __construct()
	{

	}

	function getTotalActiveBlocks($idPlan)
	{
		$blockDAO = new BlockDAO_model();
		return $blockDAO->getTotalActiveBlocks($idPlan);
	}

}

?>