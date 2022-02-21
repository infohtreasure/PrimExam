<?php
//============================================================+
// File name   : prime_menu_modules.php
// Begin       : 2004-04-20
// Last Update : 2010-09-05
//
// Description : Output XHTML unordered list menu for modules.
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
//    Copyright (C) 2004-2010 Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Output XHTML unordered list menu for modules.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2010-05-10
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = 1;
require_once('../../shared/code/prime_authorization.php');

$thispage_title = $l['w_modules'];
require_once('../code/prime_page_header.php');

echo '<div class="container">'.K_NEWLINE;

// print submenu
echo '<ul>'.K_NEWLINE;
foreach ($menu['prime_menu_modules.php']['sub'] as $link => $data) {
	echo F_menu_link($link, $data, 1);
}
echo '</ul>'.K_NEWLINE;

//echo '<div class="pagehelp">'.$l['w_modules'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('../code/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
