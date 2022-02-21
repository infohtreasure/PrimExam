/*
============================================================
File name   : oracle_db_structure.sql
Begin       : 2009-10-09
Last Update : 2013-07-05

Description : primexam database structure.
Database    : Oracle

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

CREATE TABLE prime_sessions (
	cpsession_id VARCHAR2(32) NOT NULL,
	cpsession_expiry DATE NOT NULL,
	cpsession_data NCLOB NOT NULL,
constraint PK_prime_sessions_cpsession_id primary key (cpsession_id)
);

CREATE TABLE prime_users (
	user_id NUMBER(19,0) NOT NULL,
	user_name VARCHAR2(255) NOT NULL,
	user_password VARCHAR2(255) NOT NULL,
	user_email VARCHAR2(255),
	user_regdate DATE NOT NULL,
	user_ip VARCHAR2(39) NOT NULL,
	user_firstname VARCHAR2(255),
	user_lastname VARCHAR2(255),
	user_birthdate DATE,
	user_birthplace VARCHAR2(255),
	user_regnumber VARCHAR2(255),
	user_passport VARCHAR2(255),
	user_level NUMBER(5,0) DEFAULT 1 NOT NULL,
	user_verifycode VARCHAR2(32) UNIQUE,
	user_otpkey VARCHAR2(255),
constraint PK_prime_users_user_id primary key (user_id)
);
CREATE SEQUENCE prime_users_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_users_trigger BEFORE INSERT ON prime_users FOR EACH ROW BEGIN SELECT prime_users_seq.nextval INTO :new.user_id FROM DUAL; END;;


CREATE TABLE prime_modules (
	module_id NUMBER(19,0) NOT NULL,
	module_name VARCHAR2(255) NOT NULL,
	module_enabled NUMBER(1) DEFAULT '0' NOT NULL,
	module_user_id NUMBER(19,0) DEFAULT 1 NOT NULL,
constraint PK_prime_modules_module_id primary key (module_id)
);
CREATE SEQUENCE prime_modules_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_modules_trigger BEFORE INSERT ON prime_modules FOR EACH ROW BEGIN SELECT prime_modules_seq.nextval INTO :new.module_id FROM DUAL; END;;

CREATE TABLE prime_subjects (
	subject_id NUMBER(19,0) NOT NULL,
	subject_module_id NUMBER(19,0) DEFAULT 1 NOT NULL,
	subject_name VARCHAR2(255) NOT NULL,
	subject_description NCLOB,
	subject_enabled NUMBER(1) DEFAULT '0' NOT NULL,
	subject_user_id NUMBER(19,0) DEFAULT 1 NOT NULL,
constraint PK_prime_subjects_subject_id primary key (subject_id)
);
CREATE SEQUENCE prime_subjects_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_subjects_trigger BEFORE INSERT ON prime_subjects FOR EACH ROW BEGIN SELECT prime_subjects_seq.nextval INTO :new.subject_id FROM DUAL; END;;

CREATE TABLE prime_questions (
	question_id NUMBER(19,0) NOT NULL,
	question_subject_id NUMBER(19,0) NOT NULL,
	question_description NCLOB NOT NULL,
	question_explanation NCLOB NULL,
	question_type NUMBER(5,0) DEFAULT 1 NOT NULL,
	question_difficulty NUMBER(5,0) DEFAULT 1 NOT NULL,
	question_enabled NUMBER(1) DEFAULT '0' NOT NULL,
	question_position NUMBER(19,0) NULL,
	question_timer NUMBER(5,0) NULL,
	question_fullscreen NUMBER(1) DEFAULT '0' NOT NULL,
	question_inline_answers NUMBER(1) DEFAULT '0' NOT NULL,
	question_auto_next NUMBER(1) DEFAULT '0' NOT NULL,
constraint PK_prime_questions_question_id primary key (question_id)
);
CREATE SEQUENCE prime_questions_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_questions_trigger BEFORE INSERT ON prime_questions FOR EACH ROW BEGIN SELECT prime_questions_seq.nextval INTO :new.question_id FROM DUAL; END;;

CREATE TABLE prime_answers (
	answer_id NUMBER(19,0) NOT NULL,
	answer_question_id NUMBER(19,0) NOT NULL,
	answer_description NCLOB NOT NULL,
	answer_explanation NCLOB NULL,
	answer_isright NUMBER(1) DEFAULT '0' NOT NULL,
	answer_enabled NUMBER(1) DEFAULT '0' NOT NULL,
	answer_position NUMBER(19,0) NULL,
	answer_keyboard_key NUMBER(5,0) NULL,
constraint PK_prime_answers_answer_id primary key (answer_id)
);
CREATE SEQUENCE prime_answers_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_answers_trigger BEFORE INSERT ON prime_answers FOR EACH ROW BEGIN SELECT prime_answers_seq.nextval INTO :new.answer_id FROM DUAL; END;;

CREATE TABLE prime_tests (
	test_id NUMBER(19,0) NOT NULL,
	test_name VARCHAR2(255) NOT NULL,
	test_description NCLOB NOT NULL,
	test_begin_time DATE,
	test_end_time DATE,
	test_duration_time NUMBER(5,0) DEFAULT 0 NOT NULL,
	test_ip_range VARCHAR2(255) DEFAULT '*.*.*.*' NOT NULL,
	test_results_to_users NUMBER(1) DEFAULT '0' NOT NULL,
	test_report_to_users NUMBER(1) DEFAULT '0' NOT NULL,
	test_score_right NUMBER(10,3) DEFAULT 1,
	test_score_wrong NUMBER(10,3) DEFAULT 0,
	test_score_unanswered NUMBER(10,3) DEFAULT 0,
	test_max_score NUMBER(10,3) DEFAULT 0 NOT NULL,
	test_user_id NUMBER(19,0) DEFAULT 1 NOT NULL,
	test_score_threshold NUMBER(10,3) DEFAULT 0,
	test_random_questions_select NUMBER(1) DEFAULT '1' NOT NULL,
	test_random_questions_order NUMBER(1) DEFAULT '1' NOT NULL,
	test_questions_order_mode NUMBER(5,0) DEFAULT 0 NOT NULL,
	test_random_answers_select NUMBER(1) DEFAULT '1' NOT NULL,
	test_random_answers_order NUMBER(1) DEFAULT '1' NOT NULL,
	test_answers_order_mode NUMBER(5,0) DEFAULT 0 NOT NULL,
	test_comment_enabled NUMBER(1) DEFAULT '1' NOT NULL,
	test_menu_enabled NUMBER(1) DEFAULT '1' NOT NULL,
	test_noanswer_enabled NUMBER(1) DEFAULT '1' NOT NULL,
	test_mcma_radio NUMBER(1) DEFAULT '1' NOT NULL,
	test_repeatable NUMBER(1) DEFAULT '0' NOT NULL,
	test_mcma_partial_score NUMBER(1) DEFAULT '1' NOT NULL,
	test_logout_on_timeout Boolean NUMBER(1) DEFAULT '0' NOT NULL,
	test_password VARCHAR2(255),
constraint PK_prime_tests_test_id primary key (test_id)
);
CREATE SEQUENCE prime_tests_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_tests_trigger BEFORE INSERT ON prime_tests FOR EACH ROW BEGIN SELECT prime_tests_seq.nextval INTO :new.test_id FROM DUAL; END;;

CREATE TABLE prime_test_subjects (
	subjset_tsubset_id NUMBER(19,0) NOT NULL,
	subjset_subject_id NUMBER(19,0) NOT NULL,
constraint pk_prime_test_subjects primary key (subjset_tsubset_id,subjset_subject_id)
);

CREATE TABLE prime_tests_users (
	testuser_id NUMBER(19,0) NOT NULL,
	testuser_test_id NUMBER(19,0) NOT NULL,
	testuser_user_id NUMBER(19,0) NOT NULL,
	testuser_status NUMBER(5,0) DEFAULT 0 NOT NULL,
	testuser_creation_time DATE NOT NULL,
	testuser_comment NCLOB,
constraint pk_prime_tests_users primary key (testuser_id)
);
CREATE SEQUENCE prime_tests_users_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_tests_users_trigger BEFORE INSERT ON prime_tests_users FOR EACH ROW BEGIN SELECT prime_tests_users_seq.nextval INTO :new.testuser_id FROM DUAL; END;;

CREATE TABLE prime_tests_logs (
	testlog_id NUMBER(19,0) NOT NULL,
	testlog_testuser_id NUMBER(19,0) NOT NULL,
	testlog_user_ip VARCHAR2(39),
	testlog_question_id NUMBER(19,0) NOT NULL,
	testlog_answer_text NCLOB,
	testlog_score NUMBER(10,3),
	testlog_creation_time DATE,
	testlog_display_time DATE,
	testlog_change_time DATE,
	testlog_reaction_time NUMBER(19,0) DEFAULT 0 NOT NULL,
	testlog_order NUMBER(5,0) DEFAULT 1 NOT NULL,
	testlog_num_answers NUMBER(5,0) DEFAULT 0 NOT NULL,
	testlog_comment NCLOB,
constraint PK_prime_tests_logs_testlog_id primary key (testlog_id)
);
CREATE SEQUENCE prime_tests_logs_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_tests_logs_trigger BEFORE INSERT ON prime_tests_logs FOR EACH ROW BEGIN SELECT prime_tests_logs_seq.nextval INTO :new.testlog_id FROM DUAL; END;;

CREATE TABLE prime_tests_logs_answers (
	logansw_testlog_id NUMBER(19,0) NOT NULL,
	logansw_answer_id NUMBER(19,0) NOT NULL,
	logansw_selected NUMBER(5,0) DEFAULT -1 NOT NULL,
	logansw_order NUMBER(5,0) DEFAULT 1 NOT NULL,
	logansw_position NUMBER(19,0),
constraint pk_prime_tests_logs_answers primary key (logansw_testlog_id,logansw_answer_id)
);

CREATE TABLE prime_user_groups (
	group_id NUMBER(19,0) NOT NULL,
	group_name VARCHAR2(255) NOT NULL UNIQUE,
constraint pk_prime_user_groups primary key (group_id)
);
CREATE SEQUENCE prime_user_groups_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_user_groups_trigger BEFORE INSERT ON prime_user_groups FOR EACH ROW BEGIN SELECT prime_user_groups_seq.nextval INTO :new.group_id FROM DUAL; END;;

CREATE TABLE prime_usrgroups (
	usrgrp_user_id NUMBER(19,0) NOT NULL,
	usrgrp_group_id NUMBER(19,0) NOT NULL,
constraint pk_prime_usrgroups primary key (usrgrp_user_id,usrgrp_group_id)
);

CREATE TABLE prime_testgroups (
	tstgrp_test_id NUMBER(19,0) NOT NULL,
	tstgrp_group_id NUMBER(19,0) NOT NULL,
constraint pk_prime_testgroups primary key (tstgrp_test_id,tstgrp_group_id)
);

CREATE TABLE prime_test_subject_set (
	tsubset_id NUMBER(19,0) NOT NULL,
	tsubset_test_id NUMBER(19,0) NOT NULL,
	tsubset_type NUMBER(5,0) DEFAULT 1 NOT NULL,
	tsubset_difficulty NUMBER(5,0) DEFAULT 1 NOT NULL,
	tsubset_quantity NUMBER(5,0) DEFAULT 1 NOT NULL,
	tsubset_answers NUMBER(5,0) DEFAULT 0 NOT NULL,
constraint pk_prime_test_subject_set primary key (tsubset_id)
);
CREATE SEQUENCE prime_test_subject_set_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_test_subject_set_trigger BEFORE INSERT ON prime_test_subject_set FOR EACH ROW BEGIN SELECT prime_test_subject_set_seq.nextval INTO :new.tsubset_id FROM DUAL; END;;

CREATE TABLE prime_sslcerts (
	ssl_id NUMBER(19,0) NOT NULL,
	ssl_name VARCHAR2(255) NOT NULL,
	ssl_hash VARCHAR2(32) NOT NULL,
	ssl_end_date DATE NOT NULL,
	ssl_enabled NUMBER(1) DEFAULT '0' NOT NULL,
	ssl_user_id NUMBER(19,0) DEFAULT 1 NOT NULL,
constraint pk_prime_sslcerts primary key (ssl_id)
);
CREATE SEQUENCE prime_sslcerts_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_sslcerts_trigger BEFORE INSERT ON prime_sslcerts FOR EACH ROW BEGIN SELECT prime_sslcerts_seq.nextval INTO :new.tus_id FROM DUAL; END;;

CREATE TABLE prime_testsslcerts (
	tstssl_test_id NUMBER(19,0) NOT NULL,
	tstssl_ssl_id NUMBER(19,0) NOT NULL,
constraint pk_prime_testsslcerts primary key (tstssl_test_id, tstssl_ssl_id)
);

CREATE TABLE prime_testuser_stat (
	tus_id NUMBER(19,0) NOT NULL,
	tus_date DATE NOT NULL,
constraint pk_prime_testuser_stat primary key (tus_id)
);
CREATE SEQUENCE prime_testuser_stat_seq MINVALUE 1 START WITH 1 INCREMENT BY 1 CACHE 3;
CREATE OR REPLACE TRIGGER prime_testuser_stat_trigger BEFORE INSERT ON prime_testuser_stat FOR EACH ROW BEGIN SELECT prime_testuser_stat_seq.nextval INTO :new.tus_id FROM DUAL; END;;

/* Alternate Keys */

ALTER TABLE prime_users ADD Constraint ak_user_name UNIQUE (user_name);
ALTER TABLE prime_users ADD Constraint ak_user_regnumber UNIQUE (user_regnumber);
ALTER TABLE prime_users ADD Constraint ak_user_passport UNIQUE (user_passport);
ALTER TABLE prime_modules ADD Constraint ak_module_name UNIQUE (module_name);
ALTER TABLE prime_subjects ADD Constraint ak_subject_name UNIQUE (subject_module_id,subject_name);
ALTER TABLE prime_tests ADD Constraint ak_test_name UNIQUE (test_name);
ALTER TABLE prime_tests_users ADD Constraint ak_testuser UNIQUE (testuser_test_id,testuser_user_id,testuser_status);
ALTER TABLE prime_tests_logs ADD Constraint ak_testuser_question UNIQUE (testlog_testuser_id,testlog_question_id);

/*  Foreign Keys */

ALTER TABLE prime_tests_users ADD Constraint rel_user_tests foreign key (testuser_user_id) references prime_users (user_id) ON DELETE cascade;
ALTER TABLE prime_tests ADD Constraint rel_test_author foreign key (test_user_id) references prime_users (user_id) ON DELETE cascade;
ALTER TABLE prime_modules ADD Constraint rel_module_author foreign key (module_user_id) references prime_users (user_id) ON DELETE cascade;
ALTER TABLE prime_subjects ADD Constraint rel_subject_author foreign key (subject_user_id) references prime_users (user_id) ON DELETE cascade;
ALTER TABLE prime_subjects ADD Constraint rel_module_subjects foreign key (subject_module_id) references prime_modules (module_id) ON DELETE cascade;
ALTER TABLE prime_usrgroups ADD Constraint rel_user_group foreign key (usrgrp_user_id) references prime_users (user_id) ON DELETE cascade;
ALTER TABLE prime_questions ADD Constraint rel_subject_questions foreign key (question_subject_id) references prime_subjects (subject_id) ON DELETE cascade;
ALTER TABLE prime_answers ADD Constraint rel_question_answers foreign key (answer_question_id) references prime_questions (question_id) ON DELETE cascade;
ALTER TABLE prime_tests_users ADD Constraint rel_test_users foreign key (testuser_test_id) references prime_tests (test_id) ON DELETE cascade;
ALTER TABLE prime_testgroups ADD Constraint rel_test_group foreign key (tstgrp_test_id) references prime_tests (test_id) ON DELETE cascade;
ALTER TABLE prime_test_subject_set ADD Constraint rel_test_subjset foreign key (tsubset_test_id) references prime_tests (test_id) ON DELETE cascade;
ALTER TABLE prime_tests_logs ADD Constraint rel_testuser_logs foreign key (testlog_testuser_id) references prime_tests_users (testuser_id) ON DELETE cascade;
ALTER TABLE prime_tests_logs_answers ADD Constraint rel_testlog_answers foreign key (logansw_testlog_id) references prime_tests_logs (testlog_id) ON DELETE cascade;
ALTER TABLE prime_usrgroups ADD Constraint rel_group_user foreign key (usrgrp_group_id) references prime_user_groups (group_id) ON DELETE cascade;
ALTER TABLE prime_testgroups ADD Constraint rel_group_test foreign key (tstgrp_group_id) references prime_user_groups (group_id) ON DELETE cascade;
ALTER TABLE prime_test_subjects ADD Constraint rel_set_subjects foreign key (subjset_tsubset_id) references prime_test_subject_set (tsubset_id) ON DELETE cascade;
ALTER TABLE prime_testsslcerts ADD Constraint rel_test_ssl foreign key (tstssl_test_id) references prime_tests (test_id) ON DELETE cascade;
ALTER TABLE prime_testsslcerts ADD Constraint rel_ssl_test foreign key (tstssl_ssl_id) references prime_sslcerts (ssl_id) ON DELETE cascade;
