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
 *      $Id: install_plugin.php 32877 2013-03-19 03:48:10Z liulanbo $
 */

define('IN_COMSENZ', TRUE);
define('IN_ADMINCP', TRUE);

chdir('../../');

require_once './source/class/class_core.php';

$discuz = C::app();
$discuz->init_cron = false;
$discuz->init_session = false;
$discuz->init();

if($_GET['key'] !== md5($_G['setting']['authkey'].$_SERVER['REMOTE_ADDR'])) {
	exit;
}

$plugins = array('qqconnect', 'cloudstat', 'soso_smilies', 'cloudsearch', 'qqgroup', 'security', 'xf_storage', 'pcmgr_url_safeguard');

require_once libfile('function/plugin');
require_once libfile('function/admincp');
require_once libfile('function/cache');

foreach($plugins as $pluginid) {
	$importfile = DISCUZ_ROOT.'./source/plugin/'.$pluginid.'/discuz_plugin_'.$pluginid.'.xml';
	$importtxt = @implode('', file($importfile));
	$pluginarray = getimportdata('Discuz! Plugin', $importtxt);
	if(plugininstall($pluginarray)) {
		if(!empty($pluginarray['installfile']) && file_exists(DISCUZ_ROOT.'./source/plugin/'.$pluginid.'/'.$pluginarray['installfile'])) {
			@include_once DISCUZ_ROOT.'./source/plugin/'.$pluginid.'/'.$pluginarray['installfile'];
		}
	}
}

?>