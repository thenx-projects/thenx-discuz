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
 *      $Id: cache_mobile.php 34314 2014-02-20 01:04:24Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_plugin_mobile() {
	if(!defined('DISCUZ_VERSION')) {
	    require './source/discuz_version.php';
	}

	global $_G;

	$setting = array();
	$settings = array('closeforumorderby');
	foreach($settings as $v) {
		$setting[$v] = $_G['setting'][$v];
	}

	if(in_array('mobile', $_G['setting']['plugins']['available'])) {
		$extendsetting = C::t('#mobile#mobile_setting')->fetch_all(array(
			'extend_used',
			'extend_lastupdate'
		));
		$array = array(
			'discuzversion' => DISCUZ_VERSION,
			'charset' => CHARSET,
			'version' => MOBILE_PLUGIN_VERSION,
			'pluginversion' => $_G['setting']['plugins']['version']['mobile'],
			'oemversion' => in_array('mobileoem', $_G['setting']['plugins']['available']) ? $_G['setting']['plugins']['version']['mobileoem'] : '0',
			'regname' => $_G['setting']['regname'],
			'qqconnect' => in_array('qqconnect', $_G['setting']['plugins']['available']) ? '1' : '0',
			'sitename' => $_G['setting']['bbname'],
			'mysiteid' => $_G['setting']['my_siteid'],
			'ucenterurl' => $_G['setting']['ucenterurl'],
			'setting' => $setting,
			'extends' => array('used' => $extendsetting['extend_used'], 'lastupdate' => $extendsetting['extend_lastupdate']),
		);
	} else {
		$array = array();
	}

	require_once './source/plugin/mobile/mobile.class.php';

	define('IN_MOBILE_API', 1);

	$data = array('mobilecheck' => mobile_core::json($array));
	writetocache('mobile', getcachevars($data));
}