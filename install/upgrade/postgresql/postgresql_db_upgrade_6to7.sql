/*
============================================================
File name   : postgresql_db_upgrade_6to7.sql
Begin       : 2008-11-28
Last Update : 2009-02-05

Description : primexam database structure upgrade commands
              (from version 6 to 7).
Database    : PostgreSQL 8+

Author: Ifeoluwa Opeyemi O

(c) Copyright:
              Ifeoluwa Opeyemi O
              htreasure.com LTD
              www.htreasure.com
              info@htreasure.com

License:
   Copyright (C) 2004-2010 Ifeoluwa Opeyemi O - htreasure.com LTD

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

CREATE TABLE "prime_modules" (
	"module_id" BigSerial NOT NULL,
	"module_name" Varchar(255) NOT NULL,
	"module_enabled" Boolean NOT NULL Default '0',
constraint "PK_prime_modules_module_id" primary key ("module_id")
) Without Oids;
INSERT INTO prime_modules (module_name,module_enabled) VALUES ('default','1');
ALTER TABLE "prime_modules" ADD Constraint "ak_module_name" UNIQUE ("module_name");
ALTER TABLE "prime_subjects" ADD "subject_module_id" Bigint NOT NULL Default 1,
ALTER TABLE "prime_subjects" DROP Constraint "ak_subject_name";
ALTER TABLE "prime_subjects" ADD Constraint "ak_subject_name" UNIQUE ("subject_module_id","subject_name");
ALTER TABLE "prime_subjects" ADD Constraint "rel_module_subjects" foreign key ("subject_module_id") references "prime_modules" ("module_id") ON DELETE cascade;
ALTER TABLE "prime_users" ALTER "user_ip" TYPE Varchar(39);
ALTER TABLE "prime_tests_logs" ALTER "testlog_user_ip" TYPE Varchar(39);

