<?php
//============================================================+
// File name   : prime_altauth.php
// Begin       : 2008-03-28
// Last Update : 2013-03-27
//
// Description : Check user authorization against alternative
//               systems (SSL, HTTP-BASIC, CAS, SHIBBOLETH, RADIUS, LDAP)
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
//    Copyright (C) 2004-2013 Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Check user authorization against alternative systems (HTTP-BASIC, CAS, SHIBBOLETH, RADIUS, LDAP)
 * @package com.htreasure.primexam.shared
 * @author Ifeoluwa Opeyemi O
 * @since 2008-03-28
 */

/**
 * Try various external Login Systems.
 * (SSL, HTTP-BASIC, CAS, SHIBBOLETH, RADIUS, LDAP)
 * @return array of user's data for successful login, false otherwise
 * @since 2012-06-05
 */
function F_altLogin() {
	global $l, $db;
	require_once('../config/prime_config.php');

	// primexam tries to retrive the user login information from the following systems:

	// 1) SSL ----------------------------------------------------------
	require_once('../../shared/config/prime_ssl.php');
	if (K_SSL_ENABLED AND (!isset($_SESSION['logout']) OR !$_SESSION['logout'])) {
		if (isset($_SERVER['SSL_CLIENT_M_SERIAL']) // The serial of the client certificate
				AND isset($_SERVER['SSL_CLIENT_I_DN']) // Issuer DN of client's certificate
				AND isset($_SERVER['SSL_CLIENT_V_END']) // Validity of client's certificate (end time)
				AND isset($_SERVER['SSL_CLIENT_VERIFY']) // NONE, SUCCESS, GENEROUS or FAILED:reason
				AND  ($_SERVER['SSL_CLIENT_VERIFY'] === 'SUCCESS')
				AND isset($_SERVER['SSL_CLIENT_V_REMAIN']) // Number of days until client's certificate expires
				AND ($_SERVER['SSL_CLIENT_V_REMAIN'] <= 0)) {
			$_POST['xuser_name'] = md5($_SERVER['SSL_CLIENT_M_SERIAL'].$_SERVER['SSL_CLIENT_I_DN']);
			$_POST['xuser_password'] = getPasswordHash($_SERVER['SSL_CLIENT_M_SERIAL'].$_SERVER['SSL_CLIENT_I_DN'].K_RANDOM_SECURITY.$_SERVER['SSL_CLIENT_V_END']);
			$_POST['logaction'] = 'login';
			$usr = array();
			if (isset($_SERVER['SSL_CLIENT_S_DN_Email'])) {
				$usr['user_email'] = $_SERVER['SSL_CLIENT_S_DN_Email'];
			} else {
				$usr['user_email'] = '';
			}
			if (isset($_SERVER['SSL_CLIENT_S_DN_CN'])) {
				$usr['user_firstname'] = $_SERVER['SSL_CLIENT_S_DN_CN'];
			} else {
				$usr['user_firstname'] = '';
			}
			$usr['user_lastname'] = '';
			$usr['user_birthdate'] = '';
			$usr['user_birthplace'] = '';
			$usr['user_regnumber'] = '';
			$usr['user_passport'] = '';
			$usr['user_level'] = K_SSL_USER_LEVEL;
			$usr['usrgrp_group_id'] = K_SSL_USER_GROUP_ID;
			return $usr;
		}
	}
	// -----------------------------------------------------------------

	// 2) HTTP BASIC ---------------------------------------------------
	require_once('../../shared/config/prime_httpbasic.php');
	if (K_HTTPBASIC_ENABLED AND (!isset($_SESSION['logout']) OR !$_SESSION['logout'])) {
		if (isset($_SERVER['AUTH_TYPE']) AND ($_SERVER['AUTH_TYPE'] == 'Basic')
			AND isset($_SERVER['PHP_AUTH_USER']) AND isset($_SERVER['PHP_AUTH_PW'])
			AND ($_SESSION['session_user_name'] != $_SERVER['PHP_AUTH_USER'])) {
			$_POST['xuser_name'] = $_SERVER['PHP_AUTH_USER'];
			$_POST['xuser_password'] = $_SERVER['PHP_AUTH_PW'];
			$_POST['logaction'] = 'login';
			$usr = array();
			$usr['user_email'] = '';
			$usr['user_firstname'] = '';
			$usr['user_lastname'] = '';
			$usr['user_birthdate'] = '';
			$usr['user_birthplace'] = '';
			$usr['user_regnumber'] = '';
			$usr['user_passport'] = '';
			$usr['user_level'] = K_HTTPBASIC_USER_LEVEL;
			$usr['usrgrp_group_id'] = K_HTTPBASIC_USER_GROUP_ID;
			return $usr;
		}
	}
	// -----------------------------------------------------------------

	// 3) CAS - Central Authentication Service -------------------------
	require_once('../../shared/config/prime_cas.php');
	if (K_CAS_ENABLED) {
		require_once('../../shared/cas/CAS.php');
		phpCAS::client(K_CAS_VERSION, K_CAS_HOST, K_CAS_PORT, K_CAS_PATH, false);
		phpCAS::setNoCasServerValidation();
		phpCAS::forceAuthentication();
		if ($_SESSION['session_user_name'] != phpCAS::getUser()) {
			$_POST['xuser_name'] = phpCAS::getUser();
			$_POST['xuser_password'] = getPasswordHash($_POST['xuser_name'].K_RANDOM_SECURITY);
			$_POST['logaction'] = 'login';
			$usr = array();
			$usr['user_email'] = '';
			$usr['user_firstname'] = '';
			$usr['user_lastname'] = '';
			$usr['user_birthdate'] = '';
			$usr['user_birthplace'] = '';
			$usr['user_regnumber'] = '';
			$usr['user_passport'] = '';
			$usr['user_level'] = K_CAS_USER_LEVEL;
			$usr['usrgrp_group_id'] = K_CAS_USER_GROUP_ID;
			return $usr;
		}
	}
	// -----------------------------------------------------------------

	// 4) Shibboleth ---------------------------------------------------
	require_once('../../shared/config/prime_shibboleth.php');
	if (K_SHIBBOLETH_ENABLED AND (!isset($_SESSION['logout']) OR !$_SESSION['logout'])) {
		if (isset($_SERVER['AUTH_TYPE']) AND ($_SERVER['AUTH_TYPE'] == 'shibboleth')
			AND ((isset($_SERVER['Shib_Session_ID']) AND !empty($_SERVER['Shib_Session_ID']))
				OR (isset($_SERVER['HTTP_SHIB_IDENTITY_PROVIDER']) AND !empty($_SERVER['HTTP_SHIB_IDENTITY_PROVIDER'])))
			AND isset($_SERVER['eppn']) AND ($_SESSION['session_user_name'] != $_SERVER['eppn'])) {
			$_POST['xuser_name'] = $_SERVER['eppn'];
			$_POST['xuser_password'] = getPasswordHash($_POST['xuser_name'].K_RANDOM_SECURITY);
			$_POST['logaction'] = 'login';
			$usr = array();
			$usr['user_email'] = $_SERVER['eppn'];
			if (isset($_SERVER['givenName'])) {
				$usr['user_firstname'] = $_SERVER['givenName'];
			} else {
				$usr['user_firstname'] = '';
			}
			if (isset($_SERVER['sn'])) {
				$usr['user_lastname'] = $_SERVER['sn'];
			} else {
				$usr['user_lastname'] = '';
			}
			$usr['user_birthdate'] = '';
			$usr['user_birthplace'] = '';
			if (isset($_SERVER['employeeNumber'])) {
				$usr['user_regnumber'] = $_SERVER['employeeNumber'];
			} else {
				$usr['user_regnumber'] = '';
			}
			$usr['user_passport'] = '';
			$usr['user_level'] = K_SHIBBOLETH_USER_LEVEL;
			$usr['usrgrp_group_id'] = K_SHIBBOLETH_USER_GROUP_ID;
			return $usr;
		}
	}
	// -----------------------------------------------------------------

	if (isset($_POST['logaction']) AND ($_POST['logaction'] == 'login') AND isset($_POST['xuser_name']) AND isset($_POST['xuser_password'])) {

		// 5) RADIUS ---------------------------------------------------
		require_once('../../shared/config/prime_radius.php');
		if (K_RADIUS_ENABLED) {
			require_once('../../shared/radius/radius.class.php');
			$radius = new Radius(K_RADIUS_SERVER_IP, K_RADIUS_SHARED_SECRET, K_RADIUS_SUFFIX, K_RADIUS_UDP_TIMEOUT, K_RADIUS_AUTHENTICATION_PORT, K_RADIUS_ACCOUNTING_PORT);
			if (K_RADIUS_UTF8) {
				$radusername = utf8_encode($_POST['xuser_name']);
				$radpassword = utf8_encode($_POST['xuser_password']);
			} else {
				$radusername = $_POST['xuser_name'];
				$radpassword = $_POST['xuser_password'];
			}
			if ($radius->AccessRequest($radusername, $radpassword)) {
				$usr = array();
				$usr['user_email'] = '';
				$usr['user_firstname'] = '';
				$usr['user_lastname'] = '';
				$usr['user_birthdate'] = '';
				$usr['user_birthplace'] = '';
				$usr['user_regnumber'] = '';
				$usr['user_passport'] = '';
				$usr['user_level'] = K_RADIUS_USER_LEVEL;
				$usr['usrgrp_group_id'] = K_RADIUS_USER_GROUP_ID;
				return $usr;
			}
		}
		// -------------------------------------------------------------

		// 6) LDAP -----------------------------------------------------
		require_once('../../shared/config/prime_ldap.php');
		if (K_LDAP_ENABLED) {
			// make ldap connection
			$ldapconn = ldap_connect(K_LDAP_HOST, K_LDAP_PORT);
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION, K_LDAP_PROTOCOL_VERSION);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS, 0); // recommended for W2K3
			// bind anonymously and get dn for username.
			if (K_LDAP_UTF8) {
				$ldapusername = utf8_encode($_POST['xuser_name']);
				$ldappassword = utf8_encode($_POST['xuser_password']);
			} else {
				$ldapusername = $_POST['xuser_name'];
				$ldappassword = $_POST['xuser_password'];
			}
			if ($lbind = ldap_bind($ldapconn, $ldapusername, $ldappassword)) {
				// Search user on LDAP tree
				sort($ldap_attr);
				$ldap_filter = str_replace('#USERNAME#', $ldapusername, K_LDAP_FILTER);
				if ($search = @ldap_search($ldapconn, K_LDAP_BASE_DN, $ldap_filter, $ldap_attr)) {
					if ($rdn = @ldap_get_entries($ldapconn, $search)) {
						if (@ldap_bind($ldapconn, $rdn['dn'], $_POST['xuser_password'])) {
							@ldap_unbind($ldapconn);
							$usr = array();
							foreach ($ldap_attr as $k => $v) {
								if ((!empty($v)) AND isset($rdn[$v])) {
									$usr[$k] = $rdn[$v];
								} else {
									$usr[$k] = '';
								}
							}
							$usr['user_level'] = K_LDAP_USER_LEVEL;
							$usr['usrgrp_group_id'] = K_LDAP_USER_GROUP_ID;
							return $usr;
						}
					}
				}
			}
			@ldap_unbind($ldapconn);
		}
		// -------------------------------------------------------------
	}

	return false;
}

//=====================================================================+
// END OF FILE
//=====================================================================+
