<?php
//============================================================+
// File name   : prime_preview_primecode.php
// Begin       : 2002-01-30
// Last Update : 2009-09-30
//
// Description : Renders primexam code using popup headers.
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
 * Renders primexam code using popup headers.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2002-01-30
 */

/**
 */

require_once('../config/prime_config.php');
$pagelevel = K_AUTH_ADMIN_primeCODE;
require_once('../../shared/code/prime_authorization.php');

$thispage_title = '';

require_once('../code/prime_page_header_popup.php');

require_once('../../shared/code/prime_functions_primecode.php');
require_once('../../shared/code/prime_functions_form.php');
$primexamcode = str_replace('+', '~#PLUS#~', $_REQUEST['primexamcode']);
$primexamcode = stripslashes(urldecode($primexamcode));
$primexamcode = str_replace('~#PLUS#~', '+', $primexamcode);
echo F_decode_primecode($primexamcode);

echo '<hr />'.K_NEWLINE;

echo F_close_button();

require_once('../code/prime_page_footer_popup.php');

//============================================================+
// END OF FILE
//============================================================+
