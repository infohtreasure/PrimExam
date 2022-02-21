<?php
//============================================================+
// File name   : index.php
// Begin       : 2004-04-20
// Last Update : 2012-12-04
//
// Description : main user page - allows test selection
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
//    Copyright (C) 2004-2012  Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Main page of primexam Public Area.
 * @package com.htreasure.primexam/exam
 * @brief primexam Public Area
 * @author Ifeoluwa Opeyemi O
 * @since 2004-04-20
 */

/**
 */

require_once('../config/prime_config.php');

$pagelevel = K_AUTH_PUBLIC_INDEX;
$thispage_title = $l['t_test_list'];
$thispage_description = $l['hp_public_index'];

require_once('../../shared/code/prime_authorization.php');
require_once('prime_page_header.php');

echo '<div class="containerxx">'.K_NEWLINE;
echo '<div class="primecontentbox">'.K_NEWLINE;
if ($_SESSION['session_user_level'] > 0)
echo '<wa><b>Name</b>: </wa>'.K_NEWLINE;
echo '<span title="'.$l['h_user_info'].'"> '.$_SESSION['session_user_lastname'].' '.$_SESSION['session_user_firstname'].'</span>';
echo '<br />'.K_NEWLINE;
echo '<wa><b>Matric</b>: </wa>'.K_NEWLINE;
echo '<span title="'.$l['h_user_info'].'"> '.$_SESSION['session_user_name'].'</span>';
echo '<br />'.K_NEWLINE;
echo '<img src="../../images/student_img/'.$_SESSION['session_user_passport'].'"alt="Student Photo" height="170" width="180"></img></div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

echo '<div class="container">'.K_NEWLINE;
echo '<div class="primecontentbox">'.K_NEWLINE;
require_once('../../shared/code/prime_functions_test.php');

echo F_getUserTests();
echo '</div>'.K_NEWLINE;

echo '<div class="pagehelp">'.$thispage_description.'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;

require_once('prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
