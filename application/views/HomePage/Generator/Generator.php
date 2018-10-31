<?php	
	$count = 0;
	$hours = array(
		'7:30am - 8:20am','8:30am - 9:20am','9:30am - 10:20am','10:30am - 11:20am',
		'11:30am - 12:20pm', '1:00pm - 1:50pm','2:00pm - 2:50pm','3:00pm - 3:50pm',
		'4:00pm - 4:50pm','4:50pm - 5:30pm','5:30pm - 6:20pm','6:20pm - 7:10pm',
		'7:25pm - 8:15pm','8:15pm - 9:05pm','9:05pm - 9:55pm'
	);
?>

<div class="titles">
  	<h1>Soluciones de horarios</h1>
    <ul>
		<li type="disc"> 
			Se muestran las 5 mejores soluciones.   
		</li>
	</ul>
</div>

<?php 
for ($x = 0; $x < 7; $x++) { ?>
<div class="textBlock"> Bloque <?= $x ?> </div>
<div class="solutionContainer">
	<div class="days">
		<div class="itemDay"> Hora      </div>
		<div class="itemDay"> Lunes     </div>
		<div class="itemDay"> Martes    </div>
		<div class="itemDay"> Miercoles </div>
		<div class="itemDay"> Jueves    </div>
		<div class="itemDay"> Viernes   </div>
		<div class="itemDay"> Sabado    </div>
	</div>

	<?php 
	$counter = 1;
	for ($i = 0; $i < 14; $i++) { ?>
		<div class="itemSpace">
			<!-- It is the hour -->
			<div class="itemHour"> <?= $hours[$i] ?> </div>
			<?php 
			for ($k=0; $k < 6; $k++) { ?>
				<div class="itemCourse">
					<p>
						Código - Grupo 40
						<br><br>
						Fundamentos De Organización De Computadoras
						<br><br>
						ADRIANA ALVAREZ FIGUEROA 
						<!-- <?= $counter ?> -->
					</p>
				</div>
			<?php $counter += 1; } ?>						
		</div>
	<?php } ?>
</div>
<?php } ?>