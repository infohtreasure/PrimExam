<?php
//============================================================+
// File name   : prime_test_start.php
// Begin       : 2010-02-06
// Last Update : 2012-12-04
//
// Description : Display selected test description and buttons
//               to start or cancel the test.
//
// Author: Ifeoluwa Opeyemi O
//
// (c) Copyright:
//               Ifeoluwa Opeyemi O
//               Hidden Tresure Computers Ltd
//               www.htreasure.com
//               info@htreasure.com
//
// License:
//    Copyright (C) 2004-2012  Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Display selected test description and buttons to start or cancel the test.
 * @package com.htreasure.primexam/exam
 * @author Ifeoluwa Opeyemi O
 * @since 2010-02-06
 */

/**
 */

require_once('../config/prime_config.php');

$test_id = 0;
$pagelevel = K_AUTH_PUBLIC_TEST_EXECUTE;
$thispage_title = $l['t_test_info'];
$thispage_description = $l['hp_test_info'];
require_once('../../shared/code/prime_authorization.php');
require_once('../code/prime_page_header.php');

echo '<div class="popupcontainer">'.K_NEWLINE;
if (isset($_REQUEST['testid']) AND ($_REQUEST['testid'] > 0)) {
	require_once('../../shared/code/prime_functions_test.php');
	$test_id = intval($_REQUEST['testid']);
	echo F_printTestInfo($test_id, false);
	echo '<br />'.K_NEWLINE;
	echo '<div class="row">'.K_NEWLINE;
	// display execute button
	echo '<a href="prime_test_execute.php?testid='.$test_id.'';
	if (isset($_REQUEST['repeat']) AND ($_REQUEST['repeat'] == 1)) {
		echo '&amp;repeat=1';
	}
	echo '" title="'.$l['h_execute'].'" class="xmlbutton">'.$l['w_execute'].'</a> ';
	echo '<a href="index.php" title="'.$l['h_cancel'].'" class="xmlbutton">'.$l['w_cancel'].'</a>';
	echo '</div>'.K_NEWLINE;
}
echo '</div>'.K_NEWLINE;

require_once('../code/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
