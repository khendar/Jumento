<?php

		include ('functions.php');
	  	if (!empty($_POST['submit']) ) {
			$sender_first = $_POST['first'];
			$sender_last = $_POST['last'];
			$sender_email = $_POST['email'];
			if (!check_email($sender_email))
				echo 'Invalid email Address: Please reenter email address';
			$sender_address =$_POST['address'];
			$sender_comm = $_POST['comments'];
			$body="Comments:\n $sender_comm \n\n Sender Address: \n$sender_address";
			$sendto="khendar@gmail.com";
			mail($sendto,  "NRG-PC Enquiries",$body, "From:$sender_first $sender_last <$sender_email>");
			echo "<p>The information that you send off was: <br \>\n";
			echo "<strong>Name:</strong> $sender_last, $sender_first <br \>\n";
			echo "<strong>Email:</strong> $sender_email <br \>\n";
			echo "<strong>Address:</strong> $sender_address <br \>\n";
			echo "<strong>Comments:</strong> $sender_comm <br \>\n</p>";
			echo $sendto;
		
}
		
		
	  ?>
	 

	  		
