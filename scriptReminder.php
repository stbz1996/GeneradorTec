<?php
$servername = "localhost";
$username = "id6758748_stbz1996";
$password = "stbz1996";
$dbname = "id6758748_generadortec";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

// Make query
$sql = "SELECT Form.idForm, Form.dueDate, Professor.email,
				Career.advanceDays
		FROM Form
		INNER JOIN Professor
			ON Form.idProfessor = Professor.idProfessor
		INNER JOIN Career
			ON Professor.idCareer = Career.idCareer
		WHERE Form.state = 1";

// Get result
$result = $conn->query($sql);

if($result->num_rows > 0)
{
	$from= 'Test@test.com';

	//For each row (form)
	while($row = $result->fetch_assoc())
	{
		//Get actual and due date
		$now = time();
		$formDate = strtotime($row['dueDate']);

		//Get difference of both days
		$dateDiff = round(($formDate - $now) / (60* 60* 24));

		//Check if difference of days and advance days are equal 
		if($dateDiff == $row['advanceDays'])
		{
			//Set information for email
			$subject= "Recordatorio formulario";
			$body= "Le recordamos que quedan ".$row['advanceDays']." días para enviar el formulario antes que se venza.\n\nEste es un correo automático, por favor no responder a este correo";
			$email = $row['email'];
            
			//Send email
            if(@mail($email, $subject, $body))
            {
                echo "Mail Sent Successfully";
            }
            else
            {
                echo "Mail Not Sent";
            }
		}
	}
}

$conn->close();	

?>