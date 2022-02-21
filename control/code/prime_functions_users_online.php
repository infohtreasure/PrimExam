<?php
//============================================================+
// File name   : prime_functions_levels.php
// Begin       : 2001-10-18
// Last Update : 2011-05-24
//
// Description : Functions to display online users' data.
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
 * Functions to display online users' data.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2001-10-18
 */

/**
 * Display online users form using F_list_online_users function.
 * @author Ifeoluwa Opeyemi O
 * @since 2001-10-18
 * @param $wherequery (string) users selection query
 * @param $order_field (string) order by column name
 * @param $orderdir (string) oreder direction
 * @param $firstrow (string) number of first row to display
 * @param $rowsperpage (string) number of rows per page
 * @return false in case of empty database, true otherwise
 */
function F_show_online_users($wherequery, $order_field, $orderdir, $firstrow, $rowsperpage) {
	global $l;
	require_once('../config/prime_config.php');
	F_list_online_users($wherequery, $order_field, $orderdir, $firstrow, $rowsperpage);
	return true;
}

/**
 * Display online users.
 * @author Ifeoluwa Opeyemi O
 * @since 2001-10-18
 * @param $wherequery (string) users selection query
 * @param $order_field (string) order by column name
 * @param $orderdir (int) oreder direction
 * @param $firstrow (int) number of first row to display
 * @param $rowsperpage (int) number of rows per page
 * @return false in case of empty database, true otherwise
 */
function F_list_online_users($wherequery, $order_field, $orderdir, $firstrow, $rowsperpage) {
	global $l, $db;
	require_once('../config/prime_config.php');
	require_once('../../shared/code/prime_functions_page.php');
	require_once('prime_functions_user_select.php');
	
	//initialize variables
	$orderdir = intval($orderdir);
	$firstrow = intval($firstrow);
	$rowsperpage = intval($rowsperpage);
	
	// order fields for SQL query
	if (empty($order_field) OR (!in_array($order_field, array('cpsession_id', 'cpsession_data')))) {
		$order_field = 'cpsession_expiry';
	}
	if($orderdir == 0) {
		$nextorderdir = 1;
		$full_order_field = $order_field;
	} else {
		$nextorderdir = 0;
		$full_order_field = $order_field.' DESC';
	}

	if(!F_count_rows(K_TABLE_SESSIONS)) { //if the table is void (no items) display message
		echo '<h2>'.$l['m_databasempty'].'</h2>';
		return FALSE;
	}

	if (empty($wherequery)) {
		$sql = 'SELECT * FROM '.K_TABLE_SESSIONS.' ORDER BY '.$full_order_field.'';
	} else {
		$wherequery = F_escape_sql($db, $wherequery);
		$sql = 'SELECT * FROM '.K_TABLE_SESSIONS.' '.$wherequery.' ORDER BY '.$full_order_field.'';
	}
	if (K_DATABASE_TYPE == 'ORACLE') {
		$sql = 'SELECT * FROM ('.$sql.') WHERE rownum BETWEEN '.$firstrow.' AND '.($firstrow + $rowsperpage).'';
	} else {
		$sql .= ' LIMIT '.$rowsperpage.' OFFSET '.$firstrow.'';
	}

	echo '<div class="container">'.K_NEWLINE;
	echo '<table class="userselect">'.K_NEWLINE;
	echo '<tr>'.K_NEWLINE;
	echo '<th>'.$l['w_user'].'</th>'.K_NEWLINE;
	echo '<th>'.$l['w_level'].'</th>'.K_NEWLINE;
	echo '<th>'.$l['w_ip'].'</th>'.K_NEWLINE;
	echo '<th>'.$l['w_ip'].'</th>'.K_NEWLINE;
	echo '</tr>'.K_NEWLINE;

	if($r = F_db_query($sql, $db)) {
		while($m = F_db_fetch_array($r)) {

			$this_session = F_session_string_to_array($m['cpsession_data']);
			echo '<tr>';
			echo '<td align="left">';
			$user_str = '';
			if ($this_session['session_user_lastname']) {
				$user_str .= urldecode($this_session['session_user_lastname']).', ';
			}
			if ($this_session['session_user_firstname']) {
				$user_str .= urldecode($this_session['session_user_firstname']).'';
			}
			$user_str .= ' ('.urldecode($this_session['session_user_name']).')';
			if (F_isAuthorizedEditorForUser($this_session['session_user_id'])) {
				echo '<a href="prime_edit_user.php?user_id='.$this_session['session_user_id'].'">'.$user_str.'</a>';
			} else {
				echo $user_str;
			}
			echo '</td>';
			echo '<td>'.$this_session['session_user_level'].'</td>';
			echo '<td>'.$this_session['session_user_ip'].'</td>';
			echo '<td>'.$this_session['session_user_id'].'</td>';
			echo '</tr>'.K_NEWLINE;
		}
	} else {
		F_display_db_error();
	}
	echo '</table>'.K_NEWLINE;

	// --- ------------------------------------------------------
	// --- page jump
	if ($rowsperpage > 0) {
		$sql = 'SELECT count(*) AS total FROM '.K_TABLE_SESSIONS.' '.$wherequery.'';
		if (!empty($order_field)) {$param_array = '&amp;order_field='.urlencode($order_field).'';}
		if (!empty($orderdir)) {$param_array .= '&amp;orderdir='.$orderdir.'';}
		$param_array .= '&amp;submitted=1';
		F_show_page_navigator($_SERVER['SCRIPT_NAME'], $sql, $firstrow, $rowsperpage, $param_array);
	}
	echo '<div class="pagehelp">'.$l['hp_online_users'].'</div>'.K_NEWLINE;
	echo '</div>'.K_NEWLINE;
	return TRUE;
}

//============================================================+
// END OF FILE
//============================================================+
