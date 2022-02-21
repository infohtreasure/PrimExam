<?php
//============================================================+
// File name   : prime_popup_test_info.php
// Begin       : 2004-05-28
// Last Update : 2010-09-17
//
// Description : Output test information using popup page
//               headers.
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
//    Copyright (C) 2004-2010  Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Output test information using popup page headers.
 * @package com.htreasure.primexam/exam
 * @author Ifeoluwa Opeyemi O
 * @since 2004-05-28
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_PUBLIC_TEST_INFO;
$thispage_title = $l['t_test_info'];
$thispage_description = $l['hp_test_info'];
require_once('../../shared/code/prime_authorization.php');

require_once('../code/prime_page_header_popup.php');

echo '<div class="popupcontainer">'.K_NEWLINE;
if (isset($_REQUEST['testid']) AND ($_REQUEST['testid'] > 0)) {
	require_once('../../shared/code/prime_functions_test.php');
	echo F_printTestInfo(intval($_REQUEST['testid']), false);
}

echo '<div class="row">'.K_NEWLINE;
require_once('../../shared/code/prime_functions_form.php');
echo F_close_button();
echo '</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/prime_page_footer_popup.php');

//============================================================+
// END OF FILE
//============================================================+
