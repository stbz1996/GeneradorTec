var period;
var cardNumber = 10000;
var megacourses = [];
var courseName;
var courseGroup;
var courseNumLessons;


function selectPeriod()
{
    period = $('[name="selectPeriod"]').val();
    swal({title: "Periodo seleccionado", icon: "success"});
    $('#modalPeriod').modal('hide');
}

function reselectPeriod()
{
    $('#modalPeriod').modal('show');
}

function IsCourseAssigned(courseName, courseGroup)
{
    for(var i = 0; i < megacourses.length; i++)
    { 
        if(megacourses[i].name == courseName && megacourses[i].group == courseGroup)
        {
            return true;
        }
    }
    return false;
}

function createServiceCourse()
{
    courseGroup = document.getElementById("selectGroup").value;
    courseName = document.getElementById("selectCourse").value;

    console.log(megacourses);

    if(IsCourseAssigned(courseName, courseGroup))
    {
        swal({
            title: courseName + " - Grupo: " + courseGroup,
            text: "Este curso ya fue creado",
            icon: "warning",
            dangerMode: true,
        });

        return;
    }
    
    courseNumLessons = document.getElementById("selectNumLessons").value;

    var col = document.createElement('div');
    col.className = 'col-lg-3 service-course';
    col.id = "course-" + cardNumber;

    var card = document.createElement('div');
    card.className = 'card';

    var cardBody = document.createElement('div');
    cardBody.className = 'card-body';

    var cardTitle = document.createElement('h5');
    cardTitle.className = 'card-title';
    cardTitle.innerHTML = courseName + " | Grupo: " + courseGroup + " | " + courseNumLessons + " lecciones";;

    var cardSchedules = document.createElement('div');
    cardSchedules.className = 'card-schedules';
    cardSchedules.id = "cardSchedules-" + cardNumber;

    var cardFooter = document.createElement('div');
    cardFooter.className = "cardFooter";

    var cardSchedulesSelect = document.createElement('select');
    cardSchedulesSelect.className = "form-control";
    cardSchedulesSelect.id = "scheduleSelect-" + cardNumber;

    /*Create and append the options*/
    var days=['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];
    var i = 0;
    var index = 0;
    $.each(jArray, function(key, val) {
        var option = document.createElement("option");
        option.id = "optSchedule-" + val['numberSchedule'];
        option.value = days[index] + ": " + val['description'];
        option.text = option.value;
        cardSchedulesSelect.appendChild(option);
        i++;
        index = (i % 6);
   });

    var addScheculeButtton = document.createElement('a');
    addScheculeButtton.id = "btn-" + cardNumber;
    addScheculeButtton.className = 'btn btn-primary';
    addScheculeButtton.innerHTML = "Agregar";
    addScheculeButtton.setAttribute('onClick', "addScheculeToCourse('" + cardSchedules.id + "', '" + cardSchedulesSelect.id  + "', '" 
                                                                    +  addScheculeButtton.id +  "', '" + col.id + "')");

    var deleteCardButton = document.createElement('a');
    deleteCardButton.className = 'btn btn-danger';
    deleteCardButton.innerHTML = "Borrar";
    deleteCardButton.setAttribute('onClick', "deleteCard('" + col.id + "', " + ')');

    cardFooter.appendChild(cardSchedulesSelect);
    cardFooter.appendChild(addScheculeButtton);
    cardFooter.appendChild(deleteCardButton);

    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardSchedules);
    card.appendChild(cardBody);
    card.append(cardFooter);
    col.appendChild(card);
    document.getElementById("serviceCourses").appendChild(col);

    var course= {} //object
    course.id = col.id;
    course.name = document.getElementById("selectCourse").value;
    course.group = document.getElementById("selectGroup").value;
    course.numLessons = document.getElementById("selectNumLessons").value;
    course.block = $('#selectCourse :selected').attr('label'); 
    course.lessons = [];
    megacourses.push(course);
    //console.log(courses); //object of objects
    //console.log(megacourses); //array of objects
    cardNumber++;
}

function deleteCard(id)
{
    document.getElementById(id).remove();

    for(var i = 0; i < megacourses.length; i++)
    { 
        if (megacourses[i].id === id)
        {
          megacourses.splice(i, 1);
          return;
        }
    }
}

function addScheculeToCourse(cardSchedulesId, cardSchedulesSelectId, addScheculeButttonId, courseId)
{
    var currentCard = document.getElementById(cardSchedulesId);
    var currentSelect = document.getElementById(cardSchedulesSelectId);
    var currentAddButton = document.getElementById(addScheculeButttonId);

    var string = currentSelect.options[currentSelect.selectedIndex].id;
    var fields = string.split('-');
    var id = currentCard.id + fields[1];

    /* VALIDAR EL ID con el curso actual y con los cursos del mismo bloque*/
    if(IsScheduleInCourse(id, courseId))
    {
        swal({
            title: currentSelect.value,
            text: "Este horario ya fue seleccionado para en el curso",
            icon: "warning",
            dangerMode: true,
        })
    }
    else if (IsScheduleInBlock(currentSelect.value, courseId))
    {
        swal({
            title: currentSelect.value,
            text: "Este horario ya fue seleccionado para un curso del mismo bloque",
            icon: "warning",
            dangerMode: true,
        })

    }
    else
    {
        var schedule = document.createElement("div");
        schedule.classList.add("course-schedule");
        schedule.id = id;
    
        var scheduleDescription = document.createElement('p');
        scheduleDescription.innerHTML = currentSelect.value;
        
        var btn = document.createElement("button");
        btn.classList.add("btn-danger");
        btn.setAttribute('onclick', "deleteScheduleCourse('" + schedule.id + "', '" +  currentAddButton.id + "')");
        
        var glyphicon = document.createElement("i");
        glyphicon.classList.add("glyphicon");
        glyphicon.classList.add("glyphicon-trash");
        
        btn.appendChild(glyphicon);
        schedule.appendChild(scheduleDescription);
        schedule.appendChild(btn);
        currentCard.appendChild(schedule);
    
        var schedule1 = {};
        schedule1.name = currentSelect.value;
        schedule1.id = id;
        schedule1.numberSchedule = fields[1];

        console.log(megacourses);
    
        for(var i = 0; i < megacourses.length; i++)
        {
            var course = megacourses[i];
    
            if (course.id === courseId)
            {
                course.lessons.push(schedule1);
    
                if(course.lessons.length == course.numLessons)
                {
                    currentAddButton.classList.add("disabled");
                }
                return;
            }
        }
    }
}

function deleteScheduleCourse(scheduleId, addScheculeButttonId)
{
    var currentSchedule = document.getElementById(scheduleId);
    var currentAddButton = document.getElementById(addScheculeButttonId);
    currentSchedule.remove();

    currentAddButton.classList.remove("disabled");

    for(var i = 0; i < megacourses.length; i++)
    { 
        for(var j = 0; j < megacourses[i].lessons.length; j++)
        {

            if (megacourses[i].lessons[j].id == scheduleId)
            {
                megacourses[i].lessons.splice(j, 1);
                return;
            }
        }
    }
}

function IsScheduleInCourse(scheduleId, courseId)
{
    for(var i = 0; i < megacourses.length; i++)
    { 
        if(megacourses[i].id == courseId)
        {
            for(var j = 0; j < megacourses[i].lessons.length; j++)
            {
                if (megacourses[i].lessons[j].id == scheduleId)
                {
                    return true;
                }
            }
        }
    }

    return false;
}

function courseBlock(courseId)
{
    for(var i = 0; i < megacourses.length; i++)
    { 
        if(megacourses[i].id == courseId)
        {
            return megacourses[i].block;
        }
    }
}

//tomar el bloque del curso actual y comparar el horario con los horarios de los cursos con el mismo bloque
function IsScheduleInBlock(scheduleName, courseId)
{
    var currentBlock = courseBlock(courseId);

    for(var i = 0; i < megacourses.length; i++)
    { 
        if(megacourses[i].id != courseId && megacourses[i].block == currentBlock)
        {
            for(var j = 0; j < megacourses[i].lessons.length; j++)
            {
                if (megacourses[i].lessons[j].name == scheduleName)
                {
                    return true;
                }
            }
        }
    }

    return false;
}


/*
    Faltan funciones para:
    guardar a base de datos
    obtener datos de base de datos y actualizar la pantalla/variables
*/

function saveServiceCourses()
{
    if(period == 0)
    {
        swal({title: "Error",
        text: "No ha seleccionado el periodo",
        icon: "error"});
    }
}