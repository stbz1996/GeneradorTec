
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
var doc = new jsPDF();

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

$(".next").click(function(){

	var areActivitiesIncorrect;	

	//Adding text for form
	if($(this).attr("id") == 'next-workload')addWorkloadText();
	if($(this).attr("id") == 'next-activity') 
	{
		areActivitiesIncorrect = verifyActivities();
		if(areActivitiesIncorrect)return false;
		addActivitiesText();
	}
	if($(this).attr("id") == 'next-courses')addCoursesText();

	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	next_fs = $(this).parent().next();
	
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
});


$(".previous").click(function(){
	if(animating) return false;
	animating = true;
	
	current_fs = $(this).parent();
	previous_fs = $(this).parent().prev();
	
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
			current_fs.css({'left': left});
			previous_fs.css({'transform': 'scale('+scale+')', 'opacity': opacity});
		}, 
		duration: 800, 
		complete: function(){
			current_fs.hide();
			animating = false;
		}, 
		//this comes from the custom easing plugin
		easing: 'easeInOutBack'
	});
});


$(document).on('click', '.btn_add', function(){
	count_activities ++;
	$('#dynamic_field').append('<tr id="row'+count_activities+
		'"><td><input type="text" name="activityDescription[]" maxlength="100" id="descriptionActivity" placeholder="Ingrese actividad" /></td><td><input type="number" name="workPorcent[]" min="0" max="100" value="0" class="textnum"></td><td><input type="button" name="remove" id="'+
		count_activities+'" class="btn_remove action-button" value="Eliminar" /></td></tr>');

});

$(document).on('click', '.btn_remove', function(){
	var button_id = $(this).attr("id");
	$("#row"+button_id+"").remove();
	count_activities --;
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
			priority+'"/></td>');
		$("#select-"+idCheck+"").prop('disabled', 'disabled');
	}
	else
	{
		$("#id-"+idCheck+"").remove();
		$("#priority-"+idCheck+"").remove();
		$("#select-"+idCheck+"").prop('disabled', false);
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

	//Get data from view
	var areActivitiesIncorrect;
	areActivitiesIncorrect = verifyActivities();

	if(areActivitiesIncorrect)
	{
		return false;
	}
	var workloadSelect = document.getElementById("workload_options");
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
			var id = schedules[i].id.split("-")[1];
			id = parseInt(id, 10);
			newSchedules.push(id);
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
		newPriorities.push(priorities[i].value);
	}

	$.ajax({
		url: '../Form_Controller/getDataFromView',
		type: "POST",
		data:{
			saveState: saveState,
			workload: workloadValue,
			activitiesDescription: JSON.stringify(newActivitiesDescription),
			activitiesWorkPorcent: JSON.stringify(newActivitiesWorkPorcent),
			idCourses: JSON.stringify(newIdCourses),
			priorities: JSON.stringify(newPriorities),
			schedules: JSON.stringify(newSchedules)
		},
		success: function(){
			doc.fromHTML($('#content').html(), 15, 15, {
				'width': 170,
				'elementHandlers': specialElementHandlers
			});
			doc.save('formulario.pdf');
			swal('Listo', 'Sus datos han sido guardados', 'success');
		},
		error: function ()
        {
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
	$('#div-workload').append('<h4> Carga de trabajo: '+workloadValue+'%</h4>');
}

function addActivitiesText()
{
	var activitiesDescription = $('input[name^="activityDescription"]');
	var activitiesWorkPorcent = $('input[name^="workPorcent"]');
	$('#div-activities').empty();
	$('#div-activities').append("<h4>Actividades</h4>");
	for(i = 0; i < activitiesDescription.length; i++)
	{
		$('#div-activities').append('<h5>'+activitiesDescription[i].value+': ' +activitiesWorkPorcent[i].value+ '</h5>');
	}
}

function addCoursesText()
{
	var idCourses = $('input[name^="idCourses"]');
	var priorities = $('input[name^="priorities"]');
	$('#div-courses').empty();
	$('#div-courses').append("<h4>Cursos</h4>");
	for(i = 0; i < idCourses.length; i++)
	{
		var idCourse = idCourses[i].id.split("-")[1];
		var code = $("#row-"+idCourse+" td:nth-child(2)").text();
		var name = $("#row-"+idCourse+" td:nth-child(3)").text();
		var priority = priorities[i].value;
		$('#div-courses').append('<h5>'+code+'\t' +name+'\t, prioridad: '+priority+'</h5>');
		//$("#element td:nth-child(2)").text('ChangedText');

	}
}