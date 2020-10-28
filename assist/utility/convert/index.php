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
 * $Id: index.php 10469 2010-05-11 09:12:14Z monkey $
 */

require './include/common.inc.php';

$action = getgpc('a');
$action = empty($action) ? getgpc('action') : $action;
$source = getgpc('source') ? getgpc('source') : getgpc('s');
$step = getgpc('step');
$start = getgpc('start');

$setting = array();
if($source) {
	if(!$setting = loadsetting($source)) {
		showmessage('load_setting_error');
	}
}

$action = empty($action) || empty($source) ? 'source' : $action;
showheader($action, $setting);

if($action == 'source') {
	require DISCUZ_ROOT.'./include/do_source.inc.php';
} elseif($action == 'config' || CONFIG_EMPTY) {
	require DISCUZ_ROOT.'./include/do_config.inc.php';
} elseif($action == 'setting') {
	require DISCUZ_ROOT.'./include/do_setting.inc.php';
} elseif($action == 'select') {
	require DISCUZ_ROOT.'./include/do_select.inc.php';
} elseif($action == 'convert') {
	require DISCUZ_ROOT.'./include/do_convert.inc.php';
} elseif($action == 'finish') {
	require DISCUZ_ROOT.'./include/do_finish.inc.php';
} else {
	showmessage('非法请求');
}

showfooter();
?>