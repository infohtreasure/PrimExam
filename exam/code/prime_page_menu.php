<?php
//============================================================+
// File name   : prime_page_menu.php
// Begin       : 2010-09-16
// Last Update : 2012-12-19
//
// Description : Output XHTML unordered list menu.
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
 * Output XHTML unordered list menu.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2010-09-16
 */

/**
 */

require_once('../../shared/code/prime_functions_menu.php');

$menu = array(	
	'index.php' => array('link' => 'index.php', 'title' => $l['h_index'], 'name' => $l['w_index'], 'level' => K_AUTH_PUBLIC_INDEX, 'key' => 'i', 'enabled' => true),
	'prime_test_allresults.php' => array('link' => 'prime_test_allresults.php', 'title' => $l['t_all_results_user'], 'name' => $l['w_results'], 'level' => K_AUTH_PUBLIC_TEST_RESULTS, 'key' => 'r', 'enabled' => ($_SESSION['session_user_level'] > K_AUTH_PUBLIC_TEST_RESULTS)),
	'prime_page_user.php' => array('link' => 'prime_page_user.php', 'title' => $l['w_user'], 'name' => $l['w_user'], 'level' => K_AUTH_PAGE_USER, 'key' => 'u', 'enabled' => ($_SESSION['session_user_level'] > 0)),
	'admin' => array('link' => '../../control/code/index.php', 'title' => $l['h_admin_link'], 'name' => $l['w_admin'], 'level' => K_ADMIN_LINK, 'key' => 'a', 'enabled' => ($_SESSION['session_user_level'] >= K_ADMIN_LINK)),
	'prime_logout.php' => array('link' => 'prime_logout.php', 'title' => $l['h_logout_link'], 'name' => $l['w_logout'], 'level' => 1, 'key' => 'q', 'enabled' => ($_SESSION['session_user_level'] > 0)),
	'prime_login.php' => array('link' => 'prime_login.php', 'title' => $l['h_login_link'], 'name' => $l['w_login'], 'level' => 0, 'key' => 'l', 'enabled' => ($_SESSION['session_user_level'] < 1))
);

$menu['prime_page_user.php']['sub'] = array(
	'prime_user_change_email.php' => array('link' => 'prime_user_change_email.php', 'title' => $l['t_user_change_email'], 'name' => $l['w_change_email'], 'level' => K_AUTH_USER_CHANGE_EMAIL, 'key' => '', 'enabled' => true),
	'prime_user_change_password.php' => array('link' => 'prime_user_change_password.php', 'title' => $l['t_user_change_password'], 'name' => $l['w_change_password'], 'level' => K_AUTH_USER_CHANGE_PASSWORD, 'key' => '', 'enabled' => true)
);

echo '<a name="menusection" id="menusection"></a>'.K_NEWLINE;

// link to skip navigation
echo '<div class="hidden">';
echo '<a href="#topofdoc" accesskey="2" title="[2] '.$l['w_skip_navigation'].'">'.$l['w_skip_navigation'].'</a>';
echo '</div>'.K_NEWLINE;

$menudata = '';
foreach ($menu as $link => $data) {
	$menudata .= F_menu_link($link, $data, 0);
}

if (!empty($menudata)) {
	echo '<ul class="menu">'.K_NEWLINE;
	echo $menudata;
	echo '</ul>'.K_NEWLINE; // end of menu
}

//============================================================+
// END OF FILE
//============================================================+
