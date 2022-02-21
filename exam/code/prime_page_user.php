<?php
//============================================================+
// File name   : prime_page_user.php
// Begin       : 2010-09-20
// Last Update : 2010-09-20
//
// Description : Output XHTML unordered list menu for user.
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
//    Copyright (C) 2004-2010 Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Output XHTML unordered list menu for user.
 * @package com.htreasure.primexam/exam
 * @author Ifeoluwa Opeyemi O
 * @since 2010-09-20
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_PAGE_USER;
require_once('../../shared/code/prime_authorization.php');

$thispage_title = $l['w_user'];
require_once('../code/prime_page_header.php');

echo '<div class="container">'.K_NEWLINE;

// print submenu
echo '<ul>'.K_NEWLINE;
foreach ($menu['prime_page_user.php']['sub'] as $link => $data) {
	echo F_menu_link($link, $data, 1);
}
echo '</ul>'.K_NEWLINE;

echo '</div>'.K_NEWLINE;

require_once('../code/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
