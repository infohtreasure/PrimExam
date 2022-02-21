<?php
//============================================================+
// File name   : prime_email_results.php
// Begin       : 2005-02-24
// Last Update : 2014-01-27
//
// Description : Interface to send test reports to users via
//               email.
//
// Author: Ifeoluwa Opeyemi O
//
// (c) Copyright:
//               Ifeoluwa Opeyemi O
//               htreasure.com LTD
//               www.htreasure.com
//               info@htreasure.com
//
// License:
//    Copyright (C) 2004-2014  Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Interface to send email test reports to users.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2005-02-24
 */

 /**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
$thispage_title = $l['t_email_result'];
$thispage_description = $l['hp_email_result'];
require_once('../../shared/code/prime_authorization.php');
require_once('prime_functions_user_select.php');

require_once('../code/prime_page_header.php');

echo '<div class="popupcontainer">'.K_NEWLINE;

if (isset($_REQUEST['test_id']) AND ($_REQUEST['test_id'] > 0)) {
	$test_id = intval($_REQUEST['test_id']);
	// check user's authorization
	if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
		F_print_error('ERROR', $l['m_authorization_denied']);
		echo '</div>'.K_NEWLINE;
		require_once('../code/prime_page_footer.php');
		exit;
	}
} else {
	$test_id = 0;
}
if (isset($_REQUEST['user_id'])) {
	$user_id = intval($_REQUEST['user_id']);
} else {
	$user_id = 0;
}
if (isset($_REQUEST['testuser_id']) AND ($_REQUEST['testuser_id'] > 0)) {
	$testuser_id = intval($_REQUEST['testuser_id']);
} else {
	$testuser_id = 0;
}
if (isset($_REQUEST['group_id']) AND !empty($_REQUEST['group_id'])) {
	$group_id = intval($_REQUEST['group_id']);
} else {
	$group_id = 0;
}
// filtering options
if (isset($_REQUEST['startdate'])) {
	$startdate = $_REQUEST['startdate'];
	$startdate_time = strtotime($startdate);
	$startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
} else {
	$startdate = '';
}
if (isset($_REQUEST['enddate'])) {
	$enddate = $_REQUEST['enddate'];
	$enddate_time = strtotime($enddate);
	$enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
} else {
	$enddate = '';
}
if (isset($_REQUEST['mode']) AND ($_REQUEST['mode'] > 0)) {
	$mode = intval($_REQUEST['mode']);
} else {
	$mode = 0;
}

if (isset($_REQUEST['display_mode'])) {
	$display_mode = max(0, min(5, intval($_REQUEST['display_mode'])));
} else {
	$display_mode = 0;
}
if (isset($_REQUEST['show_graph'])) {
	$show_graph = intval($_REQUEST['show_graph']);
	if ($show_graph AND ($display_mode == 0)) {
		$display_mode = 1;
	}
} else {
	$show_graph = 0;
}

require_once('prime_functions_email_reports.php');
echo '<div class="pagehelp">'.$l['hp_sending_in_progress'].'</div>'.K_NEWLINE;
flush(); // force browser output
F_send_report_emails($test_id, $user_id, $testuser_id, $group_id, $startdate, $enddate, $mode, $display_mode, $show_graph);
F_print_error('MESSAGE', $l['m_process_completed']);

echo '</div>'.K_NEWLINE;
require_once('../code/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
