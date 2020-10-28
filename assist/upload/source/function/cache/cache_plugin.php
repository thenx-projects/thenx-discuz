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
 *      $Id: cache_plugin.php 33987 2013-09-13 06:48:25Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_plugin() {
	global $importtxt;
	$data = $pluginsetting = array();
	foreach(C::t('common_plugin')->fetch_all_data(1) as $plugin) {
		$dir = substr($plugin['directory'], 0, -1);
		$plugin['modules'] = unserialize($plugin['modules']);
		if($plugin['modules']['extra']['langexists']) {
			$file = DISCUZ_ROOT.'./source/plugin/'.$dir.'/discuz_plugin_'.$dir.($plugin['modules']['extra']['installtype'] ? '_'.$plugin['modules']['extra']['installtype'] : '').'.xml';
			if(file_exists($file)) {
				require_once libfile('function/plugin');
				require_once libfile('function/admincp');
				$importtxt = @implode('', file($file));
				$pluginarray = getimportdata('Discuz! Plugin', 0, 1);
				if($pluginarray) {
					updatepluginlanguage($pluginarray);
				}
			}
		}

		foreach(C::t('common_pluginvar')->fetch_all_by_pluginid($plugin['pluginid']) as $var) {
			$data[$plugin['identifier']][$var['variable']] = $var['value'];
			if(in_array(substr($var['type'], 0, 6), array('group_', 'forum_'))) {
				$stype = substr($var['type'], 0, 5).'s';
				$type = substr($var['type'], 6);
				if($type == 'select') {
					foreach(explode("\n", $var['extra']) as $key => $option) {
						$option = trim($option);
						if(strpos($option, '=') === FALSE) {
							$key = $option;
						} else {
							$item = explode('=', $option);
							$key = trim($item[0]);
							$option = trim($item[1]);
						}
						$var['select'][] = array($key, $option);
					}
				}
				$pluginsetting[$stype][$plugin['identifier']]['name'] = $plugin['name'];
				$pluginsetting[$stype][$plugin['identifier']]['setting'][$var['pluginvarid']] = array('title' => $var['title'], 'description' => $var['description'], 'type' => $type, 'select' => $var['select']);
			}
		}
	}


	writetocache('pluginsetting', getcachevars(array('pluginsetting' => $pluginsetting)));

	savecache('plugin', $data);
}

?>