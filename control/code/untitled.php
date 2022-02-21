<form action="" method="get">
		<div class="form-group">
				<select name="tid" required class="form-control" data-placeholder="Select candidate and take picture" id="teacher" data-rel="chosen">
                    <option value=""></option>
                        <optgroup label="Select candidate and edit">
					    	<?php
					    		$con = mysql_connect("localhost","htreasur_prime","~6O?oQ;p=A[5");
    $db = mysql_select_db("htreasur_primexam",$con);
    
					     				$get=mysql_query("SELECT user_id, user_firstname, user_lastname, user_passport FROM prime_users ORDER BY user_id ASC");
					    						$option = '';
						     while($row = mysql_fetch_assoc($get))
						    {
						      echo "<option value='".$row['user_id']."'>".$row['user_firstname']." ".$row['user_lastname']."</option>";
						    }
						    ?>
						</optgroup>
				</select>
		</div>
			<div class="form-group">
				<button class="btn btn-primary">Edit</button>
			</div>
	</form>