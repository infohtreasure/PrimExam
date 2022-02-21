<?php
//============================================================+
// File name   : prime_page_footer.php
// Begin       : 2001-09-02
// Last Update : 2009-09-30
//
// Description : Outputs default XHTML page footer.
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
//    Copyright (C) 2004-2010  Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Outputs default XHTML page footer.
 * @package com.htreasure.primexam/exam
 * @author Ifeoluwa Opeyemi O
 * @since 2001-09-02
 */

/**
 */

echo K_NEWLINE;
echo '</div>'.K_NEWLINE; //close div.body

include('../../shared/code/prime_page_userbar.php'); // display user bar

echo '<!-- '.'P'.'R'.'I'.'M'.'E'.'x'.'a'.'m'.'19'.'85'.'02'.'22'.' -->'.K_NEWLINE;
echo '</body>'.K_NEWLINE;
echo '</html>';

//============================================================+
// END OF FILE
//============================================================+
