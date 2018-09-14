
//jQuery time
var current_fs, next_fs, previous_fs; //fieldsets
var left, opacity, scale; //fieldset properties which we will animate
var animating; //flag to prevent quick multi-click glitches
var count_activities = document.getElementById("dynamic_field").getElementsByTagName("tbody")[0].getElementsByTagName("tr").length;

$(".next").click(function(){
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
		$("#row-"+idCheck+"").append('<td id="id-'+idCheck+'"><input type="hidden" name="idCourses[]" value="'+
			idCourse+'"/></td><td id="priority-'+idCheck+'"><input type="hidden" name="priorities[]" value="'+
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
/*
$(".add").click(function(){
	$('#dynamic_field').append('<tr><td><input type="text" name="name[]" id="name" placeholder="Ingrese actividad" /></td><td><input type="button" name="add" id="add" value="+" /></td></tr>');

});*/




// We have to send or save the form here  
$(".submit").click(function(){
	return false;
});


