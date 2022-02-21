<?php
//============================================================+
// File name   : prime_db_connect.php
// Begin       : 2001-09-02
// Last Update : 2014-01-26
//
// Description : open connection with active database
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
//    Copyright (C) 2004-2014  Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Open a connection to a MySQL Server and select a database.
 * @package com.htreasure.primexam.shared
 * @author Ifeoluwa Opeyemi O
 * @since 2001-09-02
 */

/**
 */

require_once('../../shared/code/prime_db_dal.php'); // Database Abstraction Layer for selected DATABASE type

if (!$db = @F_db_connect(K_DATABASE_HOST, K_DATABASE_PORT, K_DATABASE_USER_NAME, K_DATABASE_USER_PASSWORD, K_DATABASE_NAME)) {
	die('<h2>Unable to connect to the database!</h2>');
}

//============================================================+
// END OF FILE
//============================================================+
