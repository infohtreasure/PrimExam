<?php
//============================================================+
// File name   : prime_httpbasic.php
// Begin       : 2010-09-10
// Last Update : 2012-09-11
//
// Description : Configuration file for HTTP Basic Auth
//
// Author: Matthias Wolf, Ifeoluwa Opeyemi O
//
// (c) Copyright:
//               Matthias Wolf
//               Freiwillige Feuerwehr München
//               m.wolf@ffw-muenchen.de
//
//               Ifeoluwa Opeyemi O
//               Hidden Tresure Computers Ltd
//               www.htreasure.com
//               info@htreasure.com
//
// License:
//    Copyright (C) 2010   Matthias Wolf - Freiwillige Feuerwehr München, Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Configuration file for HTTP Basic Authentication
 * HTTP Basic Authentication is a procedure handled by the WebServer.
 * The server grants access to the requested resource only if username and password can be verified against a file or a plugin.
 * If support for HTTP Basic Auth is enabled, primexam trusts this mechanism and replicates any authenticated user into the primexam database.
 * WARNING: On logout, primexam automatically disable the HTTP Basic Authentication. To restore the HTTP Basic Authentication the user must clear the cache of the browser.
 * @package com.htreasure.primexam.shared.cfg
 * @author Matthias Wolf, Ifeoluwa Opeyemi O
 * @since 2010-09-16
 */

/**
 * If true trust HTTP Basic Auth
 */
define ('K_HTTPBASIC_ENABLED', false);

/**
 * Default user level
 */
define ('K_HTTPBASIC_USER_LEVEL', 1);

/**
 * Default user group ID
 * This is the primexam group id to which the accounts belong.
 * You can also set 0 for all available groups or a string containing a comma-separated list of group IDs.
 */
define ('K_HTTPBASIC_USER_GROUP_ID', 1);

//============================================================+
// END OF FILE
//============================================================+
