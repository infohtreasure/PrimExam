$(document).ready(function() {
	
//login toogle

	$("#stu_log").click(function(event) {
		/* Act on the event */

		//change login_type text

		$("#login-type").text("Student Login");

		$("#parent_form").hide('fast');
		$("#teacher_form").hide('fast');
		$("#student_form").show('fast');
		$("#subject_teacher_form").hide('fast');

		//console.log("hey");
	});

	
	$("#parent_log").click(function(event) {
		/* Act on the event */

		//change login_type text

		$("#login-type").text("Parent Login");

		$("#teacher_form").hide('fast');
		$("#student_form").hide('fast');
		$("#parent_form").show('fast');
		$("#subject_teacher_form").hide('fast');

		//console.log("hey");
	});

	$("#teacher_log").click(function(event) {
		/* Act on the event */

		//change login_type text

		$("#login-type").text("Teacher Login");

		$("#parent_form").hide('fast');
		$("#student_form").hide('fast');
		$("#teacher_form").show('fast');
		$("#subject_teacher_form").hide('fast');

		//console.log("hey");
	});

	$("#subject_log").click(function(event) {
		/* Act on the event */

		//change login_type text

		$("#login-type").text("Subject Teacher Login");

		$("#parent_form").hide('fast');
		$("#student_form").hide('fast');
		$("#teacher_form").hide('fast');
		$("#subject_teacher_form").show('fast');

		//console.log("hey");
	});



});