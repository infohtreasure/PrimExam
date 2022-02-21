<?php
//============================================================+
// File name   : prime_db_config.php
// Begin       : 2001-09-02
// Last Update : 2013-07-05
//
// Description : Database congiguration file.
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
 * Database congiguration file.
 * @package com.htreasure.primexam.shared.cfg
 * @author Ifeoluwa Opeyemi O
 * @since 2001-09-02
 */

/**
 * database type (MYSQL, POSTGRESQL, ORACLE)
 */
define ('K_DATABASE_TYPE', 'MYSQL');

/**
 * database Host name (eg: localhost)
 */
define ('K_DATABASE_HOST', 'localhost');

/**
 * database port (eg: 3306, 5432, 1521)
 */
define ('K_DATABASE_PORT', '3306');

/**
 * database name (primexam)
 */
define ('K_DATABASE_NAME', 'htreasur_prime');

/**
 * database user name
 */
define ('K_DATABASE_USER_NAME', 'htreasur_debby');

/**
 * database user password
 */
define ('K_DATABASE_USER_PASSWORD', 'S8Q6DHI3(C8)');

/**
 * prefix for database tables names
 */
define ('K_TABLE_PREFIX', 'prime_');

// -----------------------------------------------------------------------------
// --- DATABASE TABLES NAMES (DO NOT CHANGE) -----------------------------------
// -----------------------------------------------------------------------------

/**
 * This table stores information about users' Web sessions.
 */
define ('K_TABLE_SESSIONS', K_TABLE_PREFIX.'sessions');

/**
 * This table contains all registered users' data, including system administrators and a special 'anonymous' user.
 */
define ('K_TABLE_USERS', K_TABLE_PREFIX.'users');

/**
 * Table for modules. A module is a container for subjects.
 */
define ('K_TABLE_MODULES', K_TABLE_PREFIX.'modules');

/**
 * This table contains all tests subjects (topics, branch of studies).
 */
define ('K_TABLE_SUBJECTS', K_TABLE_PREFIX.'subjects');

/**
 * This table contains all questions relative to specific subjects.
 */
define ('K_TABLE_QUESTIONS', K_TABLE_PREFIX.'questions');

/**
 * This table contains all answers relative to a specific questions.
 */
define ('K_TABLE_ANSWERS', K_TABLE_PREFIX.'answers');

/**
 * This table contains all tests data.
 */
define ('K_TABLE_TESTS', K_TABLE_PREFIX.'tests');

/**
 * This table contains the list of tests generated for each user.
 */
define ('K_TABLE_TEST_USER', K_TABLE_PREFIX.'tests_users');

/**
 * This table counts the number of generated tests.
 */
define ('K_TABLE_TESTUSER_STAT', K_TABLE_PREFIX.'testuser_stat');

/**
 * This table lists the type and quantity of the questions associated to each set of subjects selected for a particular test.
 */
define ('K_TABLE_TEST_SUBJSET', K_TABLE_PREFIX.'test_subject_set');

/**
 * This table contains all tests subjects (topics, branch of studies).
 */
define ('K_TABLE_SUBJECT_SET', K_TABLE_PREFIX.'test_subjects');

/**
 * This table contains all questions and user answers relative to a specific test for a specific user.
 */
define ('K_TABLE_TESTS_LOGS', K_TABLE_PREFIX.'tests_logs');

/**
 * This table contains the list of the selected alternative answers for each multiple-choice question.
 */
define ('K_TABLE_LOG_ANSWER', K_TABLE_PREFIX.'tests_logs_answers');

/**
 * This table contains users' groups. Each user belongs to one of the groups defined in this table.
 */
define ('K_TABLE_GROUPS', K_TABLE_PREFIX.'user_groups');

/**
 * This table contains the list of groups to whom each user belongs.
 */
define ('K_TABLE_USERGROUP', K_TABLE_PREFIX.'usrgroups');

/**
 * This table contains the list of groups enabled for a selected test.
 */
define ('K_TABLE_TEST_GROUPS', K_TABLE_PREFIX.'testgroups');

/**
 * This table contains the SSL certificates.
 */
define ('K_TABLE_SSLCERTS', K_TABLE_PREFIX.'sslcerts');

/**
 * This table contains the list of SSL certificates enabled for a selected test.
 */
define ('K_TABLE_TEST_SSLCERTS', K_TABLE_PREFIX.'testsslcerts');

//============================================================+
// END OF FILE
//============================================================+
