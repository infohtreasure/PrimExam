<?php
//============================================================+
// File name   : prime_config.php
// Begin       : 2001-10-23
// Last Update : 2010-09-26
//
// Description : Configuration file for public section.
//
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
 * Configuration file for public section.
 * @package com.htreasure.primexam/exam.cfg
 * @brief primexam Configuration for Public Area
 * @author Ifeoluwa Opeyemi O
 * @since 2001-10-23
 */

/**
 */

// --- INCLUDE FILES -----------------------------------------------------------

require_once('../config/prime_auth.php');
require_once('../../shared/config/prime_config.php');

// --- DEFAULT META TAGS -------------------------------------------------------

/**
 * Default site name.
 */
define ('K_SITE_TITLE', 'Primexam');

/**
 * Default site description.
 */
define ('K_SITE_DESCRIPTION', 'Primexam by htreasure.com');

/**
 * Default site author.
 */
define ('K_SITE_AUTHOR', 'Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd');

/**
 * Default html reply-to meta tag.
 */
define ('K_SITE_REPLY', ''); //

/**
 * Default keywords.
 */
define ('K_SITE_KEYWORDS', 'Primexam, eExam, e-exam, web, exam');

/**
 * Path to default html icon.
 */
define ('K_SITE_ICON', '../../favicon.ico');

/**
 * Path to public CSS stylesheet.
 */
define ('K_SITE_STYLE', K_PATH_STYLE_SHEETS.'default.css');

/**
 * Full path to CSS stylesheet for RTL languages.
 */
define ('K_SITE_STYLE_RTL', K_PATH_STYLE_SHEETS.'default_rtl.css');

// --- OPTIONS / COSTANTS ------------------------------------------------------

/**
 * Max number of rows to display in tables.
 */
define ('K_MAX_ROWS_PER_PAGE', 50);

/**
 * Max file size to be uploaded [bytes].
 */
define ('K_MAX_UPLOAD_SIZE', 90971520);

/**
 * Max memory limit for a PHP script.
 */
define ('K_MAX_MEMORY_LIMIT', '64M');

/**
 * Main page (homepage).
 */
define ('K_MAIN_PAGE', 'index.php');

/**
 * Enable PDF results on public area.
 */
define ('K_ENABLE_PUBLIC_PDF', false);

/**
 * If true hide the expired tests from index table.
 */
define ('K_HIDE_EXPIRED_TESTS', true);

// --- INCLUDE FILES -----------------------------------------------------------

require_once('../../shared/config/prime_db_config.php');
require_once('../../shared/code/prime_db_connect.php');
require_once('../../shared/code/prime_functions_general.php');

// --- PHP SETTINGS ------------------------------------------------------------

ini_set('memory_limit', K_MAX_MEMORY_LIMIT); // set PHP memory limit
ini_set('session.use_trans_sid', 0); // if =1 use PHPSESSID (for clients that do not support cookies)

//============================================================+
// END OF FILE
//============================================================+
