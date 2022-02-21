<?php
//============================================================+
// File name   : prime_popup_test_info.php
// Begin       : 2004-05-28
// Last Update : 2009-09-30
//
// Description : Outputs test information using popup page
//               headers.
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
//    Copyright (C) 2004-2010  Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Outputs test information using popup page headers.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2004-05-28
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_ADMIN_RESULTS;
$thispage_title = $l['t_test_info'];
$thispage_description = $l['hp_test_info'];
require_once('../../shared/code/prime_authorization.php');

require_once('../code/prime_page_header_popup.php');

echo '<div class="popupcontainer">'.K_NEWLINE;

if (isset($_REQUEST['testid']) AND ($_REQUEST['testid'] > 0)) {
	$test_id = intval($_REQUEST['testid']);
	// check user's authorization
	if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
		F_print_error('ERROR', $l['m_authorization_denied']);
		exit;
	}
	require_once('../../shared/code/prime_functions_test.php');
	echo F_printTestInfo($test_id, true);
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
