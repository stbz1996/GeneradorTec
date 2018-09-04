function addPlan()
{
	$('#form')[0].reset(); // reset form on modals
	$('#modal_form').modal('show'); // show bootstrap modal
	$('.modal-title').text('Crear Plan');
}

function save(url)
{
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
			alert('Error adding / update data');
		}
	});
}
