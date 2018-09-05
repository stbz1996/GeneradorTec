function changeState(id, idDiv) {
	if (document.getElementById(id).value == 1) {
		document.getElementById(id).value = 0;
		document.getElementById(idDiv).style.background="white";
		document.getElementById(idDiv).style.opacity="1";
		document.getElementById(idDiv).style.color="white";
	}
	else{
		document.getElementById(id).value = 1;
		document.getElementById(idDiv).style.background="green";
		document.getElementById(idDiv).style.opacity="0.8";
		document.getElementById(idDiv).style.color="green";
	}
	//alert(document.getElementById(id).value)
}