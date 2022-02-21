<?php
//============================================================+
// File name   : prime_user_registration.php
// Begin       : 2008-03-30
// Last Update : 2009-11-10
//
// Description : Configuration file for user registration.
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
 * Configuration file for user registration.
 * NOTE: the email verification template is stored on the
 * TMX file at "m_email_registration" translation unit.
 * @package com.htreasure.primexam.shared.cfg
 * @author Ifeoluwa Opeyemi O
 * @since 2008-03-30
 */

/**
 * If true enable USER REGISTRATION.
 */
define ('K_USRREG_ENABLED', true);

/**
 * If true requires email confirmation.
 */
define ('K_USRREG_EMAIL_CONFIRM', false);

/**
 * Default user group ID for registered user.
 */
define ('K_USRREG_GROUP', 1);

/**
 * URL of an HTML page containing the registration agreement (i.e.: "http://www.yoursite.com/agreement.html").
 */
define ('K_USRREG_AGREEMENT', '');

/**
 * The following email will receive copies of verification messages.
 */
define ('K_USRREG_ADMIN_EMAIL', 'info.htreasure@gmail.com');

/**
 * Additional fields to display on registration form.
 * Legal values are:
 * 0 = disabled field;
 * 1 = enabled field;
 * 2 = required field;
 */
$regfields = array(
	'user_email' => 1,
	'user_regnumber' => 0,
	'user_firstname' => 2,
	'user_lastname' => 2,
	'user_birthdate' => 0,
	'user_birthplace' => 0,
	'user_passport' => 0,
	'user_groups' => 0,
	'user_agreement' => 2
);

//============================================================+
// END OF FILE
//============================================================+
