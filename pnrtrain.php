<?php
	session_start();
	
	
    echo "USERNAME :".$_SESSION['uname'];

	$servername = "localhost:3306";
	$username = "root";
	$password = "root";
	$dbname = "userdatabase";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} 

$trainno = $_SESSION['trainno'];
 
$sql = "INSERT INTO pnrtable (TrainId,Username,TravelDate,Fare) select t.TrainId,'".$_SESSION['uname']."','".$_SESSION['traveldate']."','".$_SESSION['fare']."' from traininfo t where t.TrainNo = '".$trainno."'";

$result = mysqli_query($conn, $sql);

if($result === TRUE){

	foreach($_SESSION['Pname'] as $a => $b){ 

	     echo $_SESSION['Pname'][$a];
	     echo $_SESSION['Page'][$a];
	     echo $_SESSION['Pgender'][$a];
	      
	      echo $_SESSION['from'];
	      echo $_SESSION['to'];
	     echo "   ";           
	  
	  	$Pname = mysqli_escape_string($conn,$_SESSION['Pname'][$a]);
	  	$Page = mysqli_escape_string($conn,$_SESSION['Page'][$a]);
 	  	$Pgender = mysqli_escape_string($conn,$_SESSION['Pgender'][$a]);	
        

        echo $Pname;
        echo $Page;
        echo $Pgender;
        

	$sql1 = "INSERT INTO train_pnr (TrainId,PnrNo,PassengerName,PassengerGender,PassengerAge,SourceStation,DestStation,TravelDate,PnrStatus) select p.TrainId,max(p.PnrNo),'$Pname','$Pgender','$Page','".$_SESSION['from']."','".$_SESSION['to']."','".$_SESSION['traveldate']."','CONFIRM' from pnrtable p where p.TrainId = (select TrainId from traininfo where TrainNo = '".$trainno."') and p.TravelDate like '".$_SESSION['traveldate']."' and p.Username = '".$_SESSION['uname']."' limit 1";

	$result1 = mysqli_query($conn, $sql1);		
			
	}

	if (mysqli_affected_rows($conn) >0 ) {
			echo "<script> alert('TICKET BOOKED Successfully');
			window.location.href='ticketformat.php';
	 </script>";
	} 
	else {
			echo "<script> alert('Record Creation  Unsuccessfull') </script>";
	}

}
else{
      echo "<script> alert('Sorry  Unsuccessfull') </script>";
}



$conn->close();

?>
