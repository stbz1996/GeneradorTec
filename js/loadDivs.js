var idProfessor; // This is the id of the professor that is selected in the moment.
var grayBackground = "#999966";
var whiteBackground = "#ffffff";
var yellowBackground = "#ffff4d";

/****************************************
 This function initialize the divs... Load the information asociated with the teachers..
****************************************/
function loadProfessors(divProfessors)
{
    var length = divProfessors.length;
    for (var i = 0; i < length; i++)
    {
        var id = divProfessors[i].getAttribute('data-value'); // get the id.
        var title = divProfessors[i].childNodes[2];
        var text = divProfessors[i].childNodes[3];
        var progressBar = divProfessors[i].childNodes[5].childNodes[1];
        var workPorcent = progressBar.getAttribute('aria-valuenow');
        var workLoad = progressBar.getAttribute('aria-valuemax');
        var textPorcentWork = divProfessors[i].childNodes[5].childNodes[1].childNodes[1]; // Text
        var posRelative = 0;

        if (workPorcent == null || workPorcent == ""){
            workPorcent = 0;
        }

        if (workLoad == null || workLoad == ""){
            workLoad = 0;
        }

        posRelative = getRelativePosition(workPorcent, workLoad);

        progressBar.style.width = posRelative.toString() + "%";
        textPorcentWork.innerHTML = posRelative.toString();
    }
}


/* This function initialize the divs... Load the information asociated with the teachers.. */
/****************************************
- Load the information relevant... the progress bar, the text and the load in the beginning.
****************************************/
$(document).ready( function () {

    document.getElementById("loader").style.display = "none";
    var divProfessors = $(".professorDiv").toArray(); // Get all the divs of the program.
    
    loadProfessors(divProfessors); // Load all the information of the professors.

    // loadCourses ... only if Randy considered necessary.
} );

/****************************************
- Show the errors in the execution of a javascript operation.
****************************************/
function showErrors(jqXHR, textStatus, errorThrown)
{
    if (jqXHR.status === 0) 
    {
        alert('Not connect: Verify Network.');
    } 
    else if (jqXHR.status == 404) 
    {
        alert('Requested page not found [404]');
    } 
    else if (jqXHR.status == 500) 
    {
        alert('Internal Server Error [500].');
    } 
    else if (textStatus === 'parsererror')
    {
        alert('Requested JSON parse failed.');
    } 
    else if (textStatus === 'timeout') 
    {
        alert('Time out error.');
    } 
    else if (textStatus === 'abort') 
    {
        alert('Ajax request aborted.');
    } 
    else
    {
        alert('Uncaught Error: ' + jqXHR.responseText);
    }
}

/************************************************
Get the priority color.
************************************************/
function getPriorityColor(priority)
{
    var priorityColor = yellowBackground;

    if (priority == "A")
    {
        priorityColor = "#e6e600"; // Yellow dark
    }
    else if(priority == "B")
    {
        priorityColor = "#ffff1a";
    }
    else
    {
        priorityColor = "#ffff4d";  
    }

    return priorityColor;
}

/************************************************
Make the courses opaque.
************************************************/
function opaqueCourses(value)
{
    var divs = $(".coursesDiv").toArray();
    var length = divs.length;

    // Look for all professors id assigned to respective div.
    for(var i = 0; i < length; i++)
    {
        divs[i].style.opacity = value;
    }
}

/************************************************
Load the information about historic about the courses.
************************************************/
function loadInformation(idProfessor, idCourse, priority)
{
    var priorityColor = getPriorityColor(priority);
    becomeDivYellow(idCourse, priorityColor); // paint the actual course.

    // Get all the information related to the professor and course..
    // historic information... like how many times the professor has given the course.
}


/****************************************
- Get all the courses selected by a professor.
****************************************/
function loadCoursesSelect(idProfessor)
{
    //Ajax Load data from ajax
    $.ajax({
        url : base_url + "Administrator_controller/loadSelectCourses/" + idProfessor,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
             document.getElementById("loader").style.display = "block";
             opaqueCourses(0.2);
        },
        success: function(data)
        {
            document.getElementById("loader").style.display = "none";
            opaqueCourses(1);
            for(var i = 0; i < data.length; i++)
            {
                var idCourse = data[i].idCourse;
                var priority = data[i].priority;
                loadInformation(idProfessor, idCourse, priority);
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}


/****************************************
- Look for all the div in the system. If someone has the same id... returns.
****************************************/
function lookDivProfessor(idDivSource)
{
    var divs = $(".professorDiv").toArray();
    var length = divs.length;

    // Look for all professors id assigned to respective div.
    for(var i = 0; i < length; i++)
    {
        var idDivToLook = divs[i].getAttribute('data-value');

        // If they are the same, return the div.
        if (idDivSource == idDivToLook) 
        {
            return divs[i];
        }
    }

    return null;
}


/****************************************
- Look for all the div in the system. If someone has the same id... returns.
****************************************/
function lookDivCourses(idDivSource)
{
    var divs = $(".coursesDiv").toArray();
    var length = divs.length;

    // Look for all professors id assigned to respective div.
    for(var i = 0; i < length; i++)
    {
        var idDivToLook = divs[i].getAttribute('data-value');

        // If they are the same, return the div.
        if (idDivSource == idDivToLook) 
        {
            return divs[i];
        }
    }

    return null;
}

/****************************************
- Get the porcentage complete of a professor.
****************************************/
function getRelativePosition(workPorcent, workLoad)
{
	var posRelative = 0;

	if (workLoad > 0)
	{
        /* (100 / x) <-> (workLoad / workPorcent) */
		posRelative = (100 * workPorcent) / workLoad;
    	posRelative = Math.trunc(posRelative); // Int

    	// If professor has a lot of works to do
		if (posRelative > 100){
			posRelative = 100;
		}
	}
	
	return posRelative;
}

/****************************************
- Become a div white when the Div is deselect.
****************************************/
function becomeDivWhite(idProfessorDeselect)
{
    var divToDeselect = lookDivProfessor(idProfessorDeselect); // Get the specific Div.

    if (divToDeselect){
        divToDeselect.style.background = whiteBackground;
    }else{
        console.log("There is a problem...");
    }
}

/****************************************
- Become a div gray when is selected.
****************************************/
function becomeDivBlack(divSelected){
    divSelected.style.background = grayBackground;
}


/****************************************
- Become a div to normal color.
****************************************/
function becomeDivNormal(divSelected){
    divSelected.style.background = whiteBackground;
}

/****************************************
- Become a div white when the Div is deselect.
****************************************/
function becomeDivYellow(idCoursePreferred, priorityColor)
{
    var divToChoose = lookDivCourses(idCoursePreferred); // Get the specific Div.

    console.log(priorityColor);

    if (divToChoose){
        divToChoose.style.background = priorityColor;
    }else{
        console.log("There is a problem...");
    }
}

/****************************************
- Deselect all the courses that could be recommended.
****************************************/
function deselectCourses()
{
    var divCourses = $(".coursesDiv").toArray(); // Get all the divs of the program.
    var length = divCourses.length;
    for (var i = 0; i < length; i++)
    {
        var course = divCourses[i];
        becomeDivNormal(course);
    }
}


/****************************************
- Action realized when a professor is touched...
****************************************/
function selectProfessor(divSelected){

    var idSelected = divSelected.getAttribute('data-value');

    if (idProfessor == null || idProfessor <= 0)
    {
        idProfessor = idSelected;
    }else{

        becomeDivWhite(idProfessor); // Become the div in white..
        // If the professor was asigned previously... just don't convert.
        if (idProfessor == idSelected)
        {
            idProfessor = -1; 
            deselectCourses();
            return; // The div doesn't have to become black.
        }else{
            idProfessor = idSelected;
        }
    }

    becomeDivBlack(divSelected); // Become the actual div in black...

    // Call the courses that the user has selected.
    deselectCourses();
    loadCoursesSelect(idProfessor);
}