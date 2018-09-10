$(document).ready( function () {
    $('#table_id').DataTable();
} );

var save_method; //for save method string
var table;

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

/****************************************
- If button add plan is pressed, show the modal.
****************************************/
function addPlan()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Crear Plan');
}

/****************************************
- If button add block is pressed, show the modal.
****************************************/
function addBlock()
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text('Crear Bloque');
}

/****************************************
- If button add course is pressed, show the modal.
****************************************/
function addCourse()
{
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Crear Curso');
}

/****************************************
- If button add professor is pressed, show the modal.
****************************************/
function addProfessor()
{
    save_method = 'add';
    $('#form')[0].reset();
    $('#modal_form').modal('show');
    $('.modal-title').text('Crear Profesor');
}

/****************************************
- If something is activated.
****************************************/
function activateState(url, id)
{
    var value = 1;
    $.ajax({
        url: url,
        type: "POST",
        data:{id:id, state:value},
        success: function(data){
            $('[name="inputState"]').val(value);
            alert("Activado");
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/****************************************
- If something is desactivated.
****************************************/
function desactivateState(url, id)
{
    var value = 0;
    $.ajax({
        url: url,
        type: "POST",
        data:{id:id, state:value},
        success: function(data){
            $('[name="inputState"]').val(data.state);
            alert("Desactivado");
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/****************************************
- If button edit plan is pressed, load the data from the database.
****************************************/
function editPlan(url, id)
{
    save_method = 'update';
    $('#form')[0].reset();

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="inputIdPlan"]').val(data.idPlan);
            $('[name="inputName"]').val(data.name);
            $('[name="inputState"]').val(data.state);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Plan'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/****************************************
- If button edit block is pressed, load the data from the database.
****************************************/
function editBlock(url, id)
{
    save_method = 'update';
    $('#form')[0].reset();

    console.log(url + id);

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="inputIdBlock"]').val(data.idBlock);
            $('[name="inputName"]').val(data.name);
            $('[name="inputState"]').val(data.state);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Bloque'); // Set title to Bootstrap modal title
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/****************************************
- If button edit course is pressed, load the data from the database.
****************************************/
function editCourse(url, id)
{
    console.log(url + id);
    save_method = 'update';
    $('#form')[0].reset();

    console.log(url + id);

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            console.log(url + id);
            $('[name="inputIdCourse"]').val(data.idCourse);
            $('[name="inputCode"]').val(data.code);
            $('[name="inputName"]').val(data.name);
            $('[name="inputState"]').val(data.state);
            $('[name="inputLessons"]').val(data.lessonNumber);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Curso'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            console.log("El error está aquí");
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}


/****************************************
- If button edit professor is pressed, load the data from the database.
****************************************/
function editProfessor(url, id)
{
    console.log(url + id);
    save_method = 'update';
    $('#form')[0].reset();

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        success: function(data)
        {
            $('[name="inputIdProfessor"]').val(data.idProfessor);
            $('[name="inputName"]').val(data.name);
            $('[name="inputLastName"]').val(data.lastName);
            $('[name="inputEmail"]').val(data.email);
            $('[name="inputState"]').val(data.state);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Profesor'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/****************************************
- Store the data in the database.
****************************************/
function save(url)
{
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        success: function(data)
        {
            //if success close modal and reload ajax table
            $('#modal_form').modal('hide');
            location.reload();// for reload a page
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
    console.log($('#form').serialize());
}

/****************************************
- If the user press save a plan, defined the method.
****************************************/
function savePlan()
{
    var url;
    var text;

    if (save_method == "add")
    {
        url = base_url + "index.php/Administrator_controller/addPlan";
    }else{
        url = base_url + "index.php/Administrator_controller/editPlan";
    }

    text = $('[name="inputName"]').val();

    if (text)
    {
        save(url);
    }else
    {
        alert("Debe escribir un nombre para el plan");
    }
}

/****************************************
- If the user press save a block, defined the method.
****************************************/
function saveBlock()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "index.php/Administrator_controller/addBlock";
    }else{
        url = base_url + "index.php/Administrator_controller/editBlock";
    }

    text = $('[name="inputName"]').val();

    if (text)
    {
        save(url);
    }else
    {
        alert("Debe escribir un nombre para el bloque");
    }
}

/****************************************
- If the user press save a course, defined the method.
****************************************/
function saveCourse()
{
    var url;
    var name, code, lessons;

    if (save_method == "add")
    {
        url = base_url + "index.php/Administrator_controller/addCourse";
    }else{
        url = base_url + "index.php/Administrator_controller/editCourse";
    }

    code = $('[name="inputCode"]').val();
    name = $('[name="inputName"]').val();
    lessons = $('[name="inputLessons"]').val();

    if (code && name && lessons)
    {   
        if(!/^([0-9])*$/.test(lessons)){
            alert("El número de créditos no es un número");
            return;
        }

        if (lessons > 12 || lessons < 0){
            alert("El número de créditos no es aceptado");
            return;
        }

        save(url);
    }else{
        alert("Falta agregar datos.");
    }
}

/****************************************
- If the user press save a course, defined the method.
****************************************/
function saveProfessor()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "index.php/Administrator_controller/addProfessor";
    }else{
        url = base_url + "index.php/Administrator_controller/editProfessor";
    }

    save(url);
}

/****************************************
- If the user press delete for whatever.
****************************************/
function deleteAll(url, id)
{
    if(confirm('¿Está seguro de eliminar la carpeta?'))
    {
        // ajax delete data from database
        $.ajax({
            url : url + id,
            type: "POST",
            dataType: "JSON",
            success: function(data)
            {
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                showErrors(jqXHR, textStatus, errorThrown);
            }
        });
    }
}