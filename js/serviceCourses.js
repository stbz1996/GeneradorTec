var boxNumber = 0;

function creatediv()
{
    var col = document.createElement('div');
    col.className = 'col-lg-3 service-course';
    col.id = boxNumber;

    var card = document.createElement('div');
    card.className = 'card';

    var cardBody = document.createElement('div');
    cardBody.className = 'card-body';

    var cardTitle = document.createElement('h5');
    cardTitle.className = 'card-title';
    //cardTitle.innerHTML = 'Titulo de la tarjeta';
    cardTitle.innerHTML = document.getElementById("selectPeriod").value;

    var cardText = document.createElement('p');
    cardText.className = 'card-text';
    cardText.innerHTML = (document.getElementById("selectCourse").value + "\nGrupo: " +
                          document.getElementById("selectGroup").value  );

    var link = document.createElement('a');
    link.className = 'btn btn-danger';
    link.innerHTML = "Borrar";
    link.setAttribute('onClick', "deleteCard(" + col.id + ")");
    //mNewObj.id = "BOX" + boxNumber;
    //mNewObj.style.backgroundColor = "red";
    //mNewObj.style.margin = "10px";
    //mNewObj.style.width = "30%";
    //mNewObj.style.visibility = "show";
    //mNewObj.style.display = "inline-block";
    //mNewObj.innerHTML = "Box " + boxNumber;
    //document.getElementById("allcontent").appendChild(mNewObj);
    //alert(mNewObj.innerHTML);
    cardBody.appendChild(cardTitle);
    cardBody.appendChild(cardText);
    cardBody.appendChild(link);
    card.appendChild(cardBody);
    col.appendChild(card);
    document.getElementById("serviceCourses").appendChild(col);
    
    boxNumber++;
}

function deleteCard(id)
{
    var elem = document.getElementById(id);
    return elem.parentNode.removeChild(elem);
}