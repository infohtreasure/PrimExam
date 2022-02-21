<?php
//============================================================+
// File name   : prime_select_users_popup.php
// Begin       : 2012-04-14
// Last Update : 2012-08-22
//
// Description : Display user selection table on popup window.
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
//    Copyright (C) 2004-2012  Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Display user selection table on popup window.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2012-04-14
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_ADMIN_USERS;
require_once('../../shared/code/prime_authorization.php');

$thispage_title = $l['t_user_select'];

require_once('../code/prime_page_header_popup.php');
require_once('../../shared/code/prime_functions_form.php');
require_once('prime_functions_user_select.php');

if(!isset($order_field)) {$order_field='user_lastname,user_firstname';}
if(!isset($orderdir)) {$orderdir=0;}
if(!isset($firstrow)) {$firstrow=0;}
if(!isset($rowsperpage)) {$rowsperpage=K_MAX_ROWS_PER_PAGE;}
if(!isset($searchterms)) {$searchterms='';}
if(!isset($cid)) {$cid='';} else {$cid = preg_replace('/[^a-z0-9_]/', '', $cid);} // ID of the calling form field
if(!isset($uids)) {$uids='';} else {$uids = preg_replace('/[^x0-9]/', '', $uids);}  // selected user IDs
if(isset($_REQUEST['group_id'])) {
	$group_id = intval($_REQUEST['group_id']);
} else {
	$group_id = 0;
}
if (!F_isAuthorizedEditorForGroup($group_id)) {
	F_print_error('ERROR', $l['m_authorization_denied']);
	exit;
}

echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_userselect">'.K_NEWLINE;

echo '<input type="hidden" name="cid" id="cid" value="'.$cid.'" />'.K_NEWLINE;
echo '<input type="hidden" name="uids" id="uids" value="'.$uids.'" />'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="group_id">'.$l['w_group'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<select name="group_id" id="group_id" size="0" onchange="document.getElementById(\'form_userselect\').submit()">'.K_NEWLINE;

echo '<option value="0"';
if($group_id == 0) {
	echo ' selected="selected"';
}
echo '>&nbsp;</option>'.K_NEWLINE;
$sql = F_user_group_select_sql();
if($r = F_db_query($sql, $db)) {
	while($m = F_db_fetch_array($r)) {
		echo '<option value="'.$m['group_id'].'"';
		if($m['group_id'] == $group_id) {
			echo ' selected="selected"';
		}
		echo '>'.htmlspecialchars($m['group_name'], ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
	}
}
else {
	echo '</select></span></div>'.K_NEWLINE;
	F_display_db_error();
}
echo '</select>'.K_NEWLINE;

echo '<input type="text" name="searchterms" id="searchterms" value="'.htmlspecialchars($searchterms, ENT_COMPAT, $l['a_meta_charset']).'" size="20" maxlength="255" title="'.$l['w_search'].'" />';
F_submit_button('search', $l['w_search'], $l['w_search']);
echo '</span></div>'.K_NEWLINE;
// build a search query
$wherequery = '';
if (strlen($searchterms) > 0) {
	$terms = preg_split("/[\s]+/i", $searchterms); // Get all the words into an array
	foreach ($terms as $word) {
		$word = F_escape_sql($db, $word);
		$wherequery .= ' AND ((user_name LIKE \'%'.$word.'%\')';
		$wherequery .= ' OR (user_email LIKE \'%'.$word.'%\')';
		$wherequery .= ' OR (user_firstname LIKE \'%'.$word.'%\')';
		$wherequery .= ' OR (user_lastname LIKE \'%'.$word.'%\')';
		$wherequery .= ' OR (user_regnumber LIKE \'%'.$word.'%\')';
		$wherequery .= ' OR (user_passport LIKE \'%'.$word.'%\'))';
	}
	$wherequery = '('.substr($wherequery, 5).')';
}

// select only specified User IDs
if (isset($uids) AND !empty($uids)) {
	$uid_list = '';
	$uids = explode('x', $uids);
	foreach ($uids as $id) {
		$uid_list .= ','.intval($id);
	}
	if (!empty($uid_list)) {
		if (!empty($wherequery)) {
			$wherequery .= ' AND ';
		}
		$wherequery .= '(user_id IN ('.substr($uid_list, 1).'))';
	}
}

echo getFormNoscriptSelect();

echo '<div class="row"><hr /></div>'.K_NEWLINE;

F_show_select_user_popup($order_field, $orderdir, $firstrow, $rowsperpage, $group_id, $wherequery, $searchterms, $cid);

echo '</form>'.K_NEWLINE;

require_once('../code/prime_page_footer_popup.php');

//============================================================+
// END OF FILE
//============================================================+
