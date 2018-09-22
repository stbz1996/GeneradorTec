/************************************************************************************* 
That function is only for view, it takes up to 100 schedules and active or deactive 
it state but this is only for view, does not change the value of the inputs
*************************************************************************************/
function fillSchedulesStates(){
	for (var i=1; i < 85; i++) {
		changeStateOnView('Inp-'+i, 'Div-'+i);
	}
	var oldSchedules = $('input[name^="oldSchedules"]');
	for(i = 0; i < oldSchedules.length; i++)
	{
		changeState('Inp-'+oldSchedules[i].value, 'Div-'+oldSchedules[i].value);
	}
}


/************************************************************************************* 
That function is only for view, it change the stile of the items in view
*************************************************************************************/
function changeStateOnView(id, idDiv) {
	if (document.getElementById(id).value == 1) 
	{
		document.getElementById(id).value = 0;
		document.getElementById(idDiv).style.background="white";
		document.getElementById(idDiv).style.opacity="1";
		document.getElementById(idDiv).style.color="white";
	}
	else
	{
		document.getElementById(idDiv).style.background="gray";
		document.getElementById(idDiv).style.opacity="0.5";
		document.getElementById(idDiv).style.color="gray";
	}
}


/************************************************************************************* 
That function is only for view, but it change the value according with the id the is pass
in the paramethers.  
*************************************************************************************/
function changeState(id, idDiv) {
	if (document.getElementById(id).value == 1) 
	{
		document.getElementById(id).value = 0;
		document.getElementById(idDiv).style.background="white";
		document.getElementById(idDiv).style.opacity="1";
		document.getElementById(idDiv).style.color="white";
	}
	else
	{
		document.getElementById(id).value = 1;
		document.getElementById(idDiv).style.background="green";
		document.getElementById(idDiv).style.opacity="0.8";
		document.getElementById(idDiv).style.color="green";
	}
}