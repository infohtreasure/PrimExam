<?php
//============================================================+
// File name   : cp_class_mailer.php
// Begin       : 2001-10-20
// Last Update : 2010-03-10
//
// Description : Extend PHPMailer class with inheritance
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
 * PHPMailer class extension.
 * @package PHPMailer
 * @brief PHP email transport class 
 * @author Ifeoluwa Opeyemi O
 * @since 2005-02-24
 */

/**
 */

require_once('../config/prime_config.php');

require_once('../../shared/config/prime_email_config.php'); //Include default public variables

// Set the custom error handler function
// This suppress the warnings due to the fact that phpmailer class is written in PHP4
$old_error_handler = set_error_handler('F_error_handler', E_ERROR | E_WARNING | E_PARSE);
// include the phpmailer class
require_once("../../shared/phpmailer/class.phpmailer.php");

/**
 * @class C_mailer
 * PHPMailer class extension.
 * @author Ifeoluwa Opeyemi O
 * @package PHPMailer
 * @since 2005-02-24
 */
class C_mailer extends PHPMailer {

	/**
	 * Language array.
	 */
	public $language;

	/**
	 * Replace the default SetError
	 * @param $msg (string) error message
	 * @public
	 * @return void
	 */
	public function SetError($msg) {
        $this->error_count++;
        $this->ErrorInfo = $msg;
        F_print_error('ERROR', $msg);
		exit;
    }

	/**
     * Returns a message in the appropriate language.
     * (override original Lang method).
     * @param $key (string) language key
     * @protected
     * @return string
     */
    protected function Lang($key) {
        if(isset($this->language['m_mailerror_'.$key])) {
            return $this->language['m_mailerror_'.$key];
        } else {
            return 'UNKNOW ERROR: ['.$key.']';
        }
    }

	/**
	 * Check that a string looks roughly like an email address should
	 * (override original ValidateAddress method).
	 * Conforms approximately to RFC2822
	 * Original pattern found at: http://www.hexillion.com/samples/#Regex
	 * @param $address (string) The email address to check
	 * @return boolean
	 * @static
	 * @public
	*/
	public static function ValidateAddress($address) {
		return preg_match('/^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!\.)){0,61}[a-zA-Z0-9_-]?\.)+[a-zA-Z0-9_](?:[a-zA-Z0-9_\-](?!$)){0,61}[a-zA-Z0-9_]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$/', $address);
	}

} //end of class

//============================================================+
// END OF FILE
//============================================================+
