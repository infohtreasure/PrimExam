<?php
//============================================================+
// File name   : prime_config.php
// Begin       : 2001-09-02
// Last Update : 2013-07-05
//
// Description : Configuration file for administration section.
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
//    Copyright (C) 2004-2013  Ifeoluwa Opeyemi O - htreasure.com LTD
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Configuration file for administration section.
 * @package com.htreasure.primexam.admin.cfg
 * @brief primexam Configuration for Administration Area
 * @author Ifeoluwa Opeyemi O
 * @since 2001-09-02
 */

/**
 */

// --- INCLUDE FILES -----------------------------------------------------------

require_once('../config/prime_auth.php');
require_once('../../shared/config/prime_config.php');

// --- OPTIONS / COSTANTS ------------------------------------------------------

/**
 * Max memory limit.
 */
define ('K_MAX_MEMORY_LIMIT', '800M');

/**
 * Max number of rows to display in tables.
 */
define ('K_MAX_ROWS_PER_PAGE', 50);

/**
 * Max size to be uploaded in bytes.
 */
define ('K_MAX_UPLOAD_SIZE', 90971520);

/**
 * List of allowed file types for upload (remove all extensions to disable upload).
 * FOR SERVER SECURITY DO NOT ADD EXECUTABLE FILE TYPES HERE
 */
define ('K_ALLOWED_UPLOAD_EXTENSIONS', serialize(array('csv', 'tsv', 'xml', 'txt', 'png', 'gif', 'jpg', 'jpeg', 'svg', 'mp3', 'mid', 'oga', 'ogg', 'wav', 'wma', 'avi', 'flv', 'm2v', 'mpeg', 'mpeg4', 'mpg', 'mpg2', 'mpv', 'ogm', 'ogv', 'vid', 'pfx', 'pem', 'crt')));

// -- DEFAULT META and BODY Tags --

/**
 * primexam title.
 */
define ('K_primexam_TITLE', 'PRIMExam');

/**
 * primexam description.
 */
define ('K_primexam_DESCRIPTION', 'Primexam by htreasure.com');

/**
 * primexam Author.
 */
define ('K_primexam_AUTHOR', 'Ifeoluwa Opeyemi O - htreasure.com LTD');

/**
 * Reply-to meta tag.
 */
define ('K_primexam_REPLY_TO', 'info@primexam.org');

/**
 * Default html meta keywords.
 */
define ('K_primexam_KEYWORDS', 'Primexam, Eexam, e-exam, web, exam');

/**
 * Relative path to html icon.
 */
define ('K_primexam_ICON', '../../favicon.ico');

/**
 * Full path to CSS stylesheet.
 */
define ('K_primexam_STYLE', K_PATH_STYLE_SHEETS.'default.css');

/**
 * Full path to CSS stylesheet for RTL languages.
 */
define ('K_primexam_STYLE_RTL', K_PATH_STYLE_SHEETS.'default_rtl.css');

/**
 * Full path to CSS stylesheet for help file.
 */
define ('K_primexam_HELP_STYLE', K_PATH_STYLE_SHEETS.'help.css');

/**
 * If true display admin clock in UTC (GMT).
 */
define ('K_CLOCK_IN_UTC', true);

/**
 * Max number of chars to display on a selection box.
 */
define ('K_SELECT_SUBSTRING', 40);

/**
 * If true display an additional button to print only the TEXT answers on all users' results.
 */
define ('K_DISPLAY_PDFTEXT_BUTTON', true);

/**
 * Name of the option to import questions using a custom format (file: control/code/prime_import_custom.php).
 * Set this constant to empty to disable this feature (or if you haven't set prime_import_custom.php)
 */
define ('K_ENABLE_CUSTOM_IMPORT', '');

/**
 * Name of the button to export results in custom format (file: control/code/prime_export_custom.php).
 * Set this constant to empty to disable this feature (or if you haven't set prime_import_custom.php)
 */
define ('K_ENABLE_CUSTOM_EXPORT', '');

/**
 * If true enable the backup download.
 */
define ('K_DOWNLOAD_BACKUPS', true);

/**
 * If true check the unicity of question and answer descriptions using utf8_bin collation when using MySQL.
 */
define('K_MYSQL_QA_BIN_UNIQUITY', true);

/**
 * Set the UTF-8 Normalization mode for question and answer descriptions:
 * NONE=None;
 * C=Normalization Form C (NFC) - Canonical Decomposition followed by Canonical Composition;
 * D=Normalization Form D (NFD) - Canonical Decomposition;
 * KC=Normalization Form KC (NFKC) - Compatibility Decomposition, followed by Canonical Composition;
 * KD=Normalization Form KD (NFKD) - Compatibility Decomposition;
 * CUSTOM=Custom normalization using user defined function 'user_utf8_custom_normalizer'.
 */
define('K_UTF8_NORMALIZATION_MODE', 'NONE');

/**
 * Path to zbarimg executable (/usr/bin/zbarimg).
 * This application is required to decode barcodes on scanned offline test pages.
 * For installation instructions: http://zbar.sourceforge.net/
 * On Debian/Ubuntu you can easily install zbarimg using the following command:
 * "sudo apt-get install zbar-tools"
 */
define ('K_OMR_PATH_ZBARIMG', '/usr/bin/zbarimg');

/**
 * Defines a serialized array of available fonts for PDF.
 */
define ('K_AVAILABLE_FONTS', serialize(array(
	'courier' => 'courier',
	'helvetica' => 'helvetica',
	'times' => 'times',
	'symbol' => 'symbol',
	'zapfdingbats' => 'zapfdingbats',
	'DejaVuSans' => 'dejavusans,sans',
	'DejaVuSansCondensed' => 'dejavusanscondensed,sans',
	'DejaVuSansMono' => 'dejavusansmono,monospace',
	'DejaVuSerif' => 'dejavuserif,serif',
	'DejaVuSerifCondensed' => 'dejavuserifcondensed,serif',
	'FreeMono' => 'freemono,monospace',
	'FreeSans' => 'freesans,sans',
	'FreeSerif' => 'freeserif,serif'
)));

// --- INCLUDE FILES -----------------------------------------------------------

require_once('../../shared/config/prime_db_config.php');
require_once('../../shared/code/prime_db_connect.php');
require_once('../../shared/code/prime_functions_general.php');

// --- PHP SETTINGS -----------------------------------------------------------

ini_set('memory_limit', K_MAX_MEMORY_LIMIT); // set PHPmemory limit
ini_set('upload_max_filesize', K_MAX_UPLOAD_SIZE); // set max upload size
ini_set('post_max_size', K_MAX_UPLOAD_SIZE); // set max post size
ini_set('session.use_trans_sid', 0); // if =1 use PHPSESSID

//============================================================+
// END OF FILE
//============================================================+
