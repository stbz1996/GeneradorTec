var save_method; //for save method string
var table;

$(document).ready(function() {
    table = $('#table_id').DataTable();
  });

/*************************************************************
    Those function are in charge to show and hide the loader
**************************************************************/
function sleep(milliseconds) {
    var start = new Date().getTime();
    for (var i = 0; i < 1e7; i++) {
        if ((new Date().getTime() - start) > milliseconds) {    
            break;
        }
    }
}

function showLoader(){
    document.getElementById("allcontent").style.opacity = 0.5;
    document.getElementById("loader").style.display = "block";
}

function hideLoader(){
    sleep(500);
    document.getElementById("allcontent").style.opacity = 1;
    document.getElementById("loader").style.display = "none";
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

/*************************************************
- If the user press add for whatever.            *
- This is the main add function for              *
- plans, block, courses, professors and periods. *
**************************************************/
function add(message)
{
    save_method = 'add';
    $('#form')[0].reset(); // reset form on modals
    $('#modal_form').modal('show'); // show bootstrap modal
    $('.modal-title').text(message);
}

function addAdmin()
{
    var message = "Agregar Admin";
    save_method = 'add';
    saveAdmin();
}

function addPlan()
{
    var message = "Agregar Plan";
    add(message);
}

function addBlock()
{
    var message = "Agregar Bloque";
    add(message);
}

function addCourse()
{
    var message = "Agregar Curso";
    add(message);
}

function addProfessor()
{
    var message = "Agregar Profesor";
    add(message);
}

function addPeriod()
{
    var message = "Agregar Periodo";
    add(message);
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
        beforeSend: function(){
            showLoader();
        },
        success: function(data){
            $('[name="inputState"]').val(value);
            hideLoader();
            swal({title: "Activado", icon: "success"});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
            hideLoader();
            swal({title: "Error al Activar", icon: "error"});
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
        beforeSend: function(){
            showLoader();
        },
        success: function(data){
            $('[name="inputState"]').val(data.state);
            hideLoader();
            swal({title: "Desactivado", icon: "success"});
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
            hideLoader();
            swal({title: "Error al Desactivar", icon: "error"});
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
        beforeSend: function(){
            showLoader();
        },
        success: function(data)
        {
            $('[name="inputIdPlan"]').val(data.idPlan);
            $('[name="inputName"]').val(data.name);
            $('[name="inputState"]').val(data.state);
            hideLoader();
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

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(data)
        {
            $('[name="inputIdBlock"]').val(data.idBlock);
            $('[name="inputName"]').val(data.name);
            $('[name="inputState"]').val(data.state);
            hideLoader();
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
    save_method = 'update';
    $('#form')[0].reset();

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(data)
        {
            $('[name="inputIdCourse"]').val(data.idCourse);
            $('[name="inputCode"]').val(data.code);
            $('[name="inputName"]').val(data.name);
            $('[name="inputState"]').val(data.state);
            $('[name="inputLessons"]').val(data.lessonNumber);
            hideLoader();
            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Curso'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}


/****************************************
- If button edit professor is pressed, load the data from the database.
****************************************/
function editProfessor(url, id)
{
    save_method = 'update';
    $('#form')[0].reset();

    //Ajax Load data from ajax
    $.ajax({
        url : url + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(data)
        {
            $('[name="inputIdProfessor"]').val(data.idProfessor);
            $('[name="inputName"]').val(data.name);
            $('[name="inputLastName"]').val(data.lastName);
            $('[name="inputEmail"]').val(data.email);
            $('[name="inputState"]').val(data.state);
            hideLoader();
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
- If button edit professor is pressed, load the data from the database.
****************************************/
function editPeriod(url, id)
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
            $('[name="inputIdPeriod"]').val(data.idPeriod);
            $('[name="inputNumber"]').val(data.number);
            $('[name="inputYear"]').val(data.year);

            $('#modal_form').modal('show'); // show bootstrap modal when complete loaded
            $('.modal-title').text('Editar Periodo'); // Set title to Bootstrap modal title

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

/************************************************
- If the user press delete for whatever.        *
- This is the main save function for            *
- plans, block, courses, professors and periods.*
*************************************************/
function save(url, message)
{
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form').serialize(),
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(response)
        {
            if (response == true)
            {
                $('#modal_form').modal('hide');
                hideLoader();
                swal({title: "Listo", 
                text: message[0],
                icon: "success"}).then(function(){
                    location.reload();
                });
            }

            else
            {
                hideLoader();
                swal({title: "Error", text: message[1], icon: "warning"});
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}


function saveFormAdmin(url, message)
{
    // ajax adding data to database
    $.ajax({
        url : url,
        type: "POST",
        data: $('#Login').serialize(),
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(response)
        {
            if (response == true)
            {
                hideLoader();
                swal({title: "Listo", 
                text: message[0],
                icon: "success"}).then(function(){
                    location.reload();
                });
            }
            else
            {
                hideLoader();
                swal({title: "Error", text: message[1], icon: "warning"});
            }

        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}


function savePlan()
{
    var url;
    var text;

    if (save_method == "add")
    {
        url = base_url + "Administrator_controller/addPlan";
        var message = [
            "Se ha agregado el plan",
            "Error al agregar el plan. Verifique los datos e inténtelo de nuevo."
        ];
    }
    
    else
    {
        url = base_url + "Administrator_controller/editPlan";
        var message = [
            "Se ha editado el plan",
            "Error al editar el plan. Verifique los datos e inténtelo de nuevo."
        ];
    }

    text = $('[name="inputName"]').val();

    if (text)
    {
        save(url, message);
    }
    
    else
    {
        swal({title: "Error", 
            text: "Debe escribir un nombre para el plan", 
            icon: "error"});
    }
}

function saveBlock()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "Administrator_controller/addBlock";
        var message = [
            "Se ha agregado el bloque",
            "Error al agregar el bloque. Verifique los datos e inténtelo de nuevo."
        ];
    }
    
    else
    {
        url = base_url + "Administrator_controller/editBlock";
        var message = [
            "Se ha editado el plan",
            "Error al editar el plan. Verifique los datos e inténtelo de nuevo."
        ];
    }

    text = $('[name="inputName"]').val();

    if (text)
    {
        save(url, message);
    }
    
    else
    {
        swal({title: "Error", 
            text: "Debe escribir un nombre para el bloque", 
            icon: "error"});
    }
}

function loadBlocks(id)
{
    var url = base_url + "Administrator_controller/loadBlocks/";
    $.ajax({
        url: url + id,
        type: "GET",
        dataType: "JSON",
        beforeSend: function(){
            showLoader();
        },
        success: function(blocks)
        {
            var count = 0;

            blocks.forEach(function(block){
                var messageId = '<option value="' + String(block.idBlock) + '">';
                var messageName = String(block.name) + '</option>';
                var message = messageId + messageName;
                $('#selectBlock').append(message);
            });
            hideLoader();
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}

// When the plans is selected... load all the blocks.
$('#selectPlan').on('change', function(){
    var id = $('#selectPlan option:selected').val();
    $('#selectBlock').empty();
    loadBlocks(id);
})

function saveCourse()
{
    var url;
    var name; 
    var code; 
    var lessons;
    var block;

    if (save_method == "add")
    {
        url = base_url + "Administration/Courses_controller/addCourse";
        var message = [
            "Se ha agregado el curso",
            "Error al agregar el curso. Verifique los datos e inténtelo de nuevo."
        ];
    }

    else
    {
        url = base_url + "Administration/Courses_controller/editCourse";
        var message = [
            "Se ha editado el curso",
            "Error al editar el curso. Verifique los datos e inténtelo de nuevo."
        ];
    }

    code = $('[name="inputCode"]').val();
    name = $('[name="inputName"]').val();
    lessons = $('[name="inputLessons"]').val();
    block = $('#selectBlock option:selected').val();

    /* If the block is not selected. */
    if(block == '0' || block == '' || block == 'undefined' || block == null )
    {
        swal({title: "Error", 
            text: "No se ha seleccionado ningún bloque para almacenar el curso", 
            icon: "error"});
        return;
    }

    if (code && name && lessons)
    {   
        if(!/^([0-9])*$/.test(lessons)){
            swal({title: "Error", 
                text: "El número de créditos no es un número", 
                icon: "error"});
            return;
        }

        if (lessons > 12 || lessons < 0){
            swal({title: "Error", 
                text: "El número de créditos no es aceptado", 
                icon: "error"});
            return;
        }

        save(url, message);
    }
    
    else
    {
        swal({title: "Error", 
            text: "Datos incompletos.", 
            icon: "error"});
    }
}

function saveProfessor()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "Administrator_controller/addProfessor";
        var message = [
            "Se ha agregado el profesor",
            "No se ha agregado el profesor. Verifique los datos."
        ];
    }
    
    else
    {
        url = base_url + "Administrator_controller/editProfessor";
        var message = [
            "Se ha editado el profesor",
            "No se ha editado el profesor. Verifique los datos."
        ];
    }

    save(url, message);
}

function savePeriod()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "index.php/Administrator_controller/addPeriod";
        var message = [
            "Se ha agregado el periodo",
            "El periodo ya existe. No se realizarán los cambios."
        ];
    }
    else
    {
        url = base_url + "index.php/Administrator_controller/editPeriod";
        var message = [
            "Se ha editado el periodo",
            "El periodo ya existe o tiene formularios asociados. No se realizarán los cambios."
        ];
    }

    save(url, message);
}

function saveAdmin()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "Administrator_controller/getAdminData";
        var message = [
            "Se ha agregado el administrador",
            "El administrador ya está registrado",
            "No se ha agregado el administrador. Verifique los datos."
        ];
    }
    username = $('[name="inputUsername"]').val();
    password = $('[name="inputPassword"]').val();
    verifyPassword = $('[name="inputPasswordAgain"]').val();

    if (username && password && verifyPassword)
    {   
        if (password == verifyPassword)
        {
            saveFormAdmin(url, message);  
        }
         else
        {
        swal({title: "Error", 
            text: "Contraseñas no coinciden.", 
            icon: "error"});
        }
    }
    else
    {
        swal({title: "Error", 
            text: "Datos incompletos.", 
            icon: "error"});

    }
}

/************************************************
- If the user press delete for whatever.        *
- This is the main delete function for          *
- plans, block, courses, professors and periods.*
*************************************************/   
function deleteAll(url, id, message)
{
    swal({
        title: message[0],
        text: "La accion no se puede revertir",
        icon: "warning",
        buttons: true,
        dangerMode: true,
    })
    .then((willDelete) => {
    if (willDelete)
    {
        $.ajax({
            url : url + id,
            type: "POST",
            dataType: "JSON",
            beforeSend: function(){
                showLoader();
            },
            success: function(response)
            {
                if (response == true)
                {
                    $('#modal_form').modal('hide');
                    hideLoader();
                    swal({title: "Listo", 
                        text: message[1], 
                        icon: "success"}).then(function(){
                            location.reload();
                            table.fnStandingRedraw();
                    });
                }

                else
                {
                    hideLoader();
                    swal({title: "Error",
                        text: message[2],
                        icon: "error"});
                }

            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                showErrors(jqXHR, textStatus, errorThrown);
            }
        });
    }
    });

}

function deletePlan(url, id)
{
    var message = [
        '¿Está seguro de eliminar el plan?',
        'Plan eliminado.',
        "No se ha borrado el plan. Verifique que no tenga información asociada. No se realizarán los cambios."
    ];

    deleteAll(url, id, message);
}

function deleteBlock(url, id)
{
    var message = [
        '¿Está seguro de eliminar el bloque?',
        'Bloque eliminado.',
        "Erro al borrar el bloque. Verifique que no tenga cursos asociados. No se realizarán los cambios."
    ];

    deleteAll(url, id, message);
}

function deleteCourse(url, id)
{
    var message = [
        '¿Está seguro de eliminar el curso?',
        'Curso eliminado.',
        "No se ha borrado el curso. No se realizarán los cambios."
    ];

    deleteAll(url, id, message);
}

function deleteProfessor(url, id)
{
    var message = [
        '¿Está seguro de eliminar el profesor?',
        'Profesor eliminado.',
        "El profesor puede tener formularios asociados. No se realizarán los cambios."
    ];

    deleteAll(url, id, message);
}

function deletePeriod(url, id)
{
    var message = [
        '¿Está seguro de eliminar el periodo?',
        'Periodo eliminado.',
        "El periodo ya existe o tiene formularios asociados. No se realizarán los cambios."
    ];

    deleteAll(url, id, message);
}

function assignAdvanceDays(url)
{
    var selectAdvanceDays = document.getElementById("select-advanceDays");
    var advanceDays = selectAdvanceDays.options[selectAdvanceDays.selectedIndex].value;

    $.ajax({
        url : url,
        type: "POST",
        data: {advanceDays: advanceDays},
        beforeSend: function(){
            showLoader();
        },
        success: function(response)
        {
            hideLoader();
            if(response)
            {
                swal('Listo', 'Cambios han sido guardados', 'success');
            }
            else
            {
                swal('Lo sentimos', 'No se pudieron realizar los cambios, intente más tarde', 'error');
            }
        },
        error: function (jqXHR, textStatus, errorThrown)
        {
            showErrors(jqXHR, textStatus, errorThrown);
        }
    });
}



