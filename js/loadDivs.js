$(document).ready( function () {
    var divs = $(".professorDiv").toArray();
    var length = divs.length;

    for (var i = 0; i < length; i++)
    {
    	var id = divs[i].getAttribute('data-value'); // get the id.
    	var title = divs[i].childNodes[2];
    	var text = divs[i].childNodes[3];
    	var progressBar = divs[i].childNodes[5].childNodes[1];
    	var workPorcent = progressBar.getAttribute('aria-valuenow');
    	var workLoad = progressBar.getAttribute('aria-valuemax');
    	var textPorcentWork = divs[i].childNodes[5].childNodes[1].childNodes[1]; // Text
    	var posRelative = 0;

    	if (workPorcent == null || workPorcent == ""){
    		workPorcent = 0;
    	}

    	if (workLoad == null || workLoad == ""){
    		workLoad = 0;
    	}

    	posRelative = getRelativePosition(workPorcent, workLoad);

    	progressBar.style.width = posRelative.toString() + "%";
    	textPorcentWork.innerHTML = posRelative.toString();

    	console.log(progressBar);
    	console.log(workPorcent);
    	console.log(workLoad);
    	console.log(textPorcentWork.innerHTML);
    }
} );


function getRelativePosition(workPorcent, workLoad)
{
	var posRelative = 0;

	if (workLoad > 0)
	{
		posRelative = (100 * workPorcent) / workLoad;
    	posRelative = Math.trunc(posRelative); // Int

    	// If professor has a lot of works to
		if (posRelative > 100){
			posRelative = 100;
		}
	}
	
	return posRelative;
}