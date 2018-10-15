var idProfessor; //  is the id of the professor that is selected in the moment.
var nameProfessor; // This is the name of the professor that is selected in the moment.
var idPeriod;
var grayBackground = "#3385ff";
var whiteBackground = "#ffffff";
var yellowBackground = "#ffff4d";

var assigned = []; // Course - Professor.

/****************************************
- Load the information relevant... the progress bar, the text and the load in the beginning.
****************************************/
$(document).ready( function () {
    document.getElementById("loader").style.display = "none";

    var possibleURL = base_url + "Administrator_controller/AssignmentCourses";

    if (document.URL == possibleURL)
    {
        showModalPeriodForm(); // Show the modal of periods.
    }
});

/****************************************
- Load the periods modal.
****************************************/
function showModalPeriodForm()
{
    $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
    $('.modal-title').text('Seleccionar Período'); // Set title to Bootstrap modal title
}

/****************************************
- Select the period that you want to upload the forms.
****************************************/
function choosePeriod()
{
    period = $('#selectPeriod option:selected').val();

    /* If the period is not selected. */
    if(period == '0' || period == '' || period == 'undefined' || period == null )
    {
        swal({title: "Error", 
            text: "No se ha seleccionado ningún período", 
            icon: "error"});
        return;
    }

    idPeriod = period;

    // Load all the divs assigned to a period.
    verifyAssignedProfessors();
    loadBlocksProfessors(period);
}

/****************************************
Delete all the div assigned to a professor.
****************************************/
function verifyAssignedProfessors()
{
    var save;
    var div = $(".professorDiv").toArray();

    var template = $(".professorDiv").find("[data-value='']");

    if (div.length > 1)
    {
        div.forEach(function(element)
        {
            if (element.getAttribute("data-value") != '')
            {
                // Drop the element.
                element.parentNode.removeChild(element);
                // Desasignar todo....
            }
        });
    }
}

/****************************************
List the professors that are going to be upload...
****************************************/
function loadBlocksProfessors(idPeriod)
{
    var url = base_url + "Administrator_controller/loadFormProfessor/";
    $.ajax({
        url: url + idPeriod,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            document.getElementById("loader").style.display = "block";
            opaqueCourses(0.2);
        },

        success: function(professors)
        {
            // If there are not professors with forms.
            if (professors.length <= 0)
            {
                swal({title: "Error", 
                    text: "No hay profesores que hayan completado el formulario para ese período", 
                    icon: "error"});
            }
            else
            {
                // Create a div for each professor.
                professors.forEach(function(professor){
                    createDivProfessor(professor);
                });
            }

            document.getElementById("loader").style.display = "none";
            desopaqueCourses(1);
            $('#modal_form').modal('hide');
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/****************************************
Create the div to the professor via Javascript...
****************************************/
function createDivProfessor(professor)
{
    var professorName = professor.name + " " + professor.lastName;
    var textAssigned = "Solicitó un " + professor.workLoad + "% de carga";

    /* Get the div to be used as a template. */
    var divProfessor = document.getElementById("professorDiv");
    var newDivProfessor = divProfessor.cloneNode(true); // Clone. Or Copy.
    newDivProfessor.style.display = "block"; // Make visible.
    
    // Data-Value -> is the id of the div.
    newDivProfessor.setAttribute('data-value', professor.idProfessor);
    // Name the professor.
    newDivProfessor.childNodes[2].previousSibling.innerHTML = professorName;
    // The work porcent requested by the professor.
    newDivProfessor.childNodes[3].textContent = textAssigned;

    // Progress Bar ... 
    var progressBar = newDivProfessor.childNodes[5].childNodes[1];
    
    progressBar.setAttribute('aria-valuenow', professor.workPorcent); // Activities requested.
    progressBar.setAttribute('aria-valuemin', "0"); // 0 is the minus.
    progressBar.setAttribute('aria-valuemax', professor.workLoad); // Work expected to be completed.

    var posRelative = 0;
    // Get the work completed by the professor.
    var work = getWork(newDivProfessor);

    // Get the amount of work completed to this moment.
    posRelative = getRelativePosition(work[1], work[0]);

    progressBar.style.width = posRelative.toString() + "%"; // Represent in blue in the bar.
    newDivProfessor.childNodes[5].childNodes[1].childNodes[1].innerHTML = posRelative.toString();

    // Add to the leftScreen the new Div to assign.
    document.getElementById("leftScreen").appendChild(newDivProfessor);
}

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
        url : base_url + "Administrator_controller/loadSelectCourses/" + idProfessor + "/" + idPeriod,
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
Edit information about the professor.
*********************************************/
function decreaseLoadProfessor(idProfessor)
{
    var divProfessor = lookDivProfessor(idProfessor);
    var progressBar = divProfessor.childNodes[5].childNodes[1]; // Progress Bar
    var textPorcentWork = divProfessor.childNodes[5].childNodes[1].childNodes[1]; // Text of load.
    var work = getWork(divProfessor); // Get the workAssigned and workPendient
    var workPorcent = work[1] - 25; // new workPorcent.
    var posRelative;

    progressBar.className = "progress-bar progress-bar-info"; // You have your assigned work.
    // If the div of the professor is desactivated.
    if (divProfessor.style.opacity == 0.6)
    {
        divProfessor.style.opacity = 1; // Make visible
        divProfessor.setAttribute('onclick', 'selectProfessor(this)'); // The professor doesn't have an event attached.
    }
    
    posRelative = getRelativePosition(workPorcent, work[0]); // Get the porcentage relate to the actual load.
    progressBar.setAttribute('aria-valuenow', workPorcent);
    progressBar.style.width = posRelative.toString() + "%"; // Set the new load.
    textPorcentWork.innerHTML = workPorcent.toString(); // set the data
}

/*********************************************
Add a paragraph to a div.... so the div is completed.
*********************************************/
function addParagraphCourse(nameProf, numGroup, group)
{
    /* Create the paragraph. */
    var div = document.createElement("div");
    var par = document.createElement("P");                        // Create a <p> node
    var text = document.createTextNode("Asignado a " + nameProf + " - Grupo # " + numGroup);
    var btn = document.createElement("BUTTON");
    var option = document.createElement("i");

    btn.setAttribute('onclick','deleteParagraph(this.parentNode)'); // Action to the button.
    div.classList.add("div_inline"); // Inline the elements of the div.
    btn.classList.add("btn-danger"); // Add a red button.
    btn.style.float = "right"; // Put on the right side.
    option.classList.add("glyphicon");
    option.classList.add("glyphicon-trash");
    group.style.display = "none"; // Don't show the group to the user.

    par.appendChild(text); 
    btn.appendChild(option);
    div.appendChild(btn);
    div.appendChild(par);
    div.appendChild(group);

    return div;
}

function deleteParagraph(pDiv)
{
    var divCourse = pDiv.parentNode.parentNode; // Father of the divs.
    var button = divCourse.childNodes[5];
    var state = divCourse.childNodes[7];
    var groupAssigned = divCourse.childNodes[5].childNodes[1].childNodes[1].childNodes[3].childNodes[1];
    var numGroup = groupAssigned.value;
    var idGroup = groupAssigned.value;
    var parent = pDiv.parentNode.parentNode; 
    var group = pDiv.childNodes[2];
    var idProfessor = pDiv.getAttribute("data-value");
    var idCourse = pDiv.id;
    var idGroup = group.value;
    group.style.display = "block";

    pDiv.parentNode.removeChild(pDiv); // Delete the actual pDiv.
    groupAssigned.appendChild(group);

    /* If there are 6 groups assigned.*/
    if (groupAssigned.length > 6)
    {
        var par = document.createElement("P");                        // Create a <p> node
        var text = document.createTextNode("No ha sido asignado");
        par.appendChild(text);
        var divText = divCourse.childNodes[3]; // Get the div of the p values.
        divText.appendChild(par);
    }
    
    decreaseLoadProfessor(idProfessor);
    dropElement(idProfessor, idCourse, idGroup);
}

function dropElement(pIdProfessor, pIdCourse, pIdGroup)
{
    var length = assigned.length;
    console.log("Id Prof: " + pIdProfessor + " - IdCourse: " + pIdCourse + 
        " - Id Group: " + pIdGroup);
    for(var i = 0; i < length; i++)
    {
        if (assigned[i].idProfessor == pIdProfessor && 
            assigned[i].idCourse == pIdCourse &&
            assigned[i].idGroup == pIdGroup)
        {
            if (i == 0)
            {
                var rest = assigned.splice(i, i + 1); // Drops the element of the list.
            }else{
                var rest = assigned.splice(i, i); // Drops the element of the list.
            }

            if (i < length - 1)
            {
                //console.log(assigned);
                //console.log(rest);
                var dropRest = rest.splice(i + 1, i + 1);
                //console.log(dropRest);
                assigned = assigned.concat(dropRest);
            }
            return;
        }
    }
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

    var groupSelected = null;
    /* Remove the group that I choose.*/
    for(var i=0; i < groupAssigned.length; i++)
    {
        if (groupAssigned[i].value == groupAssigned.value)
        {
            groupSelected = groupAssigned[i];
            idGroup = groupSelected.value;
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

    var div = addParagraphCourse(nameProf, numGroup, groupSelected); // Get the div with the values assigned;

    var text = divCourse.childNodes[3]; // Get the div of the p values.

    // If there are 6 or more groups values able.
    if((groupAssigned.length >= 6))
    {
        var length = text.childNodes.length; // Number of text assigned to a course.
        for(var i = 0; i < length; i++)
        {
            var childText = text.childNodes[i];
            // If the text is a paragraph.
            if (childText.tagName == "P")
            {
                text.removeChild(childText); // Remove the paragraph.
                length -= 1;
            }
        }
    }

    div.id = idCourse;
    div.setAttribute("data-value", idProf);
    text.appendChild(div); // Add the assigned.

    increaseLoadProfessor(idProf); // Assign the course.
    var course = registerCourse(idCourse, idProf, nameCourse, nameProf, idGroup, numGroup); // Register the new course.
}


function registerCourse(pIdCourse, pIdProf, pNameCourse, pNameProf, pIdGroup, pNumGroup)
{
    var courseRegistered = new Object();
    courseRegistered.idCourse = pIdCourse;
    courseRegistered.idProfessor = pIdProf;
    courseRegistered.nameCourse = pNameCourse;
    courseRegistered.nameProfessor = pNameProf;
    courseRegistered.idGroup = pIdGroup;
    courseRegistered.nameGroup = pNumGroup;

    assigned.push(courseRegistered); // Registered the course
    return courseRegistered;
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
    console.log("Asignación: ");
    for (var i = 0; i < assigned.length; i++)
    {
        console.log("Elemento: " + assigned[i].idCourse + " - " + assigned[i].idProfessor + " - " + 
            assigned[i].nameCourse + " - " + assigned[i].nameProfessor + " - " + assigned[i].idGroup +
            " - " + assigned[i].nameGroup);
    }
}