<!DOCTYPE html>
<html lang="en">

<head>
	<link rel="stylesheet" href="estilos.css" />
	
	<!-- 
	That functions update the value of the hidden elements that we are
	going to sent to the controller. 1 means an active space, 0 means
	inactive space. 
	 -->
	<script>
		function changeState(id, idDiv) {
			if (document.getElementById(id).value == 1) {
				document.getElementById(id).value = 0;
				document.getElementById(idDiv).style.background="gray";
				document.getElementById(idDiv).style.color="gray";
			}
			else{
				document.getElementById(id).value = 1;
				document.getElementById(idDiv).style.background="yellow";
				document.getElementById(idDiv).style.color="yellow";
			}
			//alert(document.getElementById(id).value)
		}
	</script>	
</head>

<body>


<div class="mainContainer">
	<div class="fileone">
		<div class="itemf1"> Hora </div>
		<div class="itemf1"> Lunes </div>
		<div class="itemf1"> Martes </div>
		<div class="itemf1"> Miercoles </div>
		<div class="itemf1"> Jueves </div>
		<div class="itemf1"> Viernes </div>
		<div class="itemf1"> Sabado </div>
	</div>

<?php 
for ($i=0; $i < 10; $i++) { ?>
	<div class="fileone">
		<div class="itemCol1"  > <?= $i ?> </div>
			<?php 
			$Did = 'D-'.$i.'-'.'0';  
			$Mid = 'M-'.$i.'-'.'0';
		?>
		<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
			<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
		</div>

		<?php 
			$Did = 'D-'.$i.'-'.'1';  
			$Mid = 'M-'.$i.'-'.'1';
		?>
		<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
			<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
		</div>

		<?php 
			$Did = 'D-'.$i.'-'.'2';  
			$Mid = 'M-'.$i.'-'.'2';
		?>
		<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
			<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
		</div>

		<?php 
			$Did = 'D-'.$i.'-'.'3';  
			$Mid = 'M-'.$i.'-'.'3';
		?>
		<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
			<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
		</div>
		<?php 
			$Did = 'D-'.$i.'-'.'4';  
			$Mid = 'M-'.$i.'-'.'4';
		?>
		<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
			<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
		</div>

		<?php 
			$Did = 'D-'.$i.'-'.'5';  
			$Mid = 'M-'.$i.'-'.'5';
		?>
		<div id="<?= $Did ?>" onclick="changeState('<?= $Mid ?>', '<?= $Did ?>')" class="item">.
			<input class="hiddenItem" id="<?= $Mid ?>" value="0" type="hidden" name="<?= $Mid  ?>">
		</div>
	</div>
<?php } ?>
</div>





</body>
</html>