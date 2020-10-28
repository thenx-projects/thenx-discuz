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
 * DiscuzX Convert
 *
 * $Id: do_config.inc.php 10469 2010-05-11 09:12:14Z monkey $
 */

if(!defined('DISCUZ_ROOT')) {
	exit('Access error');
}

$configfile = DISCUZ_ROOT.'./data/config.inc.php';
$configfile_default = DISCUZ_ROOT.'./data/config.default.php';

@touch($configfile);
if(!is_writable($configfile)) {
	showmessage('config_write_error');
}

$config_default = loadconfig('config.default.php');
$error = array();
if(submitcheck()) {
	$newconfig = getgpc('newconfig');
	if(is_array($newconfig)) {
		$checkarray = $setting['config']['ucenter'] ? array('source', 'target', 'ucenter') : array('source', 'target');
		foreach ($checkarray as $key) {
			if(!empty($newconfig[$key]['dbhost'])) {
				$check = mysql_connect_test($newconfig[$key], $key);
				if($check < 0) {
					$error[$key] = lang('mysql_connect_error_'.abs($check));
				}
			} else {
				$error[$key] = lang('mysql_config_error');
			}
		}
		save_config_file($configfile, $newconfig, $config_default);
		if(empty($error)) {
			$db_target = new db_mysql($newconfig['target']);
			$db_target->connect();
			delete_process('all');
			showmessage('config_success', 'index.php?a=select&source='.$source);
		}
	}
}

showtips('如果无法显示设置项目，请删除文件 data/config.inc.php');
$config = loadconfig('config.inc.php');
if(empty($config)) {
	$config = $config_default;
}
show_form_header();
show_config_input('source', $config['source'], $error['source']);
show_config_input('target', $config['target'], $error['target']);
if($setting['config']['ucenter']) {
	show_config_input('ucenter', $config['ucenter'], $error['ucenter']);
}
show_form_footer('submit', 'config_save');

?>