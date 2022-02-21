/*
============================================================
File name   : postgresql_db_structure.sql
Begin       : 2004-04-28
Last Update : 2013-07-02

Description : primexam database structure.
Database    : PostgreSQL 8+

Author: Ifeoluwa Opeyemi O

(c) Copyright:
              Ifeoluwa Opeyemi O
              htreasure.com LTD
              www.htreasure.com
              info@htreasure.com

License:
   Copyright (C) 2004-2013 Ifeoluwa Opeyemi O - htreasure.com LTD

   This program is free software: you can redistribute it and/or modify
   it under the terms of the GNU Affero General Public License as
   published by the Free Software Foundation, either version 3 of the
   License, or (at your option) any later version.

   This program is distributed in the hope that it will be useful,
   but WITHOUT ANY WARRANTY; without even the implied warranty of
   MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
   GNU Affero General Public License for more details.

   You should have received a copy of the GNU Affero General Public License
   along with this program.  If not, see <http://www.gnu.org/licenses/>.

   Additionally, you can't remove, move or hide the original primexam logo,
   copyrights statements and links to htreasure.com and primexam websites.

   See LICENSE.TXT file for more information.
//============================================================+
*/

/* Tables */

CREATE TABLE "prime_sessions" (
	"cpsession_id" Varchar(32) NOT NULL,
	"cpsession_expiry" Timestamp NOT NULL,
	"cpsession_data" Text NOT NULL,
constraint "PK_prime_sessions_cpsession_id" primary key ("cpsession_id")
) Without Oids;

CREATE TABLE "prime_users" (
	"user_id" BigSerial NOT NULL,
	"user_name" Varchar(255) NOT NULL,
	"user_password" Varchar(255) NOT NULL,
	"user_email" Varchar(255),
	"user_regdate" Timestamp NOT NULL,
	"user_ip" Varchar(39) NOT NULL,
	"user_firstname" Varchar(255),
	"user_lastname" Varchar(255),
	"user_birthdate" Date,
	"user_birthplace" Varchar(255),
	"user_regnumber" Varchar(255),
	"user_passport" Varchar(255),
	"user_level" Smallint NOT NULL Default 1,
	"user_verifycode" Varchar(32) UNIQUE,
	"user_otpkey" Varchar(255),
constraint "PK_prime_users_user_id" primary key ("user_id")
) Without Oids;

CREATE TABLE "prime_modules" (
	"module_id" BigSerial NOT NULL,
	"module_name" Varchar(255) NOT NULL,
	"module_enabled" Boolean NOT NULL Default '0',
	"module_user_id" Bigint NOT NULL Default 1,
constraint "PK_prime_modules_module_id" primary key ("module_id")
) Without Oids;

CREATE TABLE "prime_subjects" (
	"subject_id" BigSerial NOT NULL,
	"subject_module_id" Bigint NOT NULL Default 1,
	"subject_name" Varchar(255) NOT NULL,
	"subject_description" Text,
	"subject_enabled" Boolean NOT NULL Default '0',
	"subject_user_id" Bigint NOT NULL Default 1,
constraint "PK_prime_subjects_subject_id" primary key ("subject_id")
) Without Oids;

CREATE TABLE "prime_questions" (
	"question_id" BigSerial NOT NULL,
	"question_subject_id" Bigint NOT NULL,
	"question_description" Text NOT NULL,
	"question_explanation" Text NULL,
	"question_type" Smallint NOT NULL Default 1,
	"question_difficulty" Smallint NOT NULL Default 1,
	"question_enabled" Boolean NOT NULL Default '0',
	"question_position" Bigint NULL,
	"question_timer" Smallint NULL,
	"question_fullscreen" Boolean NOT NULL Default '0',
	"question_inline_answers" Boolean NOT NULL DEFAULT '0',
	"question_auto_next" Boolean NOT NULL DEFAULT '0',
constraint "PK_prime_questions_question_id" primary key ("question_id")
) Without Oids;

CREATE TABLE "prime_answers" (
	"answer_id" BigSerial NOT NULL,
	"answer_question_id" Bigint NOT NULL,
	"answer_description" Text NOT NULL,
	"answer_explanation" Text NULL,
	"answer_isright" Boolean NOT NULL Default '0',
	"answer_enabled" Boolean NOT NULL Default '0',
	"answer_position" Bigint NULL,
	"answer_keyboard_key" Smallint NULL,
constraint "PK_prime_answers_answer_id" primary key ("answer_id")
) Without Oids;

CREATE TABLE "prime_tests" (
	"test_id" BigSerial NOT NULL,
	"test_name" Varchar(255) NOT NULL,
	"test_description" Text NOT NULL,
	"test_begin_time" Timestamp,
	"test_end_time" Timestamp,
	"test_duration_time" Smallint NOT NULL Default 0,
	"test_ip_range" Varchar(255) NOT NULL Default '*.*.*.*',
	"test_results_to_users" Boolean NOT NULL Default '0',
	"test_report_to_users" Boolean NOT NULL Default '0',
	"test_score_right" Numeric(10,3) Default 1,
	"test_score_wrong" Numeric(10,3) Default 0,
	"test_score_unanswered" Numeric(10,3) Default 0,
	"test_max_score" Numeric(10,3) NOT NULL Default 0,
	"test_user_id" Bigint NOT NULL Default 1,
	"test_score_threshold" Numeric(10,3) Default 0,
	"test_random_questions_select" Boolean NOT NULL Default '1',
	"test_random_questions_order" Boolean NOT NULL Default '1',
	"test_questions_order_mode" Smallint NOT NULL Default 0,
	"test_random_answers_select" Boolean NOT NULL Default '1',
	"test_random_answers_order" Boolean NOT NULL Default '1',
	"test_answers_order_mode" Smallint NOT NULL Default 0,
	"test_comment_enabled" Boolean NOT NULL Default '1',
	"test_menu_enabled" Boolean NOT NULL Default '1',
	"test_noanswer_enabled" Boolean NOT NULL Default '1',
	"test_mcma_radio" Boolean NOT NULL Default '1',
	"test_repeatable" Boolean NOT NULL Default '0',
	"test_mcma_partial_score" Boolean NOT NULL Default '1',
	"test_logout_on_timeout" Boolean NOT NULL Default '0',
	"test_password" Varchar(255),
constraint "PK_prime_tests_test_id" primary key ("test_id")
) Without Oids;

CREATE TABLE "prime_test_subjects" (
	"subjset_tsubset_id" Bigint NOT NULL,
	"subjset_subject_id" Bigint NOT NULL,
constraint "pk_prime_test_subjects" primary key ("subjset_tsubset_id","subjset_subject_id")
) Without Oids;

CREATE TABLE "prime_tests_users" (
	"testuser_id" BigSerial NOT NULL,
	"testuser_test_id" Bigint NOT NULL,
	"testuser_user_id" Bigint NOT NULL,
	"testuser_status" Smallint NOT NULL Default 0,
	"testuser_creation_time" Timestamp NOT NULL,
	"testuser_comment" Text,
constraint "pk_prime_tests_users" primary key ("testuser_id")
) Without Oids;

CREATE TABLE "prime_tests_logs" (
	"testlog_id" BigSerial NOT NULL,
	"testlog_testuser_id" Bigint NOT NULL,
	"testlog_user_ip" Varchar(39),
	"testlog_question_id" Bigint NOT NULL,
	"testlog_answer_text" Text,
	"testlog_score" Numeric(10,3),
	"testlog_creation_time" Timestamp,
	"testlog_display_time" Timestamp,
	"testlog_change_time" Timestamp,
	"testlog_reaction_time" Bigint NOT NULL Default 0,
	"testlog_order" Smallint NOT NULL Default 1,
	"testlog_num_answers" Smallint NOT NULL Default 0,
	"testlog_comment" Text,
constraint "PK_prime_tests_logs_testlog_id" primary key ("testlog_id")
) Without Oids;

CREATE TABLE "prime_tests_logs_answers" (
	"logansw_testlog_id" Bigint NOT NULL,
	"logansw_answer_id" Bigint NOT NULL,
	"logansw_selected" Smallint NOT NULL Default -1,
	"logansw_order" Smallint NOT NULL Default 1,
	"logansw_position" Bigint,
constraint "pk_prime_tests_logs_answers" primary key ("logansw_testlog_id","logansw_answer_id")
) Without Oids;

CREATE TABLE "prime_user_groups" (
	"group_id" BigSerial NOT NULL,
	"group_name" Varchar(255) NOT NULL UNIQUE,
constraint "pk_prime_user_groups" primary key ("group_id")
) Without Oids;

CREATE TABLE "prime_usrgroups" (
	"usrgrp_user_id" Bigint NOT NULL,
	"usrgrp_group_id" Bigint NOT NULL,
constraint "pk_prime_usrgroups" primary key ("usrgrp_user_id","usrgrp_group_id")
) Without Oids;

CREATE TABLE "prime_testgroups" (
	"tstgrp_test_id" Bigint NOT NULL,
	"tstgrp_group_id" Bigint NOT NULL,
constraint "pk_prime_testgroups" primary key ("tstgrp_test_id","tstgrp_group_id")
) Without Oids;

CREATE TABLE "prime_test_subject_set" (
	"tsubset_id" BigSerial NOT NULL,
	"tsubset_test_id" Bigint NOT NULL,
	"tsubset_type" Smallint NOT NULL Default 1,
	"tsubset_difficulty" Smallint NOT NULL Default 1,
	"tsubset_quantity" Smallint NOT NULL Default 1,
	"tsubset_answers" Smallint NOT NULL Default 0,
constraint "pk_prime_test_subject_set" primary key ("tsubset_id")
) Without Oids;

CREATE TABLE "prime_sslcerts" (
	"ssl_id" BigSerial NOT NULL,
	"ssl_name" Varchar(255) NOT NULL,
	"ssl_hash" Varchar(32) NOT NULL,
	"ssl_end_date" Timestamp NOT NULL,
	"ssl_enabled" Boolean NOT NULL Default '0',
	"ssl_user_id" Bigint NOT NULL Default 1,
constraint "pk_prime_sslcerts" primary key ("ssl_id")
) Without Oids;

CREATE TABLE "prime_testsslcerts" (
	"tstssl_test_id" Bigint NOT NULL,
	"tstssl_ssl_id" Bigint NOT NULL,
constraint "pk_prime_testsslcerts" primary key ("tstssl_test_id", "tstssl_ssl_id")
) Without Oids;

CREATE TABLE "prime_testuser_stat" (
	"tus_id" BigSerial NOT NULL,
	"tus_date" Timestamp NOT NULL,
constraint "pk_prime_testuser_stat" primary key ("tus_id")
) Without Oids;

/* Alternate Keys */

ALTER TABLE "prime_users" ADD CONSTRAINT "ak_user_name" UNIQUE ("user_name");
ALTER TABLE "prime_users" ADD CONSTRAINT "ak_user_regnumber" UNIQUE ("user_regnumber");
ALTER TABLE "prime_users" ADD CONSTRAINT "ak_user_passport" UNIQUE ("user_passport");
ALTER TABLE "prime_modules" ADD CONSTRAINT "ak_module_name" UNIQUE ("module_name");
ALTER TABLE "prime_subjects" ADD CONSTRAINT "ak_subject_name" UNIQUE ("subject_module_id","subject_name");
ALTER TABLE "prime_tests" ADD CONSTRAINT "ak_test_name" UNIQUE ("test_name");
ALTER TABLE "prime_tests_users" ADD CONSTRAINT "ak_testuser" UNIQUE ("testuser_test_id","testuser_user_id","testuser_status");
ALTER TABLE "prime_tests_logs" ADD CONSTRAINT "ak_testuser_question" UNIQUE ("testlog_testuser_id","testlog_question_id");

/*  Foreign Keys */

ALTER TABLE "prime_tests_users" ADD CONSTRAINT "rel_user_tests" foreign key ("testuser_user_id") references "prime_users" ("user_id") ON DELETE cascade;
ALTER TABLE "prime_tests" ADD CONSTRAINT "rel_test_author" foreign key ("test_user_id") references "prime_users" ("user_id") ON DELETE cascade;
ALTER TABLE "prime_modules" ADD CONSTRAINT "rel_module_author" foreign key ("module_user_id") references "prime_users" ("user_id") ON DELETE cascade;
ALTER TABLE "prime_subjects" ADD CONSTRAINT "rel_subject_author" foreign key ("subject_user_id") references "prime_users" ("user_id") ON DELETE cascade;
ALTER TABLE "prime_subjects" ADD CONSTRAINT "rel_module_subjects" foreign key ("subject_module_id") references "prime_modules" ("module_id") ON DELETE cascade;
ALTER TABLE "prime_usrgroups" ADD CONSTRAINT "rel_user_group" foreign key ("usrgrp_user_id") references "prime_users" ("user_id") ON DELETE cascade;
ALTER TABLE "prime_questions" ADD CONSTRAINT "rel_subject_questions" foreign key ("question_subject_id") references "prime_subjects" ("subject_id") ON DELETE cascade;
ALTER TABLE "prime_test_subjects" ADD CONSTRAINT "rel_subject_set" foreign key ("subjset_subject_id") references "prime_subjects" ("subject_id") ON DELETE restrict;
ALTER TABLE "prime_answers" ADD CONSTRAINT "rel_question_answers" foreign key ("answer_question_id") references "prime_questions" ("question_id") ON DELETE cascade;
ALTER TABLE "prime_tests_logs" ADD CONSTRAINT "rel_question_logs" foreign key ("testlog_question_id") references "prime_questions" ("question_id") ON DELETE restrict;
ALTER TABLE "prime_tests_logs_answers" ADD CONSTRAINT "rel_answer_logs" foreign key ("logansw_answer_id") references "prime_answers" ("answer_id") ON DELETE restrict;
ALTER TABLE "prime_tests_users" ADD CONSTRAINT "rel_test_users" foreign key ("testuser_test_id") references "prime_tests" ("test_id") ON UPDATE restrict ON DELETE cascade;
ALTER TABLE "prime_testgroups" ADD CONSTRAINT "rel_test_group" foreign key ("tstgrp_test_id") references "prime_tests" ("test_id") ON DELETE cascade;
ALTER TABLE "prime_test_subject_set" ADD CONSTRAINT "rel_test_subjset" foreign key ("tsubset_test_id") references "prime_tests" ("test_id") ON DELETE cascade;
ALTER TABLE "prime_tests_logs" ADD CONSTRAINT "rel_testuser_logs" foreign key ("testlog_testuser_id") references "prime_tests_users" ("testuser_id") ON DELETE cascade;
ALTER TABLE "prime_tests_logs_answers" ADD CONSTRAINT "rel_testlog_answers" foreign key ("logansw_testlog_id") references "prime_tests_logs" ("testlog_id") ON DELETE cascade;
ALTER TABLE "prime_usrgroups" ADD CONSTRAINT "rel_group_user" foreign key ("usrgrp_group_id") references "prime_user_groups" ("group_id") ON DELETE cascade;
ALTER TABLE "prime_testgroups" ADD CONSTRAINT "rel_group_test" foreign key ("tstgrp_group_id") references "prime_user_groups" ("group_id") ON DELETE cascade;
ALTER TABLE "prime_test_subjects" ADD CONSTRAINT "rel_set_subjects" foreign key ("subjset_tsubset_id") references "prime_test_subject_set" ("tsubset_id") ON DELETE cascade;
ALTER TABLE "prime_testsslcerts" ADD CONSTRAINT "rel_test_ssl" foreign key ("tstssl_test_id") references "prime_tests" ("test_id") ON DELETE cascade;
ALTER TABLE "prime_testsslcerts" ADD CONSTRAINT "rel_ssl_test" foreign key ("tstssl_ssl_id") references "prime_sslcerts" ("ssl_id") ON DELETE cascade;
