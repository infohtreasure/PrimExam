<?php
//============================================================+
// File name   : prime_user_change_email.php
// Begin       : 2010-09-17
// Last Update : 2012-06-07
//
// Description : Form to change user email
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
//    Copyright (C) 2004-2012 Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Form to change user email
 * @package com.htreasure.primexam/exam
 * @author Ifeoluwa Opeyemi O
 * @since 2010-09-17
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_USER_CHANGE_EMAIL;
$thispage_title = $l['t_user_change_email'];
require_once('../../shared/code/prime_authorization.php');
require_once('../../shared/code/prime_functions_form.php');
require_once('../code/prime_page_header.php');

$user_id = intval($_SESSION['session_user_id']);

// process submited data
switch($menu_mode) {

	case 'update':{ // Update user
		if ($formstatus = F_check_form_fields()) {
			// check password
			if (!empty($user_email) OR !empty($user_email_repeat)) {
				if($user_email != $user_email_repeat) {
					//print message and exit
					F_print_error('WARNING', $l['m_different_emails']);
					$formstatus = FALSE;
					F_stripslashes_formfields();
					break;
				}
			}
			mt_srand((double) microtime() * 1000000);
			$user_verifycode = md5(uniqid(mt_rand(), true)); // verification code
			$sql = 'UPDATE '.K_TABLE_USERS.' SET
				user_email=\''.F_escape_sql($db, $user_email).'\',
				user_level=\'0\',
				user_verifycode=\''.$user_verifycode.'\'
				WHERE user_id='.$user_id.' AND user_password=\''.getPasswordHash($currentpassword).'\'';
			if (!$r = F_db_query($sql, $db)) {
				F_display_db_error(false);
			} else {
				F_print_error('MESSAGE', $l['m_email_updated']);
				// require email confirmation
				require_once('../../shared/code/prime_functions_user_registration.php');
				F_send_user_reg_email($user_id, $user_email, $user_verifycode);
				F_print_error('MESSAGE', $user_email.': '.$l['m_user_verification_sent']);
				echo '<div class="container">'.K_NEWLINE;
				echo '<strong><a href="index.php" title="'.$l['h_index'].'">'.$l['h_index'].' &gt;</a></strong>'.K_NEWLINE;
				echo '</div>'.K_NEWLINE;
				require_once('prime_page_footer.php');
				exit;
			}
		}
		break;
	}

	default :{
		break;
	}

} //end of switch

echo '<div class="container">'.K_NEWLINE;

echo '<div class="gsoformbox">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_editor">'.K_NEWLINE;

echo getFormRowTextInput('user_email', $l['w_new_email'], $l['h_email'], '', '', '^([a-zA-Z0-9_\.\-]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([a-zA-Z0-9\-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$', 255, false, false, false, '');
echo getFormRowTextInput('user_email_repeat', $l['w_new_email'], $l['h_email'], ' ('.$l['w_repeat'].')', '', '', 255, false, false, false, '');
echo getFormRowTextInput('currentpassword', $l['w_password'], $l['h_password'], '', '', '', 255, false, false, true, '');

echo '<div class="row">'.K_NEWLINE;

F_submit_button('update', $l['w_update'], $l['h_update']);

// comma separated list of required fields
echo '<input type="hidden" name="ff_required" id="ff_required" value="user_email,user_email_repeat" />'.K_NEWLINE;
echo '<input type="hidden" name="ff_required_labels" id="ff_required_labels" value="'.htmlspecialchars($l['w_email'].','.$l['w_email'], ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '</form>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;


echo '<div class="pagehelp">'.$l['hp_user_change_email'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once(dirname(__FILE__).'/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
