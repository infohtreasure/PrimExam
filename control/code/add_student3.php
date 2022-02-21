<?php
    $con = mysql_connect("localhost","htreasur_prime","~6O?oQ;p=A[5");
    $db = mysql_select_db("htreasur_primexam",$con);
    $time =  time();
    $thankyou="camera.php";
	if (isset($_POST['ok'])) {
		# code...
		extract($_POST);
		if ( (isset($_FILES['picture'])) and ($_FILES['picture']['name'] != "") ) {
			# code...
			//print_r($_FILES['picture']);
			//delete prev file
			$prev_file = mysql_query("SELECT user_passport FROM prime_users WHERE user_id='$user_id'") or die(mysql_error());
			$prev_file = mysql_fetch_assoc($prev_file);
			$prev_file2 = $prev_file['user_passport'];

			$link = "../../images/student_img/".$prev_file2;
			unlink($link);
			//exit();
			//upload new one

			$folder = "../../images/student_img/";
			$img = $_FILES['picture']['name'];
			$img = $time."_".basename($img);
			$destination = $folder.$img;
			$filename = $_FILES['picture']['tmp_name'];
			move_uploaded_file($filename, $destination);
			$up = "UPDATE prime_users SET user_passport='$img' WHERE user_id='$user_id'";
			mysql_query($up) or die(mysql_error());
			echo "Data Entered Successfully Saved!";

		}

		//insert new info

		//$update = "UPDATE prime_users SET gender='$gender' WHERE user_id='$user_id'";
		//mysql_query($update) or die(mysql_error());
		//$_SESSION['info'] = "Record updated successfully";
		//go("edit_student.php");
	}
?>
<script>location.replace('<?php echo $thankyou;?>')</script>