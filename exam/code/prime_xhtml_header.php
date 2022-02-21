<?php
//============================================================+
// File name   : prime_xhtml_header.php
// Begin       : 2004-04-24
// Last Update : 2013-01-29
//
// Description : Output defaults XHTML header (doctype + head).
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
//    Copyright (C) 2004-2013  Ifeoluwa Opeyemi O - Hidden Tresure Computers Ltd
//    See LICENSE.TXT file for more information.
//============================================================+

/**
 * @file
 * Outputs default XHTML header (doctype + head).
 * @package com.htreasure.primexam/exam
 * @author Ifeoluwa Opeyemi O
 * @since 2004-04-24
 * int $pagelevel page access level (0-10), default 0
 * string $thispage_title page title, default K_SITE_TITLE
 * string $thispage_description page description, default K_SITE_DESCRIPTION
 * string $thispage_author page author, default K_SITE_AUTHOR
 * string $thispage_reply page reply to, default K_SITE_REPLY_TO
 * string $thispage_keywords page keywords, default K_SITE_KEYWORDS
 * string $thispage_icon page icon, default K_SITE_ICON
 * string $thispage_style page CSS file name, default K_SITE_STYLE
 */

/**
 */

// if necessary load default values
if(!isset($pagelevel) OR empty($pagelevel)) {$pagelevel = 0;}
if(!isset($thispage_title) OR empty($thispage_title)) {$thispage_title = K_SITE_TITLE;}
if(!isset($thispage_description) OR empty($thispage_description)) {$thispage_description = K_SITE_DESCRIPTION;}
if(!isset($thispage_author) OR empty($thispage_author)) {$thispage_author = K_SITE_AUTHOR;}
if(!isset($thispage_reply) OR empty($thispage_reply)) {$thispage_reply = K_SITE_REPLY;}
if(!isset($thispage_keywords) OR empty($thispage_keywords)) {$thispage_keywords = K_SITE_KEYWORDS;}
if(!isset($thispage_icon) OR empty($thispage_icon)) {$thispage_icon = K_SITE_ICON;}
if(!isset($thispage_style) OR empty($thispage_style)) {
	if(strcasecmp($l['a_meta_dir'], 'rtl') == 0) {
		$thispage_style = K_SITE_STYLE_RTL;
	} else {
		$thispage_style = K_SITE_STYLE;
	}
}

echo '<'.'?'.'xml version="1.0" encoding="'.$l['a_meta_charset'].'" '.'?'.'>'.K_NEWLINE;
echo '<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">'.K_NEWLINE;
echo '<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="'.$l['a_meta_language'].'" lang="'.$l['a_meta_language'].'" dir="'.$l['a_meta_dir'].'">'.K_NEWLINE;

echo '<head>'.K_NEWLINE;
echo '<title>'.htmlspecialchars($thispage_title, ENT_NOQUOTES, $l['a_meta_charset']).'</title>'.K_NEWLINE;
echo '<meta http-equiv="Content-Type" content="text/html; charset='.$l['a_meta_charset'].'" />'.K_NEWLINE;
echo '<meta name="language" content="'.$l['a_meta_language'].'" />'.K_NEWLINE;
echo '<meta name="primexam_level" content="'.$pagelevel.'" />'.K_NEWLINE;
echo '<meta name="description" content="'."PRIMExam".' '.htmlspecialchars($thispage_description, ENT_COMPAT, $l['a_meta_charset']).' " />'.K_NEWLINE;
echo '<meta name="author" content="ifeoluwa"/>'.K_NEWLINE;
echo '<meta name="reply-to" content="'.htmlspecialchars($thispage_reply, ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
echo '<meta name="keywords" content="'.htmlspecialchars($thispage_keywords, ENT_COMPAT, $l['a_meta_charset']).'" />'.K_NEWLINE;
echo '<link rel="stylesheet" href="'.$thispage_style.'" type="text/css" />'.K_NEWLINE;
echo '<link rel="shortcut icon" href="'.$thispage_icon.'" />'.K_NEWLINE;
// calendar
if (isset($enable_calendar) AND $enable_calendar) {
	echo '<style type="text/css">@import url('.K_PATH_SHARED_JSCRIPTS.'jscalendar/calendar-blue.css);</style>'.K_NEWLINE;
	echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/calendar.js"></script>'.K_NEWLINE;
	if (file_exists(''.K_PATH_SHARED_JSCRIPTS.'jscalendar/lang/calendar-'.$l['a_meta_language'].'.js')) {
		echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/lang/calendar-'.$l['a_meta_language'].'.js"></script>'.K_NEWLINE;
	} else {
		echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/lang/calendar-en.js"></script>'.K_NEWLINE;
	}
	echo '<script type="text/javascript" src="'.K_PATH_SHARED_JSCRIPTS.'jscalendar/calendar-setup.js"></script>'.K_NEWLINE;
}
echo '<!-- '.'P'.'R'.'I'.'M'.'E'.'x'.'a'.'m'.'19'.'85'.'02'.'22'.' -->'.K_NEWLINE;
echo '</head>'.K_NEWLINE;

echo '<body>'.K_NEWLINE;

global $login_error;
if (isset($login_error) AND $login_error) {
	F_print_error('WARNING', $l['m_login_wrong']);
}

//============================================================+
// END OF FILE
//============================================================+
