<?php
//============================================================+
// File name   : prime_general_constants.php
// Begin       : 2002-03-01
// Last Update : 2012-12-27
//
// Description : Configuration file for general constants.
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
 * Configuration file for general constants.
 * @package com.htreasure.primexam.shared.cfg
 * @author Ifeoluwa Opeyemi O
 * @since 2002-03-01
 */

/**
 * String used as a seed for some security code generation please change this value and keep it secret.
 */
define ('K_RANDOM_SECURITY', '4kCHtQ53');

/**
 * Maximum number of tests per year (last 365 days).
 * false = unlimited
 */
define ('K_MAX_TESTS_YEAR', false);

/**
 * Maximum number of tests per month (last 30 days).
 * false = unlimited
 */
define ('K_MAX_TESTS_MONTH', false);

/**
 * Maximum number of tests per day (last 24 hours).
 * false = unlimited
 */
define ('K_MAX_TESTS_DAY', false);

/**
 * Set to false to disable test counting.
 */
define ('K_REMAINING_TESTS', false);

// ---------------------------------------------------------------------
// DO NOT ALTER THE FOLLOWING CONSTANTS
// ---------------------------------------------------------------------

/**
 * New line character.
 */
define ('K_NEWLINE', "\n");

/**
 * Tabulation character.
 */
define ('K_TAB', "\t");

/**
 * Number of seconds in one minute.
 */
define ('K_SECONDS_IN_MINUTE', 60);

/**
 * Number of seconds in one hour.
 */
define ('K_SECONDS_IN_HOUR', 60 * K_SECONDS_IN_MINUTE);

/**
 * Number of seconds in one day.
 */
define ('K_SECONDS_IN_DAY', 24 * K_SECONDS_IN_HOUR);

/**
 * Number of seconds in one week.
 */
define ('K_SECONDS_IN_WEEK', 7 * K_SECONDS_IN_DAY);

/**
 * Number of seconds in one month.
 */
define ('K_SECONDS_IN_MONTH', 30 * K_SECONDS_IN_DAY);

/**
 * Number of seconds in one year.
 */
define ('K_SECONDS_IN_YEAR', 365 * K_SECONDS_IN_DAY);

/**
 * String used for security feature, do not alter.
 */
define ('K_KEY_SECURITY', 'VENFeGFtIChjKSAyMDA0LTIwMDggTmljb2xhIEFzdW5pIC0gVGVjbmljay5jb20gcy5yLmwuIC0gd3d3LnRjZXhhbS5jb20=');


//============================================================+
// END OF FILE
//============================================================+
