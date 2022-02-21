/*
============================================================
File name   : postgresql_db_upgrade_4to5.sql
Begin       : 2007-08-25
Last Update : 2007-08-25

Description : primexam database structure upgrade commands
              (from version 4 to 5).
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

ALTER TABLE "prime_answers" ADD "answer_position" Bigint NULL;
ALTER TABLE "prime_tests_logs_answers" ADD "logansw_position" Bigint NULL;
ALTER TABLE "prime_answers" DROP CONSTRAINT "ak_answer", ADD CONSTRAINT "ak_answer" UNIQUE ("answer_question_id","answer_description","answer_position");
