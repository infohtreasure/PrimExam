<?php
//============================================================+
// File name   : prime_config.php
// Begin       : 2002-02-24
// Last Update : 2014-03-24
//
// Description : Shared configuration file.
//
// Author: Ifeoluwa Opeyemi O
//
// (c) Copyright 2004-2014:
//               Ifeoluwa Opeyemi O
//               Hidden Tresure Computers Ltd
//               UK
//               www.htreasure.com
//               info@htreasure.com
//
// License:
//    Copyright (C) 2004-2014 Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Shared configuration file.
 * @package com.htreasure.primexam.shared.cfg
 * @brief primexam Main Configuration
 * @author Ifeoluwa Opeyemi O
 * @since 2002-02-24
 */

/**
 * primexam version (do not change).
 */
define ('K_primeXAM_VERSION', '10.1.01');

/**
 * 2-letters code for default language.
 */
define ('K_LANGUAGE', 'en');

/**
 * If true, display a language selector.
 */
define ('K_LANGUAGE_SELECTOR', false);

/**
 * Defines a serialized array of available languages.
 * Each language is indexed using a 2-letters code (ISO 639).
 */
define ('K_AVAILABLE_LANGUAGES', serialize(array(
	'ar' => 'Arabian',
	'az' => 'Azerbaijani',
	'bg' => 'Bulgarian',
	'br' => 'Brazilian Portuguese',
	'cn' => 'Chinese',
	'de' => 'German',
	'el' => 'Greek',
	'en' => 'English',
	'es' => 'Spanish',
	'fa' => 'Farsi',
	'fr' => 'French',
	'hi' => 'Hindi',
	'he' => 'Hebrew',
	'hu' => 'Hungarian',
	'id' => 'Indonesian',
	'it' => 'Italian',
	'jp' => 'Japanese',
	'mr' => 'Marathi',
	'ms' => 'Malay (Bahasa Melayu)',
	'nl' => 'Dutch',
	'pl' => 'Polish',
	'ro' => 'Romanian',
	'ru' => 'Russian',
	'tr' => 'Turkish',
	'vn' => 'Vietnamese'
)));

ini_set('zend.ze1_compatibility_mode', false); // disable PHP4 compatibility mode

// -- INCLUDE files --
require_once('../../shared/config/prime_paths.php');
require_once('../../shared/config/prime_general_constants.php');

/**
 * If true enable One-Time-Password authentication on login.
 */
define ('K_OTP_LOGIN', false);

/**
 * Ratio at which the delay will be increased after every failed login attempt.
 */
define ('K_BRUTE_FORCE_DELAY_RATIO', 0);

/**
 * Number of difficulty levels for questions.
 */
define ('K_QUESTION_DIFFICULTY_LEVELS', 1);

/**
 * If true enable virtual keyboard on some textarea fields.
 */
define('K_ENABLE_VIRTUAL_KEYBOARD', true);

/**
 * Popup window height in pixels for test info.
 */
define ('K_TEST_INFO_HEIGHT', 200);

/**
 * Popup window width in pixels for test info.
 */
define ('K_TEST_INFO_WIDTH', 400);

/**
 * Number of columns for answer textarea.
 */
define ('K_ANSWER_TEXTAREA_COLS', 70);

/**
 * Number of rows for answer textarea.
 */
define ('K_ANSWER_TEXTAREA_ROWS', 5);

/**
 * If true enable explanation field for questions.
 */
define ('K_ENABLE_QUESTION_EXPLANATION', true);

/**
 * If true enable explanation field for answers.
 */
define ('K_ENABLE_ANSWER_EXPLANATION', true);

/**
 * If true display test description before executing the test.
 */
define ('K_DISPLAY_TEST_DESCRIPTION', true);

/**
 * If true compare short answers in binary mode.
 */
define ('K_SHORT_ANSWERS_BINARY', false);

/**
 * User's session life time in seconds.
 */
define ('K_SESSION_LIFE', K_SECONDS_IN_HOUR);

/**
 * When an alternate authentication method is used, 
 * if this constant is true the default user groups for the selected
 * authentication method are always added to the user.
 */
define ('K_USER_GROUP_RSYNC', false);

/**
 * Define timestamp format using PHP notation (do not change).
 */
define ('K_TIMESTAMP_FORMAT', 'Y-m-d H:i:s');

/**
 * Define max line length in chars for question navigator on test execution interface.
 */
define ('K_QUESTION_LINE_MAX_LENGTH', 70);

/**
 * If true, check for possible session hijacking (set to false if you have login problems).
 */
define ('K_CHECK_SESSION_FINGERPRINT', false);

/**
 * If true uses a strong encryption algorithm for passwords.
 */
define ('K_STRONG_PASSWORD_ENCRYPTION', true);

// Client Cookie settings

/**
 * Cookie domain.
 */
define ('K_COOKIE_DOMAIN', '');

/**
 * Cookie path.
 */
define ('K_COOKIE_PATH', '/');

/**
 * If true use secure cookies.
 */
define ('K_COOKIE_SECURE', false);

/**
 * Expiration time for cookies.
 */
define ('K_COOKIE_EXPIRE', K_SECONDS_IN_DAY);

/**
 * Various pages redirection modes after login (valid values are 1, 2, 3 and 4).
 * 1 = relative redirect.
 * 2 = absolute redirect.
 * 3 = html redirect.
 * 4 = full redirect.
 */
define ('K_REDIRECT_LOGIN_MODE', 4);

/**
 * If true enable password reset feature.
 */
define ('K_PASSWORD_RESET', false);

/**
 * URL to be redirected at logout (leave empty for default).
 */
define ('K_LOGOUT_URL', 'index.php');


// Error settings

/**
 * Define error reporting types for debug.
 */
define ('K_ERROR_TYPES', E_ALL | E_STRICT);
//define ('K_ERROR_TYPES', E_ERROR | E_WARNING | E_PARSE);

/**
 * Enable error logs (../logs/prime_errors.log).
 */
define ('K_USE_ERROR_LOG', true);

/**
 * If true display messages and errors on Javascript popup window.
 */
define ('K_ENABLE_JSERRORS', false);

/**
 * Set your own timezone here.
 * Possible values are listed on:
 * http://php.net/manual/en/timezones.php
 */
define ('K_TIMEZONE', 'GMT');

/**
 * Default minutes used to extend test duration.
 */
define('K_EXTEND_TIME_MINUTES', 5);


// ---------- * ---------- * ---------- * ---------- * ----------


/**
 * Error handlers.
 */
require_once('../../shared/code/prime_functions_errmsg.php');

// load language resources

// set user's selected language or default language
if(isset($_REQUEST['lang'])
	AND (strlen($_REQUEST['lang']) == 2)
	AND (array_key_exists($_REQUEST['lang'],unserialize(K_AVAILABLE_LANGUAGES)))) {
	/**
	 * Use requested language.
	 * @ignore
	 */
	define ('K_USER_LANG', $_REQUEST['lang']);
	// set client cookie
	setcookie('SessionUserLang', K_USER_LANG, time() + K_COOKIE_EXPIRE, K_COOKIE_PATH, K_COOKIE_DOMAIN, K_COOKIE_SECURE);
} elseif (isset($_COOKIE['SessionUserLang'])
	AND (strlen($_COOKIE['SessionUserLang']) == 2)
	AND (array_key_exists($_COOKIE['SessionUserLang'],unserialize(K_AVAILABLE_LANGUAGES)))) {
	/**
	 * Use session language.
	 * @ignore
	 */
	define ('K_USER_LANG', $_COOKIE['SessionUserLang']);
} else {
	/**
	 * Use default language.
	 * @ignore
	 */
	define ('K_USER_LANG', K_LANGUAGE);
}

// TMX class
require_once('../../shared/code/prime_tmx.php');
// istantiate new TMXResourceBundle object
$lang_resources = new TMXResourceBundle(K_PATH_TMX_FILE, K_USER_LANG, K_PATH_LANG_CACHE.basename(K_PATH_TMX_FILE, '.xml').'_'.K_USER_LANG.'.php');
$l = $lang_resources->getResource(); // language array

ini_set('arg_separator.output', '&amp;');
//date_default_timezone_set(K_TIMEZONE);

if(!defined('PHP_VERSION_ID')) {
	$version = PHP_VERSION;
	define('PHP_VERSION_ID', (($version[0] * 10000) + ($version[2] * 100) + $version[4]));
}
if (PHP_VERSION_ID < 50300) {
	@set_magic_quotes_runtime(false); //disable magic quotes
	ini_set('magic_quotes_gpc', 'On');
	ini_set('magic_quotes_runtime', 'Off');
	ini_set('register_long_arrays', 'On');
	//ini_set('register_globals', 'On');
}

// --- get 'post', 'get' and 'cookie' variables
foreach ($_REQUEST as $postkey => $postvalue) {
	if (($postkey[0] != '_') AND (!preg_match('/[A-Z]/', $postkey[0]))) {
		if (!function_exists('get_magic_quotes_gpc') OR !get_magic_quotes_gpc()) {
			$postvalue = addSlashesArray($postvalue);
			$_REQUEST[$postkey] = $postvalue;
			if (isset($_GET[$postkey])) {
				$_GET[$postkey] = $postvalue;
			} elseif (isset($_POST[$postkey])) {
				$_POST[$postkey] = $postvalue;
			} elseif (isset($_COOKIE[$postkey])) {
				$_COOKIE[$postkey] = $postvalue;
			}
		}
		$$postkey = $postvalue;
	}
}

/**
 * Escape strings with backslashes before characters that need to be escaped.
 * These characters are single quote ('), double quote ("), backslash (\) and NUL (the NULL byte). 
 * @param $data (array|string) String or array to escape
 * @return array|string
 */
function addSlashesArray($data) {
	if (is_array($data)) {
		return array_map('addSlashesArray', $data);
	}
	if (is_string($data)) {
		return addslashes($data);
	}
	return $data;
}
//============================================================+
// END OF FILE
//============================================================+
