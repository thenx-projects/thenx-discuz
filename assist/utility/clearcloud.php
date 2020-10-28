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
 *      $Id: update.php 36348 2017-01-13 06:36:44Z nemohou $
 */

include_once('../source/class/class_core.php');
include_once('../source/function/function_core.php');

@set_time_limit(0);

$cachelist = array();
$discuz = C::app();

$discuz->cachelist = $cachelist;
$discuz->init_cron = false;
$discuz->init_setting = true;
$discuz->init_user = false;
$discuz->init_session = false;
$discuz->init_misc = false;

$discuz->init();

$_G['siteurl'] = preg_replace('/\/install\/$/i', '/', $_G['siteurl']);

$plugins = array('cloudstat', 'soso_smilies', 'security', 'pcmgr_url_safeguard', 'manyou', 'cloudcaptcha', 'cloudunion', 'qqgroup', 'xf_storage', 'cloudsearch');
foreach($plugins as $pluginid) {			
	$plugin = C::t('common_plugin')->fetch_by_identifier($pluginid);
	if($plugin) {
		$modules = unserialize($plugin['modules']);
		$modules['system'] = 0;
		$modules = serialize($modules);
		C::t('common_plugin')->update($plugin['pluginid'], array('modules' => $modules));
	}			
}

echo "云平台插件已降为非系统级插件，请删除本工具";

?>