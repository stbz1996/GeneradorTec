/*************************************************
This function is in charge to organize the emails
to be sent and show the asnwer of the sistem 
*************************************************/
function showEmailSent(){
	var date   = document.getElementById("dateForLinks");
	var period = document.getElementById("periodForLinks");
	$.ajax({
		url: "../GenerateLinks_controller/generateLinks",
		type: "POST",
		data:{
			dateForLinks: date.value,
			periodForLinks: period.options[period.selectedIndex].value
		},
		beforeSend: function(){
            hideGenerateLinks();
        },
		success: function(data){
			showGenerateLinks();
			var msj = "";
			var professors = JSON.parse(data);
			if (professors.length == 0) {
				swal('Ya se han enviado los correos para este periodo', '', 'info');
			}
			else{
				for (var i = 0; i < professors.length; i++) {
					msj += professors[i] + "\r\n";
				}
            	swal('Correo enviado a los siguientes profesores', msj, 'success');
			}
		},
		error: function ()
        {
            swal('Error', 'Hemos tenido un fallo al enviar los correos', 'error');
        }
	});
}
/***************************************
// Shows and hide the item for loader
***************************************/
function showGenerateLinks(){
	document.getElementById("loader").style.display = "none";
	document.getElementById("LinksForm").style.opacity = 1;
    document.getElementById("titles").style.opacity    = 1;
}
function hideGenerateLinks(){
	document.getElementById("loader").style.display = "block";
    document.getElementById("LinksForm").style.opacity = 0.5;
    document.getElementById("titles").style.opacity    = 0.5;
}