
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
var doc = new jsPDF('l', 'mm', [297, 210]);
var days = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
var totalDays = 6;
var allFieldsets = $("fieldset").toArray();
var allListElement = $("li").toArray();

var specialElementHandlers = {
	'#editor': function(element, renderer){
		return true;
	}
}

var count_activities = 0;
if(document.getElementById("dynamic_field").rows.length)
{
	count_activities = document.getElementById("dynamic_field").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;
}

$("li").click(function(){

	source = $('.active').toArray().length-1;
	destination = $(this).attr('id')-1;
	fieldset = $(this).parent('ul').siblings('fieldset');

	if($(this).attr('id') == 6)
	{
		//Add text to pdf
		addWorkloadText();
		addActivitiesText();
		addCoursesText();
		addSchedulesText();
	}

	if(source < destination)
	{
		for(i = source; i < destination; i++)
		{
			$("#progressbar li").eq(i).addClass("active");
		}
		nextAction(fieldset.eq(source), fieldset.eq(destination), false);
	}
	else if(source > destination)
	{
		for(i = source; i > destination; i--)
		{
			$("#progressbar li").eq(i).removeClass("active");
		}
		prevAction(fieldset.eq(source), fieldset.eq(destination));
	}
	
	/*source = $(".active").toArray().length-1;
	destination = $(this).attr('id')-1;

	fieldset = $(this).parent('ul').siblings('fieldset');
	for(i = source+1; i < destination)
	nextAction(fieldset.eq(source), fieldset.eq(destination));*/


	
});

$(".next").click(function(){
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();

	nextAction(current_fs, next_fs, $(this).attr('id'));
});

function nextAction(cur, next, idNext){

	var areActivitiesIncorrect;	

	//Adding text for form
	if(idNext)
	{
		if(idNext == 'next-workload')addWorkloadText();
		if(idNext == 'next-activity') 
		{
			areActivitiesIncorrect = verifyActivities();
			if(areActivitiesIncorrect)return false;
			addActivitiesText();
		}
		if(idNext == 'next-courses')addCoursesText();
		if(idNext == 'next-schedules')addSchedulesText();
	}

	if(animating) return false;
	animating = true;
	
	current_fs = cur;
	next_fs = next;
	//activate next step on progressbar using the index of next_fs
	$("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");
	
	//show the next fieldset
	next_fs.show(); 
	
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale current_fs down to 80%
			scale = 1 - (1 - now) * 0.2;
			//2. bring next_fs from the right(50%)
			left = (now * 50)+"%";
			//3. increase opacity of next_fs to 1 as it moves in
			opacity = 1 - now;
			current_fs.css({
        'transform': 'scale('+scale+')',
        'position': 'absolute'
      });
			next_fs.css({'left': left, 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
}


$(".previous").click(function(){
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();

	prevAction(current_fs, previous_fs);
});

function prevAction(cur, prev){
	if(animating) return false;
	animating = true;
	
	current_fs = cur;
	previous_fs = prev;
	
	//de-activate current step on progressbar
	$("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");
	
	//show the previous fieldset
	previous_fs.show(); 
	//hide the current fieldset with style
	current_fs.animate({opacity: 0}, {
		step: function(now, mx) {
			//as the opacity of current_fs reduces to 0 - stored in "now"
			//1. scale previous_fs from 80% to 100%
			scale = 0.8 + (1 - now) * 0.2;
			//2. take current_fs to the right(50%) - from 0%
			left = ((1-now) * 50)+"%";
			//3. increase opacity of previous_fs to 1 as it moves in
			opacity = 1 - now;
			
			/*if(previous_fs.attr('position') === 'relative')
			{
				alert('hola');
				//previous_fs.css({'display': 'none', 'left': '50%', 'opacity': 1});
			}*/

			current_fs.css({'left': left});

			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});

			if(current_fs.css('left') != '0px')
			{
				previous_fs.css({'left': '0%'});
			}
			current_fs.hide();

			
		}, 
		duration: 800, 
		complete: function(){

			//alert(previous_fs.css('left')); 
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
}


$(document).on('click', '.btn_add', function(){
	count_activities ++;
	$('#dynamic_field').append('<tr id="row'+count_activities+
		'"><td><input type="text" name="activityDescription[]" maxlength="100" id="descriptionActivity" placeholder="Ingrese actividad" /></td><td><input type="number" name="workPorcent[]" min="0" max="100" value="0" class="textnum"></td><td> <input type="button" name="remove" id="'+
		count_activities+'" class="btn_remove action-button" value="Eliminar" /></td></tr>');
	document.getElementById("textActivities").removeAttribute("hidden"); 
});


$(document).on('click', '.btn_remove', function(){
	var button_id = $(this).attr("id");
	$("#row"+button_id+"").remove();
	count_activities --;
	if (($('#dynamic_field tr').length -1) == 0) 
	{
		document.getElementById("textActivities").setAttribute("hidden", "hidden"); 

	}
});

$(document).on('click', '.cbox', function(){
	var nameCheck = $(this).attr("id");
	var idCheck = nameCheck.split("-")[1];
	if($(this).is(':checked'))
	{
		var idCourse = $("#course-"+idCheck+"").attr("value");
		var priority = $("#select-"+idCheck+"").val();
		$("#row-"+idCheck+"").append('<td id="id-'+idCheck+'"><input type="hidden" id="idCourse-'+idCheck+'" name="idCourses[]" value="'+
			idCourse+'"/></td><td id="prior-'+idCheck+'"><input type="hidden" id="priority-'+idCheck+'" name="priorities[]" value="'+
			idCheck+'"/></td>');
		$("#select-"+idCheck+"").prop('disabled', false);
	}
	else
	{
		$("#id-"+idCheck+"").remove();
		$("#priority-"+idCheck+"").remove();
		$("#select-"+idCheck+"").prop('disabled', 'disabled');
	}
});

// We have to send or save the form here  
$(".submit").click(function(){
	return false;
});


function verifyActivities(){
	
	var activitiesDescription = $('input[name^="activityDescription"]');
	var activitiesWorkPorcent = $('input[name^="workPorcent"]');
	var workloadSelect = document.getElementById("workload_options");
	var workloadValue = workloadSelect.options[workloadSelect.selectedIndex].value;
	var totalWork = 0;

	for(i = 0; i < activitiesDescription.length; i++)
	{
		var description = activitiesDescription[i].value;
		var workPorcent = activitiesWorkPorcent[i].value;

		if(description === "")
		{
			swal('Lo sentimos', 'Una o varias actividades no poseen descripción', 'error');
			return true;
		}

		if(workPorcent < 0 || workPorcent === "")
		{
			swal('Lo sentimos', 'Uno o varios porcentajes no son válidos', 'error');
			return true;
		}

		totalWork += parseInt(workPorcent, 10);
	}
	if(workloadValue < totalWork)
	{
		swal('Lo sentimos', 'Actividades sobrepasan la carga de trabajo asignado', 'error');
		return true;
	}
	return false;
}

$('.submit-save').click(function(){

	areActivitiesIncorrect = verifyActivities();
	if(areActivitiesIncorrect)
	{
		return false;
	}

	var workloadSelect = document.getElementById("workload_options");
	var workloadExtension = $('.cbox_extension').prop('checked') ? 1 : 0;
	var activitiesDescription = $('input[name^="activityDescription"]');
	var activitiesWorkPorcent = $('input[name^="workPorcent"]');
	var idCourses = $('input[name^="idCourses"]');
	var priorities = $('input[name^="priorities"]');
	var schedules = $('input[name^="Inp-"]');

	var workloadValue = workloadSelect.options[workloadSelect.selectedIndex].value;
	var newActivitiesDescription = [];
	var newActivitiesWorkPorcent = [];
	var newIdCourses = [];
	var newPriorities = [];
	var newSchedules = [];
	var saveState = 0;

	for(i = 0; i < schedules.length; i++)
	{
		if(schedules[i].value == 1){
			/*var id = schedules[i].id.split("-")[1];
			id = parseInt(id, 10);*/

			var id = "Id"+schedules[i].id;

			var value = document.getElementById(id).value;
			newSchedules.push(value);
		}
	}

	if($(this).val() == "Enviar")
	{
		var areCoursesAssigned;
		var areSchedulesAssigned;

		areCoursesAssigned = verifyCourses(workloadValue, idCourses);
		areSchedulesAssigned = verifySchedules(newSchedules);
		if(areCoursesAssigned || areSchedulesAssigned)
		{
			return false;
		}
		saveState = 1;
	}

	for(i = 0; i < activitiesDescription.length; i++){
		newActivitiesDescription.push(activitiesDescription[i].value);
		newActivitiesWorkPorcent.push(activitiesWorkPorcent[i].value);
	}

	for(i = 0; i < idCourses.length; i++)
	{
		newIdCourses.push(idCourses[i].value);

		idCourse = idCourses[i].id.split("-")[1];
		
		prioritySelect = document.getElementById("select-"+idCourse);
		priorityValue = prioritySelect.options[prioritySelect.selectedIndex].value;
		newPriorities.push(priorityValue);
	}

	$.ajax({
		url: '../Form_Controller/getDataFromView',
		type: "POST",
		data:{
			saveState: saveState,
			workload: workloadValue,
			extension: workloadExtension,
			activitiesDescription: JSON.stringify(newActivitiesDescription),
			activitiesWorkPorcent: JSON.stringify(newActivitiesWorkPorcent),
			idCourses: JSON.stringify(newIdCourses),
			priorities: JSON.stringify(newPriorities),
			schedules: JSON.stringify(newSchedules)
		},
		beforeSend: function(){ 
			document.getElementById("msform").style.opacity = 0.5;
			document.getElementById("loader").style.display = "block";
		},

		success: function(){
			if(saveState)
			{
				doc.fromHTML($('#content').html(), 15, 15, {
								'width': 170,
								'elementHandlers': specialElementHandlers
							});
				doc.save('formulario.pdf');
			}
			document.getElementById("loader").style.display = "none";
			document.getElementById("msform").style.opacity = 1;
			swal('Listo', 'Sus datos han sido guardados', 'success');
		},
		error: function ()
        {
        	document.getElementById("loader").style.display = "none";
			document.getElementById("msform").style.opacity = 1;
            swal('Lo sentimos', 'No sé pudieron guardar los datos correctamente', 'error');
        }
	});
});

function verifyCourses(workload, courses)
{
	var minimumCourses = workload / 25;
	if(minimumCourses > courses.length)
	{
		swal('Lo sentimos', 'Cantidad de cursos es menor a la carga de trabajo', 'error');
		return true;
	}
	return false;
}

function verifySchedules(newSchedules)
{
	if(!newSchedules.length)
	{
		swal('Lo sentimos', 'No asignó horarios', 'error');
		return true;
	}
	return false;
}

function addWorkloadText()
{
	var workloadSelect = document.getElementById("workload_options");
	var workloadValue = workloadSelect.options[workloadSelect.selectedIndex].value;
	$('#div-workload').empty();
	$('#div-workload').append('<h4> Carga de trabajo seleccionada: '+workloadValue+'%</h4>');
}

function addActivitiesText()
{
	var activitiesDescription = $('input[name^="activityDescription"]');
	var activitiesWorkPorcent = $('input[name^="workPorcent"]');
	$('#div-activities').empty();
	$('#div-activities').append("<h4>Actividades seleccionadas: </h4>");
	for(i = 0; i < activitiesDescription.length; i++)
	{
		$('#div-activities').append('<div> - '+activitiesDescription[i].value+' con un ' +activitiesWorkPorcent[i].value+ '%</div>');
	}
}

function addCoursesText()
{
	var idCourses = $('input[name^="idCourses"]');
	//var priorities = $('input[name^="priorities"]');
	$('#div-courses').empty();
	$('#div-courses').append("<h4>Cursos seleccionados:</h4>");
	for(i = 0; i < idCourses.length; i++)
	{
		var idCourse = idCourses[i].id.split("-")[1];
		var code = $("#div-code-"+idCourse).text();
		var name = $("#div-name-"+idCourse).text();
		prioritySelect = document.getElementById("select-"+idCourse);
		priorityValue = prioritySelect.options[prioritySelect.selectedIndex].value;
		$('#div-courses').append('<div> - '+code+'\t'+name+' con prioridad '+priorityValue+'</div>');
		//$("#element td:nth-child(2)").text('ChangedText');

	}
}

function addSchedulesText()
{
	var schedules = $('input[name^="Inp-"]');
	$('#div-schedules').empty();
	$('#div-schedules').append("<h4>Horarios seleccionados:</h4>");
	
	for(i = 0; i < schedules.length; i++)
	{
		if(schedules[i].value == 1){

			var id = schedules[i].id.split("-")[1];

			/* Get the hour of schedule*/
			var hour = document.getElementById('Description-Inp-'+id).value;
			
			/* Get the day of schedule*/
			id = parseInt(id, 10);
			var remainder = (id-1) % totalDays;
			var day = days[remainder];

			$('#div-schedules').append("<div> - "+day+ ": "+ hour + "</div>");
		}
	}
}