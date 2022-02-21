 
<?php
//============================================================+
// File name   : prime_filemanager.php
// Begin       : 2010-09-20
// Last Update : 2013-04-12
//
// Description : Passport upload manager.
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
 * File manager for media files.
 * @package com.htreasure.primexam.admin
 * @author Ifeoluwa Opeyemi O
 * @since 2010-09-21
 */

/**
 */

require_once('../config/prime_config.php');
require_once('../../shared/code/prime_authorization.php');
require_once('../code/prime_page_header.php');
echo '<center>';
echo '<iframe src="camera.php" height="100%" width="100%" style="border:none;"></iframe> ';
echo '</center>';
echo '<div class="pagehelp">'.$l['hpp_filemanager'].'</div>'.K_NEWLINE;
echo '</div>'.K_NEWLINE;
require_once('../code/prime_page_footer.php');

//============================================================+
// END OF FILE
//============================================================+
