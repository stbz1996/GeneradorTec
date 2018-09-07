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
- If radio button is changed
****************************************/
function changeState(url, id)
{
	$.ajax({
		url: url,
		type: "POST",
		data: $('#formeo' + id).serialize(),
		dataType: "JSON",
		success: function(data)
		{
			location.reload();// for reload a page
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
function editCourse(id, url)
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
            $('[name="inputIdCourse"]').val(data.idCourse);
            $('[name="inputCode"]').val(data.code);
            $('[name="inputName"]').val(data.name);
            $('[name="inputBlock"]').val(data.idBlock);
            $('[name="inputState"]').val(data.state);
            $('[name="inputLessons"]').val(data.lessonNumber);
            $('[name="inputCareer"]').val(data.isCareer);

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
}

/****************************************
- If the user press save a plan, defined the method.
****************************************/
function savePlan()
{
    var url;

    if (save_method == "add")
    {
        url = base_url + "index.php/Administrator_controller/addPlan";
    }else{
        url = base_url + "index.php/Administrator_controller/editPlan";
    }

    save(url);
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

    save(url);
}


function deleteCourse(id)
{
    if(confirm('Are you sure delete this data?'))
    {
        // ajax delete data from database
        $.ajax({
            url : "course/deleteCourse/" + id,
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