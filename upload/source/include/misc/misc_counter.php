<?php
/*
 *
 *  * Copyright 2012-2020 the original author or authors.
 *  *
 *  * Licensed under the Apache License, Version 2.0 (the "License");
 *  * you may not use this file except in compliance with the License.
 *  * You may obtain a copy of the License at
 *  *
 *  *      https://www.apache.org/licenses/LICENSE-2.0
 *  *
 *  * Unless required by applicable law or agreed to in writing, software
 *  * distributed under the License is distributed on an "AS IS" BASIS,
 *  * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 *  * See the License for the specific language governing permissions and
 *  * limitations under the License.
 *
 */

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: misc_counter.php 25889 2011-11-24 09:52:20Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$visitor = array();

$visitor['agent'] = $_SERVER['HTTP_USER_AGENT'];
list($visitor['month'], $visitor['week'], $visitor['hour']) = explode("\t", dgmdate(TIMESTAMP, "Ym\tw\tH"));

if(!$sessionexists) {
	if(strexists($visitor['agent'], 'Netscape')) {
		$visitor['browser'] = 'Netscape';
	} elseif(strexists($visitor['agent'], 'Lynx')) {
		$visitor['browser'] = 'Lynx';
	} elseif(strexists($visitor['agent'], 'Opera')) {
		$visitor['browser'] = 'Opera';
	} elseif(strexists($visitor['agent'], 'Konqueror')) {
		$visitor['browser'] = 'Konqueror';
	} elseif(strexists($visitor['agent'], 'MSIE')) {
		$visitor['browser'] = 'MSIE';
	} elseif(strexists($visitor['agent'], 'Firefox')) {
		$visitor['browser'] = 'Firefox';
	} elseif(strexists($visitor['agent'], 'Safari')) {
		$visitor['browser'] = 'Safari';
	} elseif(substr($visitor['agent'], 0, 7) == 'Mozilla') {
		$visitor['browser'] = 'Mozilla';
	} else {
		$visitor['browser'] = 'Other';
	}

	if(strexists($visitor['agent'], 'Win')) {
		$visitor['os'] = 'Windows';
	} elseif(strexists($visitor['agent'], 'Mac')) {
		$visitor['os'] = 'Mac';
	} elseif(strexists($visitor['agent'], 'Linux')) {
		$visitor['os'] = 'Linux';
	} elseif(strexists($visitor['agent'], 'FreeBSD')) {
		$visitor['os'] = 'FreeBSD';
	} elseif(strexists($visitor['agent'], 'SunOS')) {
		$visitor['os'] = 'SunOS';
	} elseif(strexists($visitor['agent'], 'OS/2')) {
		$visitor['os'] = 'OS/2';
	} elseif(strexists($visitor['agent'], 'AIX')) {
		$visitor['os'] = 'AIX';
	} elseif(preg_match("/(Bot|Crawl|Spider)/i", $visitor['agent'])) {
		$visitor['os'] = 'Spiders';
	} else {
		$visitor['os'] = 'Other';
	}
	$visitorsadd = "OR (type='browser' AND variable='$visitor[browser]') OR (type='os' AND variable='$visitor[os]')".
		($_G['username'] ? " OR (type='total' AND variable='members')" : " OR (type='total' AND variable='guests')");
	$updatedrows = 7;
} else {
	$visitorsadd = '';
	$updatedrows = 4;
}


?>