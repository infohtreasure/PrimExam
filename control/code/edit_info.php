<fieldset>
	<legend><i class="fa fa-pencil"></i> Confirm Candidate details</legend>
<form action="add_student3.php" method="post" role="form" enctype="multipart/form-data">

		<div class="form-group">
			<input type="text" disabled="disabled" name="user_firstname" id="user_firstname" required class="form-control" placeholder= "Candidate Firstname" value="<?php echo $user_firstname;?>">
			<input type="hidden" name="user_id" value="<?php echo $user_id;?>">
		</div>

		<div class="form-group">
			<input type="text" disabled="disabled" name="user_lastname" id="user_lastname" required class="form-control" placeholder= "Candidate Lastname" value="<?php echo $user_lastname;?>">
		</div>

		<div class="form-group">
			<input type="text" disabled="disabled" name="user_passport" id="user_passport" required class="form-control" placeholder= "Candidate Image" value="<?php echo $user_passport;?>">
		</div>
	    <div class="form-group">
	    	<input type="file" name="picture" id="exampleInputFile" accept="image/*">
	    </div>

		<div class="form-group">
			<input type="submit" name="ok" id="ok" value="upload image" class="btn btn-info">
			<a href="camera.php" class="btn btn-success"><i class="" aria-hidden="true">next</i></a>
		</div>

	</form>

	<div class="" style="display:none;" id="indicator">
		<img src="img/ajax-loader.gif"> Please wait
	</div>
</fieldset>
