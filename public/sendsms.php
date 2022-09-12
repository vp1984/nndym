<?php
	/*include("includes/connection.php");
	$obj = new myclass;*/
	$user = "wantasan_leads";
	$pass = "wasVWSleads!@#";
	$server = "localhost";
	$dbase = "wantasan_leads";
		  	
	$conn = new mysqli($server, $user, $pass,$dbase) or die("Connect failed: %s\n". $conn -> error);
	$SelectLeads = $conn->query("SELECT * FROM registration");
	
	if ($SelectLeads->num_rows > 0) 
	{
		// output data of each row
		while($row = $SelectLeads->fetch_assoc()) {
			//echo "id: " . $row["id"]. " - Name: " . $row["name"]. " " . $row["mobile_number"]. "<br>";
			// Account details
			$username = 'wantasanta';
			$apiKey = '3D42A-AD7AD';
			$apiRequest = 'Text';
			$numbers = $row["mobile_number"];
			$sender = 'WSANTA';
			$message = nl2br("Hi ".$row["name"].", Thank you for registering with Want A Santa. Surprise your child this Christmas. Book trained, authentic Santas and elves for a home visit or a Christmas party for a magical Christmas experience. To know more visit www.wantasanta.com");
			
			// Route details
			$apiRoute = 'DND';
			// Prepare data for POST request
			$data = 'username='.$username.'&apikey='.$apiKey.'&apirequest='.$apiRequest.'&route='.$apiRoute.'&mobile='.$numbers.'&sender='.$sender."&message=".$message;
			// Send the GET request with cURL
			$url = 'http://www.alots.in/sms-panel/api/http/index.php?'.$data;
			$url = preg_replace("/ /", "%20", $url);
			$response = file_get_contents($url);
			// Process your response here
			echo $response."<br>";	
		}
	} else {
		echo "0 results";
	}
	$conn->close();
?>
