var period = 0;
var cardNumber = 10000;
var courses = [];
var coursesFromDB = [];
var days = ['Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'];

$(document).ready(function() {
    $('#modalPeriod').modal('show');
});

function isPeriodAssigned()
{
    if(period != 0)
    {
        return true;
    }
    else
    {
        return false;
    }
}

//mostrar en pantalla los cursos y las lecciones almacenadas en BD para un curso
function printCourses()
{
    var flag = false;

    for(var i=0; i<coursesFromDB.length; i++)
    {
        //reviso que el curso no ha sido seleccionado
        for(var j=0; j<courses.length; j++)
        {
            if(coursesFromDB[i].name == courses[j].name && 
                coursesFromDB[i].group == courses[j].group)
            {
                //llamar a addScheduleToCourse
                flag = true;
                break;
            }
        }

        if(!flag)
        {     
            createServiceCourse(coursesFromDB[i].name, coursesFromDB[i].group, 
                                coursesFromDB[i].numLessons, coursesFromDB[i].block);

            for(var k=0; k<courses.length; k++)
            {
                if(courses[k].name == coursesFromDB[i].name && courses[k].group == coursesFromDB[i].group)
                {
                    //agregar el curso al courses[k].id correspondiente
                    addScheculeFromBDToCourse(courses[k].cardSchedulesId, coursesFromDB[i],
                                                courses[k].addScheculeButton, courses[k].id);

                    break;
                }
            }
        }

        else
        {
            for(var k=0; k<courses.length; k++)
            {
                if(courses[k].name == coursesFromDB[i].name && courses[k].group == coursesFromDB[i].group)
                {
                    //agregar el curso al courses[k].id correspondiente
                    addScheculeFromBDToCourse(courses[k].cardSchedulesId, coursesFromDB[i],
                                              courses[k].addScheculeButton, courses[k].id);

                    flag = false;
                    break;
                }
            }
        }
    }
}

//cuando se selecciona un periodo, se obtienen los cursos en BD asociados a ese periodo
function getServiceCourses()
{
    $.ajax({
        url : base_url + "Administration/Courses_controller/getServiceLessonsByPeriod/" + period,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(data)
        {
            if(data.length == 0)
            {
                swal({title: "No hay cursos de servicio asociados a este periodo", icon: "success"});
            }
            else
            {
                coursesFromDB = data;
                printCourses();
            }
            hideLoader();

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

function selectPeriod()
{
    $('#serviceCourses').empty();
    period = $('[name="selectPeriod"]').val();
    cardNumber = 10000;
    courses = [];
    coursesFromDB = [];
    $('#modalPeriod').modal('hide');
    getServiceCourses();
}

function reselectPeriod()
{
    $('#modalPeriod').modal('show');
}

//verifica si el curso ya fue creado
function IsCourseAssigned(courseName, courseGroup)
{
    for(var i = 0; i < courses.length; i++)
    { 
        if(courses[i].name == courseName && courses[i].group == courseGroup)
        {
            return true;
        }
    }
    return false;
}

//crea el curso y pinta el cuadro en pantalla
function createServiceCourse(courseName = null, courseGroup = null, courseNumLessons = null, courseBlock = null)
{
    if(!isPeriodAssigned())
    {
        swal({title: "Error",
        text: "No ha seleccionado el periodo",
        icon: "error"});
        return;
    }

    if(courseName == null && courseGroup == null && courseNumLessons == null && courseBlock == null)
    {
        var selectName = $('#selectCourse :selected').attr('name').split('-');
        courseGroup = document.getElementById("selectGroup").value;
        courseName = document.getElementById("selectCourse").value;
        courseBlock = selectName[0];
        courseNumLessons = selectName[1];
    }

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
    cardFooter.className = "cardFooter service-courses-options";

    var cardSchedulesSelect = document.createElement('select');
    cardSchedulesSelect.className = "form-control cardFooter-option";
    cardSchedulesSelect.id = "scheduleSelect-" + cardNumber;

    /*Create and append the options*/
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

    var addScheduleButton = document.createElement('a');
    addScheduleButton.id = "btn-" + cardNumber;
    addScheduleButton.className = 'btn btn-primary cardFooter-option';
    addScheduleButton.innerHTML = "Agregar";
    addScheduleButton.setAttribute('onClick', 
                                    "addScheculeToCourse('" + cardSchedules.id + "', '" + cardSchedulesSelect.id  + "', '" +
                                    addScheduleButton.id +  "', '" + col.id + "', '" + courseName + "', '" + courseGroup + "')");

    var deleteCardButton = document.createElement('a');
    deleteCardButton.className = 'btn btn-danger cardFooter-option';
    deleteCardButton.innerHTML = "Borrar";
    deleteCardButton.setAttribute('onClick', "deleteCard('" + col.id  + "')");

    cardFooter.appendChild(cardSchedulesSelect);
    cardFooter.appendChild(addScheduleButton);
    cardFooter.appendChild(deleteCardButton);

    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardSchedules);
    card.appendChild(cardBody);
    card.append(cardFooter);
    col.appendChild(card);
    document.getElementById("serviceCourses").appendChild(col);

    var course= {}
    course.id = col.id;
    course.name = courseName;
    course.group = courseGroup;
    course.numLessons = courseNumLessons;
    course.block = courseBlock;
    course.lessons = [];
    course.cardSchedulesId = cardSchedules.id;
    course.cardSchedulesSelectId =  cardSchedulesSelect.id;
    course.addScheculeButton = addScheduleButton.id;
    courses.push(course);
    cardNumber++;
}

//elimina el curso y elimina el cuadro en pantalla
function deleteCard(id)
{
    document.getElementById(id).remove();

    for(var i=0; i<courses.length; i++)
    { 
        if (courses[i].id === id)
        {
            //borrar cada horario de la BD
            for(var j=0; j<courses[i].lessons.length; j++)
            {
                deleteLesson(courses[i].name, courses[i].group, courses[i].lessons[j].numberSchedule);
            }
            courses.splice(i, 1);
            return;
        }
    }
}

//agrega el horario en el curso (cuadro en pantalla)
function addScheculeToCourse(cardSchedulesId, cardSchedulesSelectId, addScheculeButttonId, courseId, courseName, courseGroup)
{
    if(!isPeriodAssigned())
    {
        swal({title: "Error",
        text: "No ha seleccionado el periodo",
        icon: "error"});
        return;
    }
    var currentCard = document.getElementById(cardSchedulesId);
    var currentAddButton = document.getElementById(addScheculeButttonId);
    var currentSelect = document.getElementById(cardSchedulesSelectId);
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
    
        for(var i = 0; i < courses.length; i++)
        {
            var course = courses[i];
    
            if (course.id === courseId)
            {
                course.lessons.push(schedule1);
                saveLesson(courseName, courseGroup, fields[1]);
    
                if(course.lessons.length == course.numLessons)
                {
                    currentAddButton.classList.add("disabled");
                }
                break;
            }
        }
    }
}

//agrega el horario en el curso (desde la BD al inicio de la pantalla)
function addScheculeFromBDToCourse(cardSchedulesId, course, addScheculeButttonId, courseId)
{
    var currentCard = document.getElementById(cardSchedulesId);
    var currentAddButton = document.getElementById(addScheculeButttonId);

    var courseLesson = course.lesson;
    var courseNumberSchedule = course.numberSchedule;
    var id = currentCard.id + courseNumberSchedule;

    //obtener dia de la semana
    var day = days[(courseNumberSchedule - 1) % 6];

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
    else if (IsScheduleInBlock(courseLesson, courseId))
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
        scheduleDescription.innerHTML = day + ": " + courseLesson;
        
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
        schedule1.name = courseLesson;
        schedule1.id = id;
        schedule1.numberSchedule = courseNumberSchedule;
    
        for(var i = 0; i < courses.length; i++)
        {
            var course = courses[i];
    
            if (course.id === courseId)
            {
                course.lessons.push(schedule1);
    
                if(course.lessons.length == course.numLessons)
                {
                    currentAddButton.classList.add("disabled");
                }
                break;
            }
        }
    }
}

//elimina el horario de la pantalla
function deleteScheduleCourse(scheduleId, addScheculeButttonId)
{
    var currentSchedule = document.getElementById(scheduleId);
    var currentAddButton = document.getElementById(addScheculeButttonId);
    currentSchedule.remove();

    currentAddButton.classList.remove("disabled");

    for(var i = 0; i < courses.length; i++)
    { 
        for(var j = 0; j < courses[i].lessons.length; j++)
        {

            if (courses[i].lessons[j].id == scheduleId)
            {
                //borrar en BD
                deleteLesson(courses[i].name, courses[i].group, courses[i].lessons[j].numberSchedule)

                courses[i].lessons.splice(j, 1);
                return;
            }
        }
    }
}

//verifica si el horario ya fue asignado al curso
function IsScheduleInCourse(scheduleId, courseId)
{
    for(var i = 0; i < courses.length; i++)
    { 
        if(courses[i].id == courseId)
        {
            for(var j = 0; j < courses[i].lessons.length; j++)
            {
                if (courses[i].lessons[j].id == scheduleId)
                {
                    return true;
                }
            }
        }
    }

    return false;
}

//devuelve el bloque del curso
function courseBlock(courseId)
{
    for(var i = 0; i < courses.length; i++)
    { 
        if(courses[i].id == courseId)
        {
            return courses[i].block;
        }
    }
}

//tomar el bloque del curso actual y comparar el horario con los horarios de los cursos con el mismo bloque
function IsScheduleInBlock(scheduleName, courseId)
{
    var currentBlock = courseBlock(courseId);

    for(var i = 0; i < courses.length; i++)
    { 
        if(courses[i].id != courseId && courses[i].block == currentBlock)
        {
            for(var j = 0; j < courses[i].lessons.length; j++)
            {
                if (courses[i].lessons[j].name == scheduleName)
                {
                    return true;
                }
            }
        }
    }

    return false;
}

//guardar leccion en BD
function saveLesson(courseName, courseGroup, numberSchedule)
{
    if(!isPeriodAssigned())
    {
        swal({title: "Error",
        text: "No ha seleccionado el periodo",
        icon: "error"});
    }
    else
    {
        $.ajax({
            type: "POST",
            url : base_url + "Administration/Courses_controller/addLesson/",
            data: {courseName: courseName, 
                   courseGroup: courseGroup,
                   numberSchedule: numberSchedule,
                   idPeriod: period},
            dataType: "JSON",
            success: function(data)
            {
                if(data)
                {
                    hideLoader();
                }
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                showErrors(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//borrar leccion en BD
function deleteLesson(courseName, courseGroup, numberSchedule)
{
    if(!isPeriodAssigned())
    {
        swal({title: "Error",
        text: "No ha seleccionado el periodo",
        icon: "error"});
    }
    else
    {
        $.ajax({
            url : base_url + "Administration/Courses_controller/deleteLesson/",
            type: "POST",
            dataType: "JSON",
            data: {courseName: courseName, 
                    courseGroup: courseGroup,
                    numberSchedule: numberSchedule,
                    idPeriod: period
                },
            success: function(response)
            {
                if (response)
                {
                    $('#modal_form').modal('hide');
                    hideLoader();
                    swal({title: "Listo", 
                        text: "Horario Eliminado", 
                        icon: "success"});
                }

                else
                {
                    hideLoader();
                    swal({title: "Error",
                        text: "No se ha eliminado el horario",
                        icon: "error"});
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                showErrors(jqXHR, textStatus, errorThrown);
            }
        });
    }
}