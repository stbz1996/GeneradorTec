var cardNumber = 10000000000;
var lessonsCounter = [];
var addScheculeButttons = [];
var courses = {};
var megacourses = [];
var indexCourse = 0;


/*
    Faltan funciones para:
    guardar a base de datos
    obtener datos de base de datos y actualizar la pantalla/variables
*/

function creatediv()
{
    var col = document.createElement('div');
    col.className = 'col-lg-3 service-course';
    col.id = cardNumber;

    var card = document.createElement('div');
    card.className = 'card';

    var cardBody = document.createElement('div');
    cardBody.className = 'card-body';

    var cardTitle = document.createElement('h5');
    cardTitle.className = 'card-title';
    cardTitle.innerHTML = (document.getElementById("selectCourse").value) +
                            " | Grupo: " +  document.getElementById("selectGroup").value + 
                            " | " + document.getElementById("selectNumLessons").value + " lecciones";;

    var cardSchedules = document.createElement('div');
    cardSchedules.className = 'card-schedules';
    cardSchedules.id = "cardSchedules" + cardNumber;

    var cardFooter = document.createElement('div');
    cardFooter.className = "cardFooter";

    var cardSchedulesSelect = document.createElement('select');
    cardSchedulesSelect.className = "form-control";
    cardSchedulesSelect.id = "scheduleSelect" + cardNumber;

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
    addScheculeButtton.id = "btn" + cardNumber;
    addScheculeButttons[indexCourse] = addScheculeButtton.id;
    addScheculeButtton.className = 'btn btn-primary';
    addScheculeButtton.innerHTML = "Agregar";
    addScheculeButtton.setAttribute('onClick', "addScheculeToCourse(" + cardSchedules.id + ", " +
                                                cardSchedulesSelect.id + ", " + indexCourse + ", " +
                                                addScheculeButtton.id + ")");

    var deleteCardButton = document.createElement('a');
    deleteCardButton.className = 'btn btn-danger';
    deleteCardButton.innerHTML = "Borrar";
    deleteCardButton.setAttribute('onClick', "deleteCard(" + col.id + ', ' + indexCourse + ')');

    cardFooter.appendChild(cardSchedulesSelect);
    cardFooter.appendChild(addScheculeButtton);
    cardFooter.appendChild(deleteCardButton);

    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardSchedules);
    card.appendChild(cardBody);
    card.append(cardFooter);
    col.appendChild(card);
    document.getElementById("serviceCourses").appendChild(col);

    courses[indexCourse] = {}
    courses[indexCourse].name = document.getElementById("selectCourse").value;
    courses[indexCourse].group = document.getElementById("selectGroup").value;
    courses[indexCourse].numLessons = document.getElementById("selectNumLessons").value;
    courses[indexCourse].block = $('#selectCourse :selected').attr('label'); 
    courses[indexCourse].lessons = [];
    megacourses.push(courses[indexCourse]);
    console.log(megacourses);
    lessonsCounter[indexCourse] = document.getElementById("selectNumLessons").value;
    cardNumber++;
    indexCourse++;
}

function addScheculeToCourse(cardSchedulesId, cardSchedulesSelectId, lessonsCounterIndex, addScheculeButttonId)
{
    var string = cardSchedulesSelectId.options[cardSchedulesSelectId.selectedIndex].id;
    var fields = string.split('-');
    var opt = fields[0];
    var id = fields[1];

    /* VALIDAR EL ID */

    var schedule = document.createElement("div");
    schedule.classList.add("course-schedule");
    schedule.id = id;

    //console.log(jArray);

    var scheduleDescription = document.createElement('p');
    scheduleDescription.innerHTML = cardSchedulesSelectId.value;
    
    var btn = document.createElement("button");
    btn.classList.add("btn-danger");
    btn.setAttribute('onclick','deleteScheduleCourse(' + schedule.id + ", " + lessonsCounterIndex + ', ' + addScheculeButttonId.id + ')');
    
    var glyphicon = document.createElement("i");
    glyphicon.classList.add("glyphicon");
    glyphicon.classList.add("glyphicon-trash");
    
    btn.appendChild(glyphicon);
    schedule.appendChild(scheduleDescription);
    schedule.appendChild(btn);
    cardSchedulesId.appendChild(schedule);

    var schedule1 = {};
    schedule1.name = cardSchedulesSelectId.value;
    schedule1.id = id;
    courses[lessonsCounterIndex].lessons.push(schedule1);

    lessonsCounter[lessonsCounterIndex]--;  //cambiar por assignedLessons dentro de courses[n] o quitarlo del todo
    
    if(lessonsCounter[lessonsCounterIndex] == 0) //cambiar por comparacion con assignedcourses o con lenght lesson y numlessons
    {
        addScheculeButttonId.classList.add("disabled");
    }
}

function deleteCard(id, index)
{
    document.getElementById(id).remove();
    //courses.splice(courses.indexOf(courseName));
    //delete megacourses[index];
    megacourses.splice(index, 1);

    $.each(courses, function(i, el){
        /*if (this.id == id){
            courses.splice(i, 1);
        }*/
        console.log(el);
    });

    indexCourse--;
    console.log(megacourses);
}

function deleteScheduleCourse(scheduleId, lessonsCounterIndex, addScheculeButttonId)
{
    //jsonArray.splice(jsonArray.indexOf('string_to_search'));
    
    document.getElementById(scheduleId).remove();
    lessonsCounter[lessonsCounterIndex]++;
    addScheculeButttonId.classList.remove("disabled");
    
    console.log(courses[lessonsCounterIndex].lessons);

}