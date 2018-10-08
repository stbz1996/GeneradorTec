var idProfessor; //  is the id of the professor that is selected in the moment.
var nameProfessor; // This is the name of the professor that is selected in the moment.
var grayBackground = "#3385ff";
var whiteBackground = "#ffffff";
var yellowBackground = "#ffff4d";

var assigned = []; // Course - Professor.


/****************************************
 Get the work expect to complete and the assigned for the professor.
****************************************/
function getWork(div)
{
    var progressBar = div.childNodes[5].childNodes[1];
    var workPorcent = progressBar.getAttribute('aria-valuenow');
    var workLoad = progressBar.getAttribute('aria-valuemax');

    if (workPorcent == null || workPorcent == ""){
        workPorcent = 0;
    }

    if (workLoad == null || workLoad == ""){
        workLoad = 0;
    }

    workPorcent = parseInt(workPorcent); // Parse the result.
    workLoad = parseInt(workLoad); // Parse the result.

    var work = [workLoad, workPorcent];
    return work;
}

/****************************************
 This function initialize the divs... Load the information asociated with the professors..
****************************************/
function loadProfessors(divProfessors)
{
    var length = divProfessors.length;
    for (var i = 0; i < length; i++)
    {
        var id = divProfessors[i].getAttribute('data-value'); // get the id.
        var title = divProfessors[i].childNodes[2].previousSibling.innerHTML; // Name of the teacher.
        var text = divProfessors[i].childNodes[3]; // Porcent of the work
        var progressBar = divProfessors[i].childNodes[5].childNodes[1];
        var textPorcentWork = divProfessors[i].childNodes[5].childNodes[1].childNodes[1]; // Text
        var posRelative = 0;
        var work = getWork(divProfessors[i]);

        posRelative = getRelativePosition(work[1], work[0]);

        progressBar.style.width = posRelative.toString() + "%";
        textPorcentWork.innerHTML = posRelative.toString();
    }
}


/****************************************
- Load the information relevant... the progress bar, the text and the load in the beginning.
****************************************/
$(document).ready( function () {

    document.getElementById("loader").style.display = "none";
    var divProfessors = $(".professorDiv").toArray(); // Get all the divs of the program.
    
    loadProfessors(divProfessors); // Load all the information of the professors.
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
Get the respective color of the priorities
************************************************/
function getPriorityColor(priority)
{
    var priorityColor = yellowBackground;

    if (priority == "A")
    {
        priorityColor = "#ff4d4d"; // Red
    }
    else if(priority == "B")
    {
        priorityColor = "#ff8000"; // Orange
    }
    else
    {
        priorityColor = "#ffff1a";  // Yellow
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
        divs[i].style.opacity = value; // Make opaque 0.2
        setForced(divs[i], "0");
    }
}

/************************************************
The courses that have been selected they are going to continue disabled.
The other are enable.
************************************************/
function desopaqueCourses(value)
{
    var divs = $(".coursesDiv").toArray();
    var length = divs.length;

    // Look for all professors id assigned to respective div.
    for(var i = 0; i < length; i++)
    {
        var state = divs[i].childNodes[7].value;

        if (state == "1"){
            divs[i].style.opacity = value; // Make clear ...
        }
    }
}

function setForced(div, pValue)
{
    var state = div.childNodes[6];
    state.value = pValue;
}

/************************************************
Load the information about historic about the courses.
************************************************/
function loadInformation(idProfessor, idCourse, priority)
{
    var priorityColor = getPriorityColor(priority);
    becomeDivYellow(idCourse, priorityColor); // paint the actual course.
    var div = lookDivCourses(idCourse);
    setForced(div, "1");
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
            desopaqueCourses(1);

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

/*********************************************
Desactivate the div of the professor and mark that the professor is full of work.
*********************************************/
function desactivateDivProfessor(divProfessor, progressBar, stateFinished)
{
    if (stateFinished)
    {
        progressBar.className = "progress-bar progress-bar-danger"; // You have extra work.
    }else{
        progressBar.className = "progress-bar progress-bar-success"; // You have your assigned work.
    }

    divProfessor.style.opacity = 0.6; // Make opacity
    divProfessor.removeAttribute('onclick'); // The professor doesn't have an event attached.
}


/*********************************************
Edit information about the professor.
*********************************************/
function increaseLoadProfessor(idProfessor)
{
    var divProfessor = lookDivProfessor(idProfessor);
    var progressBar = divProfessor.childNodes[5].childNodes[1]; // Progress Bar
    var textPorcentWork = divProfessor.childNodes[5].childNodes[1].childNodes[1]; // Text of load.
    var work = getWork(divProfessor); // Get the workAssigned and workPendient
    var workPorcent = work[1] + 25; // new workPorcent.
    var posRelative;

    if (workPorcent > 100 || workPorcent > work[0])
    {
        if (workPorcent > 100) 
        {
            workPorcent = 100;
        }
        desactivateDivProfessor(divProfessor, progressBar, 1); // Bar red.
    }
    else if(workPorcent == 100 || workPorcent == work[0])
    {
        desactivateDivProfessor(divProfessor, progressBar, 0); // Bar green
    }
    
    posRelative = getRelativePosition(workPorcent, work[0]); // Get the porcentage relate to the actual load.
    progressBar.setAttribute('aria-valuenow', workPorcent);
    progressBar.style.width = posRelative.toString() + "%"; // Set the new load.
    textPorcentWork.innerHTML = workPorcent.toString(); // set the data
}

/*********************************************
Registered professor and courses in the database
*********************************************/
function assignCourse(idCourse, idProf, nameCourse, nameProf)
{
    var divCourse = lookDivCourses(idCourse);
    var button = divCourse.childNodes[5];
    var state = divCourse.childNodes[7];
    var groupAssigned = divCourse.childNodes[5].childNodes[1].childNodes[1].childNodes[3].childNodes[1];
    var numGroup = groupAssigned.value;
    var idGroup = groupAssigned.value;

    /* Remove the group that I choose.*/
    for(var i=0; i < groupAssigned.length; i++)
    {
        if (groupAssigned[i].value == groupAssigned.value)
        {
            numGroup = groupAssigned[i].text;
            groupAssigned.removeChild(groupAssigned[i]);
            break;
        }
    }

    /* If there's no more groups to assign. */
    if (groupAssigned.length <= 1)
    {
        button.style.display = "none"; // Hide the button
        divCourse.style.opacity = 0.2; // Make dark.
        state.value = "0"; // The state is disabled.
    } 

    /* Creo el parrafo. */
    var par = document.createElement("P");                        // Create a <p> node
    var text = document.createTextNode("Asignado a " + nameProf + " - Group # " + numGroup);
    par.appendChild(text); 

    var text = divCourse.childNodes[3]; // Get the div of the p values.

    console.log(groupAssigned.length);
    console.log(text.childNodes[1].textContent);
    if((groupAssigned.length >= 6) && (text.childNodes[1].textContent = "No ha sido asignado"))
    {
        text.removeChild(text.childNodes[1]); // Remove "no ha sido asignado"
    }

    text.appendChild(par); // Add the assigned.

    increaseLoadProfessor(idProf); // Assign the course.

    var courseRegistered = new Object();
    courseRegistered.idCourse = idCourse;
    courseRegistered.idProfessor = idProf;
    courseRegistered.nameCourse = nameCourse;
    courseRegistered.nameProfessor = nameProf;
    courseRegistered.idGroup = idGroup;
    courseRegistered.nameGroup = numGroup;

    assigned.push(courseRegistered); // Registered the course
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
- Review if the professor could assign courses.
****************************************/
function lookIfProfAssign(idProf, stateForced)
{
    var divProfessor = lookDivProfessor(idProf);
    var work = getWork(divProfessor);
    var workLoad = work[0];
    var newWorkPorcent = work[1] + 25;
    var state = false;

    if (work[1] >= workLoad){
        alert("Lo siento, el profesor tiene más carga de la solicitada.");
        return false;
    }

    if (workLoad < newWorkPorcent)
    {
        state = confirm("Sobrepasará el máximo de la carga del profesor. ¿Está seguro?");

        // The user doesn't want to save.
        if (!state){
            return false;
        }
    }
    // Forced the assignment of the course
    if (stateForced == "0")
    {
        var message = "El curso no fue seleccionado previamente por el profesor. ";
        var question = "¿Desea forzar la asignación del curso?"; 
        state = confirm(message + question);

        if (!state){
            return false;
        }
    }

    return true;
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

    if (divToChoose){
        divToChoose.style.background = priorityColor;
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
- Action realized when I select a course to registered.
****************************************/
function selectCourse(divSelected)
{
    var idCourse;
    var nameCourse;
    var stateForced = divSelected.childNodes[7].value; // Input state...
    var groupAssigned = divSelected.childNodes[5].childNodes[1].childNodes[1].childNodes[3].childNodes[1];
    var group = groupAssigned.value;

    if (idProfessor == null || idProfessor <= 0){
        alert("No ha seleccionado ningún profesor para asignar el curso");
        return;
    }

    if (group == "Grupos")
    {
        alert("No ha seleccionado ningún grupo para asignar");
        return;
    }

    idCourse = divSelected.getAttribute('data-value');
    nameCourse = divSelected.childNodes[2].previousSibling.innerHTML;

    // Review if the workLoad of the professor is correct.
    var state = lookIfProfAssign(idProfessor, stateForced);

    if (state)
    {
        // Register the course and professor.
        assignCourse(idCourse, idProfessor, nameCourse, nameProfessor);
    }
}


/****************************************
- Action realized when a professor is touched...
****************************************/
function selectProfessor(divSelected){

    var idSelected = divSelected.getAttribute('data-value');
    var nameSelected = divSelected.childNodes[2].previousSibling.innerHTML;
 
    if (idProfessor == null || idProfessor <= 0)
    {
        idProfessor = idSelected;
        nameProfessor = nameSelected;
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
            nameProfessor = nameSelected;
        }
    }

    becomeDivBlack(divSelected); // Become the actual div in black...

    // Call the courses that the user has selected.
    deselectCourses();
    loadCoursesSelect(idProfessor);
}


function saveAssigned()
{
    for (var i = 0; i < assigned.length; i++)
    {
        console.log("Elemento: " + assigned[i].idCourse + " - " + assigned[i].idProfessor + " - " + 
            assigned[i].nameCourse + " - " + assigned[i].nameProfessor);
    }
}