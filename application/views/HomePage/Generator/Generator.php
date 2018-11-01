<?php	

	// Asigna los colores 
	$colors = array('#B381CB', '#C8BA30', '#25A575', '#3EFA06', '#06FA9E', '#A0B2AB', '#167ECA', '#6EC1FD', '#2D0DCD', '#900DCD', '#CB81BE', '#EE18C9', '#EE1859', '#53C830');
	shuffle($colors);


	// Assign colors 
	foreach ($solutions as $sol) 
	{
		$count = 0;
		foreach ($sol->getMagistralClassesList() as $cm) 
		{
			$cm->colorRepresentationForView = $colors[$count];
			$count ++;
		}
	}

	// Find the magistral class
	function findClass($solutions, $numSolution, $numBlock, $schedule)
	{
		$magistralClases = $solutions[$numSolution]->getMagistralClassesList();
		foreach ($magistralClases as $cm) 
		{
			$cmBlock   = $cm->getCourse()->getBlock()->getNumber();
			$schedules = $cm->getAssignedSchedules();
			if ($cmBlock == $numBlock) 
			{
				foreach ($schedules as $sch) 
				{
					if ($schedule == $sch) 
					{
						return $cm;
					}
				}
			}
		}
		// Si no existe ninguna clase
		return false;
	}

	// Schedule representation 
	$count = 0;
	$hours = array(
		'7:30am - 8:20am','8:30am - 9:20am','9:30am - 10:20am','10:30am - 11:20am',
		'11:30am - 12:20pm', '1:00pm - 1:50pm','2:00pm - 2:50pm','3:00pm - 3:50pm',
		'4:00pm - 4:50pm','4:50pm - 5:30pm','5:30pm - 6:20pm','6:20pm - 7:10pm',
		'7:25pm - 8:15pm','8:15pm - 9:05pm','9:05pm - 9:55pm'
	);
	
	// number of total solutions 
	$numSolutions = 5;//count($solutions);
?>

<?php 
for ($r = 0; $r < $numSolutions; $r++) { ?>
	<div class="titles">
	  	<h1>Soluciones de horarios #<?= $r + 1 ?></h1>
	</div>

	<div class="totalContainer">
		<?php 
		for ($x = 0; $x < $numBlocks; $x++) { 
			$listOfmagistralClases = array();
			?>
			<div class="solutionContainer">
				<div class="textBlock"> Bloque <?= $x + 1 ?> </div>
				<div class="days">
					<div class="itemDay"> Hora      </div>
					<div class="itemDay"> Lunes     </div>
					<div class="itemDay"> Martes    </div>
					<div class="itemDay"> Miércoles </div>
					<div class="itemDay"> Jueves    </div>
					<div class="itemDay"> Viernes   </div>
					<div class="itemDay"> Sabado    </div>
				</div>

				<?php 
				$counter = 1;
				for ($i = 0; $i < 14; $i++) { ?>
					<div class="itemSpace">
						<div class="itemHour"> <?= $hours[$i] ?> </div>
						<?php 
						for ($k = 0; $k < 6; $k++) { 
							$numSolution = $r;
							$numBlock    = $x + 1;
							$schedule    = $counter; 
							$cm = findClass($solutions, $numSolution, $numBlock, $schedule);
							if ($cm == false) 
							{
								$courseName = '';
								$colorRep = 'white';
							}
							else
							{
								$courseName = $cm->getCourse()->getName();
								$colorRep   = $cm->colorRepresentationForView;
								if (!in_array($cm, $listOfmagistralClases)) {
								    array_push($listOfmagistralClases, $cm);
								}
							}
							?>
							<div class="itemCourse" style="background: <?= $colorRep ?>;">
								<!-- <?= $courseName ?> --->
							</div>
						<?php $counter += 1; } ?>						
					</div>
				<?php } ?>
			</div>

			<div class="InfoContainer">
				<p>Cursos</p>
				<?php 
				foreach ($listOfmagistralClases as $cm) {
					$code       = $cm->getCourse()->getCode();
					$courseName = $cm->getCourse()->getName();
					$group      = $cm->getGroup()->getNumber();
					$color      = $cm->colorRepresentationForView;
					?>
					<div style="background: <?= $color ?>;">
						<?= $code.' '.$courseName.' '.$group ?>
					</div>
				<?php } ?>
			</div>

			<div class="InfoContainer">
				<p>Profesores</p>

				<?php 
				foreach ($listOfmagistralClases as $cm) {
					$professor  = $cm->getProfessor()->getName();
					$color      = $cm->colorRepresentationForView;
					?>
					<div style="background: <?= $color ?> ;"> <?= $professor ?> </div>
				<?php } ?>
			</div>
		<?php } ?>
	</div>
<?php } ?>