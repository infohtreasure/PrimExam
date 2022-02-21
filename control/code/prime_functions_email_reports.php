<?php
//============================================================+
// File name   : prime_functions_email_reports.php
// Begin       : 2005-02-24
// Last Update : 2014-01-27
//
// Description : Sends email test reports to users.
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
//    Copyright (C) 2004-2014 Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Functions to send email reports to users.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2005-02-24
 */

/**
 * Sends email test reports to users.
 * @author Ifeoluwa Opeyemi O
 * @since 2005-02-24
 * @param $test_id (int) TEST ID
 * @param $user_id (int) USER ID (0 means all users)
 * @param $testuser_id (int) test-user ID - if greater than zero, filter stats for the specified test-user.
 * @param $group_id (int) GROUP ID (0 means all groups)
 * @param $startdate (int) start date ID - if greater than zero, filter stats for the specified starting date
 * @param $enddate (int) end date ID - if greater than zero, filter stats for the specified ending date
 * @param $mode (int) type of report to send: 0=detailed report; 1=summary report (without questions)
 * @param $display_mode display (int) mode: 0 = disabled; 1 = minimum; 2 = module; 3 = subject; 4 = question; 5 = answer.
 * @param $show_graph (boolean) If true display the score graph.
 */
function F_send_report_emails($test_id, $user_id=0, $testuser_id=0, $group_id=0, $startdate=0, $enddate=0, $mode=0, $display_mode=1, $show_graph=false) {
	global $l, $db;
	require_once('../config/prime_config.php');
	require_once('../../shared/code/prime_functions_test.php');
	require_once('../../shared/code/prime_functions_test_stats.php');
	require_once('../../shared/code/prime_class_mailer.php');
	require_once('prime_functions_user_select.php');

	$mode = intval($mode);
	if ($test_id > 0) {
		$test_id = intval($test_id);
		if (!F_isAuthorizedUser(K_TABLE_TESTS, 'test_id', $test_id, 'test_user_id')) {
			return;
		}
	} else {
		$test_id = 0;
	}
	if ($user_id > 0) {
		$user_id = intval($user_id);
	} else {
		$user_id = 0;
	}
	if ($testuser_id > 0) {
		$testuser_id = intval($testuser_id);
	} else {
		$testuser_id = 0;
	}
	if ($group_id > 0) {
		$group_id = intval($group_id);
	} else {
		$group_id = 0;
	}
	if (!empty($startdate)) {
		$startdate_time = strtotime($startdate);
		$startdate = date(K_TIMESTAMP_FORMAT, $startdate_time);
	} else {
		$startdate = '';
	}
	if (!empty($enddate)) {
		$enddate_time = strtotime($enddate);
		$enddate = date(K_TIMESTAMP_FORMAT, $enddate_time);
	} else {
		$enddate = '';
	}

	// Instantiate C_mailer class
	$mail = new C_mailer;

	//Load default values
	$mail->language = $l;
	$mail->Priority = $emailcfg['Priority'];
	$mail->ContentType = $emailcfg['ContentType'];
	$mail->Encoding = $emailcfg['Encoding'];
	$mail->WordWrap = $emailcfg['WordWrap'];
	$mail->Mailer = $emailcfg['Mailer'];
	$mail->Sendmail = $emailcfg['Sendmail'];
	$mail->UseMSMailHeaders = $emailcfg['UseMSMailHeaders'];
	$mail->Host = $emailcfg['Host'];
	$mail->Port = $emailcfg['Port'];
	$mail->Helo = $emailcfg['Helo'];
	$mail->SMTPAuth = $emailcfg['SMTPAuth'];
	$mail->SMTPSecure = $emailcfg['SMTPSecure'];
	$mail->Username = $emailcfg['Username'];
	$mail->Password = $emailcfg['Password'];
	$mail->Timeout = $emailcfg['Timeout'];
	$mail->SMTPDebug = $emailcfg['SMTPDebug'];
	$mail->PluginDir = $emailcfg['PluginDir'];
	$mail->Sender = $emailcfg['Sender'];
	$mail->From = $emailcfg['From'];
	$mail->FromName = $emailcfg['FromName'];
	if ($emailcfg['Reply']) {
		$mail->AddReplyTo($emailcfg['Reply'], $emailcfg['ReplyName']);
	}
	$mail->CharSet = $l['a_meta_charset'];
	if (!$mail->CharSet) {
		$mail->CharSet = $emailcfg['CharSet'];
	}
	$mail->Subject = $l['t_result_user'];
	$mail->IsHTML(TRUE); // Set message type to HTML.

	$email_num = 0; // count emails;
	
	// get all data
	$data = F_getAllUsersTestStat($test_id, $group_id, $user_id, $startdate, $enddate, 'total_score', false, $display_mode);

	foreach ($data['testuser'] as $tu) {
		if (strlen($tu['user_email']) > 3) {

			// set HTML header
			$mail->Body = $emailcfg['MsgHeader'];
			// compose alternate TEXT message
			$mail->AltBody = ''.$l['t_result_user'].' ['.$tu['testuser_creation_time'].']'.K_NEWLINE;
			$mail->AltBody .= $l['w_test'].': '.$tu['test']['test_name'].K_NEWLINE;

			$passmsg = '';
			if ($tu['test']['test_score_threshold'] > 0) {
				$mail->AltBody .= $l['w_test_score_threshold'].': '.$tu['test']['test_score_threshold'];
				if ($tu['total_score'] >= $tu['test']['test_score_threshold']) {
					$passmsg = ' - '.$l['w_passed'];
				} else {
					$passmsg = ' - '.$l['w_not_passed'];
				}
				$mail->AltBody .= K_NEWLINE;
			}

			$mail->AltBody .= $l['w_score'].': '.F_formatFloat($tu['total_score']).' '.F_formatPercentage($tu['total_score_perc'], false).$passmsg.K_NEWLINE;
			if ($display_mode > 0) {	
				$mail->AltBody .= $l['w_answers_right'].': '.$tu['right'].'&nbsp;'.F_formatPercentage($tu['right_perc'], false).K_NEWLINE;
				$mail->AltBody .= $l['w_answers_wrong'].': '.$tu['wrong'].'&nbsp;'.F_formatPercentage($tu['wrong_perc'], false).K_NEWLINE;
				$mail->AltBody .= $l['w_questions_unanswered'].': '.$tu['unanswered'].'&nbsp;'.F_formatPercentage($tu['unanswered_perc'], false).K_NEWLINE;
				$mail->AltBody .= $l['w_questions_undisplayed'].': '.$tu['undisplayed'].'&nbsp;'.F_formatPercentage($tu['undisplayed_perc'], false).K_NEWLINE;
			}

			if ($mode == 0) {
				$pdfkey = getPasswordHash(date('Y').$tu['id'].K_RANDOM_SECURITY.$tu['test']['test_id'].date('m').$tu['user_id']);
				// create PDF doc
				$mode = 3;
				$pdf_content = file_get_contents(K_PATH_HOST.K_PATH_primexam.'control/code/prime_pdf_results.php?mode='.$mode.'&diplay_mode='.$display_mode.'&show_graph='.$show_graph.'&test_id='.$tu['test']['test_id'].'&user_id='.$tu['user_id'].'&testuser_id='.$tu['id'].'&email='.$pdfkey);
				// set PDF document file name
				$doc_name = 'primexam_report';
				$doc_name .= '_'.$mode;
				$doc_name .= '_0';
				$doc_name .= '_'.$tu['test']['test_id'];
				$doc_name .= '_0';
				$doc_name .= '_'.$tu['user_id'];
				$doc_name .= '_'.$tu['id'];
				$doc_name .= '.pdf';

				// attach document
				$mail->AddStringAttachment($pdf_content, $doc_name, $emailcfg['AttachmentsEncoding'], 'application/octet-stream');
				$mail->AltBody .= K_NEWLINE.$l['w_attachment'].': '.$doc_name.K_NEWLINE;
			}

			// convert alternate text to HTML
			$mail->Body .= str_replace(K_NEWLINE, '<br />'.K_NEWLINE, $mail->AltBody);

			// add HTML footer
			$mail->Body .= $emailcfg['MsgFooter'];

			//--- Elaborate user Templates ---
			$mail->Body = str_replace('#CHARSET#', $l['a_meta_charset'], $mail->Body);
			$mail->Body = str_replace('#LANG#', $l['a_meta_language'], $mail->Body);
			$mail->Body = str_replace('#LANGDIR#', $l['a_meta_dir'], $mail->Body);
			$mail->Body = str_replace('#EMAIL#', $tu['user_email'], $mail->Body);
			$mail->Body = str_replace('#USERNAME#', htmlspecialchars($tu['user_name'], ENT_NOQUOTES, $l['a_meta_charset']), $mail->Body);
			$mail->Body = str_replace('#USERFIRSTNAME#', htmlspecialchars($tu['user_firstname'], ENT_NOQUOTES, $l['a_meta_charset']), $mail->Body);
			$mail->Body = str_replace('#USERLASTNAME#', htmlspecialchars($tu['user_lastname'], ENT_NOQUOTES, $l['a_meta_charset']), $mail->Body);

			// add a "To" address
			$mail->AddAddress($tu['user_email'], $tu['user_name']);

			$email_num++;
			$progresslog = ''.$email_num.'. '.$tu['user_email'].' ['.$tu['user_name'].']'; //output user data

			if (!$mail->Send()) { //send email to user
				$progresslog .= ' ['.$l['t_error'].']'; //display error message
			}

			$mail->ClearAddresses(); // Clear all addresses for next loop
			$mail->ClearAttachments(); // Clears all previously set filesystem, string, and binary attachments
		} else {
			$progresslog = '['.$l['t_error'].'] '.$tu['user_name'].': '.$l['m_unknown_email'].''; //output user data
		}
		echo $progresslog.'<br />'.K_NEWLINE; //output processed emails
		flush(); // force browser output
	}

 	$mail->ClearAddresses(); // Clear all addresses for next loop
	$mail->ClearCustomHeaders(); // Clears all custom headers
	$mail->ClearAllRecipients(); // Clears all recipients assigned in the TO, CC and BCC
 	$mail->ClearAttachments(); // Clears all previously set filesystem, string, and binary attachments
	$mail->ClearReplyTos(); // Clears all recipients assigned in the ReplyTo array
	return;
}

//============================================================+
// END OF FILE
//============================================================+
