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

define('IN_MOBILE', 4);
define('IN_NEWMOBILE', true);

global $_G;

chdir('../');
require './source/class/class_core.php';

$discuz = C::app();

$discuz->reject_robot();
$discuz->init_cron = false;
$discuz->init_session = false;
$discuz->init_user = false;
$discuz->init_mobile = false;

$discuz->init();

if(!file_exists(DISCUZ_ROOT . $_G['style']['tpldir'] . '/m')) {
	$_G['style']['tpldir'] = './template/default';
}

if ($_GET['c'] == 'static') {
	$path = DISCUZ_ROOT . $_G['style']['tpldir'] . '/m/js/';
	$bpath = DISCUZ_ROOT . 'template/default/m/js/';
	header("Content-type: application/json");
	$files = explode(',', $_GET['f']);
	$version = $_GET['v'];
	$cachename = 'static_' . md5($_GET['f']) . $version;
	if (!$files) {
		$array = array('code' => 1);
		echo json_encode($array);
		exit;
	}
	$contents = array();
	foreach ($files as $file) {
		if (strpos($file, '..') !== false) {
			continue;
		}
		$filename = file_exists($path . $file) ? $path . $file : $bpath . $file;
		$contents[$file] = file_get_contents($filename);
	}
	$array = array('code' => 0, 'file' => $contents);
	$result = json_encode($array);
	echo $result;
	exit;
}

$jsglobal = array(
    'source' => '',
    'cookiepre' => $discuz->config['cookie']['cookiepre'],
    'jsversion' => !$discuz->config['debug'] ? $_G['style']['verhash'] : time(),
    'f' => '',
    'path' => '',
    'formhash' => FORMHASH,
    'plugins' => array()
);

$site = array(
    'siteId' => 0,
    'siteUrl' => $_G['siteurl'],
    'siteName' => diconv($_G['setting']['sitename'], CHARSET, 'UTF-8'),
    'siteLogo' => $_G['siteurl'] . '/static/image/common/logom.png',
    'openApi' => array(),
);

if (!$_G['setting']['mobile']['allowmnew']) {
	dheader('location: ' . $_G['siteurl']);
}

$a = $_GET['a'] && preg_match('/^\w+$/', $_GET['a']) ? $_GET['a'] : 'forumlist';

include template('m/' . $a);