<?php
//============================================================+
// File name   : prime_edit_module.php
// Begin       : 2008-11-28
// Last Update : 2013-08-23
//
// Description : Display form to edit modules.
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
//    Copyright (C) 2004-2013 Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Display form to edit modules.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2008-11-28
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_ADMIN_MODULES;
require_once('../../shared/code/prime_authorization.php');

$thispage_title = $l['t_modules_editor'];
require_once('../code/prime_page_header.php');
require_once('../../shared/code/prime_functions_form.php');
require_once('../../shared/code/prime_functions_auth_sql.php');

// set default values
if(!isset($_REQUEST['module_enabled']) OR (empty($_REQUEST['module_enabled']))) {
	$module_enabled = false;
} else {
	$module_enabled = F_getBoolean($_REQUEST['module_enabled']);
}
if (isset($_REQUEST['module_name'])) {
	$module_name = utrim($_REQUEST['module_name']);
} else {
	$module_name = '';
}
if (isset($_REQUEST['module_user_id'])) {
	$module_user_id = intval($_REQUEST['module_user_id']);
} else {
	$module_user_id = intval($_SESSION['session_user_id']);
}

if (isset($_REQUEST['module_id']) AND ($_REQUEST['module_id'] > 0)) {
	$module_id = intval($_REQUEST['module_id']);
	// check user's authorization for module
	if (!F_isAuthorizedUser(K_TABLE_MODULES, 'module_id', $module_id, 'module_user_id')) {
		F_print_error('ERROR', $l['m_authorization_denied']);
		exit;
	}
} else {
	$module_id = 0;
}

switch($menu_mode) {

	case 'delete':{
		F_stripslashes_formfields();
		// check if this record is used (test_log)
		if(!F_check_unique(K_TABLE_SUBJECTS.','.K_TABLE_SUBJECT_SET, 'subjset_subject_id=subject_id AND subject_module_id='.$module_id.'')) {
			//this record will be only disabled and not deleted because it's used
			$sql = 'UPDATE '.K_TABLE_MODULES.' SET
				module_enabled=\'0\'
				WHERE module_id='.$module_id.'';
			if(!$r = F_db_query($sql, $db)) {
				F_display_db_error();
			}
			F_print_error('WARNING', $l['m_disabled_vs_deleted']);
		} else {
			// ask confirmation
			F_print_error('WARNING', $l['m_delete_confirm']);
			?>
			<div class="confirmbox">
			<form action="<?php echo $_SERVER['SCRIPT_NAME']; ?>" method="post" enctype="multipart/form-data" id="form_delete">
			<div>
			<input type="hidden" name="module_id" id="module_id" value="<?php echo $module_id; ?>" />
			<input type="hidden" name="module_name" id="module_name" value="<?php echo htmlspecialchars($module_name, ENT_COMPAT, $l['a_meta_charset']); ?>" />
			<?php
			F_submit_button('forcedelete', $l['w_delete'], $l['h_delete']);
			F_submit_button('cancel', $l['w_cancel'], $l['h_cancel']);
			?>
			</div>
			</form>
			</div>
		<?php
		}
		break;
	}

	case 'forcedelete':{
		F_stripslashes_formfields();
		if($forcedelete == $l['w_delete']) { //check if delete button has been pushed (redundant check)
			$sql = 'DELETE FROM '.K_TABLE_MODULES.' WHERE module_id='.$module_id.'';
			if(!$r = F_db_query($sql, $db)) {
				F_display_db_error(false);
			} else {
				$module_id=FALSE;
				F_print_error('MESSAGE', $module_name.': '.$l['m_deleted']);
			}
		}
		break;
	}

	case 'update':{ // Update
		// check if the confirmation chekbox has been selected
		if (!isset($_REQUEST['confirmupdate']) OR ($_REQUEST['confirmupdate'] != 1)) {
			F_print_error('WARNING', $l['m_form_missing_fields'].': '.$l['w_confirm'].' &rarr; '.$l['w_update']);
			F_stripslashes_formfields();
			break;
		}
		if($formstatus = F_check_form_fields()) {
			// check referential integrity (NOTE: mysql do not support "ON UPDATE" constraint)
			if(!F_check_unique(K_TABLE_SUBJECTS.','.K_TABLE_SUBJECT_SET, 'subjset_subject_id=subject_id AND subject_module_id='.$module_id.'')) {
				F_print_error('WARNING', $l['m_update_restrict']);

				// enable or disable record
				$sql = 'UPDATE '.K_TABLE_MODULES.' SET
					module_enabled=\''.intval($module_enabled).'\'
					WHERE module_id='.$module_id.'';
				if(!$r = F_db_query($sql, $db)) {
					F_display_db_error(false);
				} else {
					$strmsg = $l['w_record_status'].': ';
					if ($module_enabled) {
						$strmsg .= $l['w_enabled'];
					} else {
						$strmsg .= $l['w_disabled'];
					}
					F_print_error('MESSAGE', $strmsg);
				}

				$formstatus = FALSE;
				F_stripslashes_formfields();
				break;
			}
			// check if name is unique
			if(!F_check_unique(K_TABLE_MODULES, 'module_name=\''.F_escape_sql($db, $module_name).'\'', 'module_id', $module_id)) {
				F_print_error('WARNING', $l['m_duplicate_name']);
				$formstatus = FALSE;
				F_stripslashes_formfields();
				break;
			}
			if ($_SESSION['session_user_level'] >= K_AUTH_ADMINISTRATOR) {
				$module_user_id = intval($module_user_id);
			} else {
				$module_user_id = intval($_SESSION['session_user_id']);
			}
			$sql = 'UPDATE '.K_TABLE_MODULES.' SET
				module_name=\''.F_escape_sql($db, $module_name).'\',
				module_enabled=\''.intval($module_enabled).'\',
				module_user_id=\''.$module_user_id.'\'
				WHERE module_id='.$module_id.'';
			if(!$r = F_db_query($sql, $db)) {
				F_display_db_error(false);
			} else {
				F_print_error('MESSAGE', $l['m_updated']);
			}
		}
		break;
	}

	case 'add':{ // Add
		if($formstatus = F_check_form_fields()) {
			// check if name is unique
			if(!F_check_unique(K_TABLE_MODULES, 'module_name=\''.F_escape_sql($db, $module_name).'\'')) {
				F_print_error('WARNING', $l['m_duplicate_name']);
				$formstatus = FALSE; F_stripslashes_formfields();
				break;
			}
			if ($_SESSION['session_user_level'] >= K_AUTH_ADMINISTRATOR) {
				$module_user_id = intval($module_user_id);
			} else {
				$module_user_id = intval($_SESSION['session_user_id']);
			}
			$sql = 'INSERT INTO '.K_TABLE_MODULES.' (
				module_name,
				module_enabled,
				module_user_id
				) VALUES (
				\''.F_escape_sql($db, $module_name).'\',
				\''.intval($module_enabled).'\',
				\''.$module_user_id.'\'
				)';
			if(!$r = F_db_query($sql, $db)) {
				F_display_db_error(false);
			} else {
				$module_id = F_db_insert_id($db, K_TABLE_MODULES, 'module_id');
			}
		}
		break;
	}

	case 'clear':{ // Clear form fields
		$module_name = '';
		$module_enabled = true;
		$module_user_id = intval($_SESSION['session_user_id']);
		break;
	}

	default :{
		break;
	}

} //end of switch

// --- Initialize variables
if($formstatus) {
	if ($menu_mode != 'clear') {
		if(empty($module_id)) {
			$module_id = 0;
			$module_name = '';
			$module_enabled = true;
			$module_user_id = intval($_SESSION['session_user_id']);
		} else {
			$sql = F_select_modules_sql('module_id='.$module_id).' LIMIT 1';
			if($r = F_db_query($sql, $db)) {
				if($m = F_db_fetch_array($r)) {
					$module_id = $m['module_id'];
					$module_name = $m['module_name'];
					$module_enabled = F_getBoolean($m['module_enabled']);
					$module_user_id = intval($m['module_user_id']);
				} else {
					$module_name = '';
					$module_enabled = true;
					$module_user_id = intval($_SESSION['session_user_id']);
				}
			} else {
				F_display_db_error();
			}
		}
	}
}

echo '<div class="container">'.K_NEWLINE;

echo '<div class="primeformbox">'.K_NEWLINE;
echo '<form action="'.$_SERVER['SCRIPT_NAME'].'" method="post" enctype="multipart/form-data" id="form_moduleeditor">'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="module_id">'.$l['w_module'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
echo '<select name="module_id" id="module_id" size="0" onchange="document.getElementById(\'form_moduleeditor\').submit()" title="'.$l['h_module_name'].'">'.K_NEWLINE;
echo '<option value="0" style="background-color:#009900;color:white;"';
if ($module_id == 0) {
	echo ' selected="selected"';
}
echo '>+</option>'.K_NEWLINE;
$sql = F_select_modules_sql();
if($r = F_db_query($sql, $db)) {
	$countitem = 1;
	while($m = F_db_fetch_array($r)) {
		echo '<option value="'.$m['module_id'].'"';
		if($m['module_id'] == $module_id) {
			echo ' selected="selected"';
		}
		echo '>'.$countitem.'. ';
		if (F_getBoolean($m['module_enabled'])) {
			echo '+';
		} else {
			echo '-';
		}
		echo ' '.htmlspecialchars($m['module_name'], ENT_NOQUOTES, $l['a_meta_charset']).'&nbsp;</option>'.K_NEWLINE;
		$countitem++;
	}
	if ($countitem == 1) {
		echo '<option value="0">&nbsp;</option>'.K_NEWLINE;
	}
} else {
	echo '</select></span></div>'.K_NEWLINE;
	F_display_db_error();
}
echo '</select>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormNoscriptSelect('selectrecord');

echo '<div class="row"><hr /></div>'.K_NEWLINE;

echo getFormRowTextInput('module_name', $l['w_name'], $l['h_module_name'], '', $module_name, '', 255, false, false, false, '');

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label for="module_user_id">'.$l['w_owner'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
$userids = array();
if ($_SESSION['session_user_level'] >= K_AUTH_ADMINISTRATOR) {
	echo '<select name="module_user_id" id="module_user_id" size="0" title="'.$l['h_module_owner'].'" onchange="">'.K_NEWLINE;
	$sql = 'SELECT user_id, user_lastname, user_firstname, user_name FROM '.K_TABLE_USERS.' WHERE (user_level>5) ORDER BY user_lastname, user_firstname, user_name';
	if ($r = F_db_query($sql, $db)) {
		while($m = F_db_fetch_array($r)) {
			$userids[] = $m['user_id'];
			echo '<option value="'.$m['user_id'].'"';
			if ($m['user_id'] == $module_user_id) {
				echo ' selected="selected"';
			}
			echo '>'.htmlspecialchars('('.$m['user_name'].') '.$m['user_lastname'].' '.$m['user_firstname'].'', ENT_NOQUOTES, $l['a_meta_charset']).'</option>'.K_NEWLINE;
		}
	}
	else {
		echo '</select></span></div>'.K_NEWLINE;
		F_display_db_error();
	}
	echo '</select>'.K_NEWLINE;
} else {
	$userdata = '';
	$userids[] = $module_user_id;
	$sql = 'SELECT user_id, user_lastname, user_firstname, user_name FROM '.K_TABLE_USERS.' WHERE user_id='.$module_user_id.'';
	if ($r = F_db_query($sql, $db)) {
		if ($m = F_db_fetch_array($r)) {
			echo '<span style="font-style:italic;color:#333333;">('.$m['user_name'].') '.$m['user_lastname'].' '.$m['user_firstname'].'</span>'.K_NEWLINE;
		}
	} else {
		echo '</select></span></div>'.K_NEWLINE;
		F_display_db_error();
	}
}

// link for user selection popup
$jslink = 'prime_select_users_popup.php?cid=module_user_id';
if (!empty($userids)) {
	$uids = implode('x', $userids);
	if (strlen(K_PATH_exam_CODE.$jslink.$uids) < 512) {
		// add this filter only if the URL is short
		$jslink .= '&amp;uids='.$uids;
	}
}
$jsaction = 'selectWindow=window.open(\''.$jslink.'\', \'selectWindow\', \'dependent, height=600, width=800, menubar=no, resizable=yes, scrollbars=yes, status=no, toolbar=no\');return false;';
echo '<a href="#" onclick="'.$jsaction.'" class="xmlbutton" title="'.$l['w_select'].'">...</a>';

echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="label">'.K_NEWLINE;
echo '<label>'.$l['w_groups'].'</label>'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '<span class="formw">'.K_NEWLINE;
$sqlg = 'SELECT *
	FROM '.K_TABLE_GROUPS.', '.K_TABLE_USERGROUP.'
	WHERE usrgrp_group_id=group_id
		AND usrgrp_user_id='.$module_user_id.'
	ORDER BY group_name';
if ($rg = F_db_query($sqlg, $db)) {
	echo '<span style="font-style:italic;color#333333;font-size:small;">';
	while ($mg = F_db_fetch_array($rg)) {
		echo ' · '.$mg['group_name'].'';
	}
	echo '</span>';
} else {
	F_display_db_error();
}
echo '</span>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo getFormRowCheckBox('module_enabled', $l['w_enabled'], $l['h_enabled'], '', 1, $module_enabled, false, '');

echo '<div class="row">'.K_NEWLINE;

// show buttons by case
if (isset($module_id) AND ($module_id > 0)) {
	echo '<span style="background-color:#999999;">';
	echo '<input type="checkbox" name="confirmupdate" id="confirmupdate" value="1" title="confirm &rarr; update" />';
	F_submit_button('update', $l['w_update'], $l['h_update']);
	echo '</span>';
	F_submit_button('add', $l['w_add'], $l['h_add']);
	F_submit_button('delete', $l['w_delete'], $l['h_delete']);
} else {
	F_submit_button('add', $l['w_add'], $l['h_add']);
}
F_submit_button('clear', $l['w_clear'], $l['h_clear']);

echo '</div>'.K_NEWLINE;

echo '<div class="row">'.K_NEWLINE;
echo '<span class="right">'.K_NEWLINE;

if (isset($module_id) AND ($module_id > 0)) {
	echo '<a href="prime_edit_subject.php?subject_module_id='.$module_id.'" title="'.$l['t_subjects_editor'].'" class="xmlbutton">'.$l['t_subjects_editor'].' &gt;</a>';
}

echo '&nbsp;'.K_NEWLINE;
echo '</span>'.K_NEWLINE;
echo '&nbsp;'.K_NEWLINE;
// comma separated list of required fields
echo '<input type="hidden" name="ff_required" id="ff_required" value="module_name" />'.K_NEWLINE;
echo '<input type="hidden" name="ff_required_labels" id="ff_required_labels" value="'.htmlspecialchars($l['w_name'], ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;

echo '</div>'.K_NEWLINE;
echo '</form>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="pagehelp">'.$l['hp_edit_module'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
