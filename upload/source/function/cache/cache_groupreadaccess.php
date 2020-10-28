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
 *      $Id: cache_groupreadaccess.php 27076 2012-01-04 08:01:37Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_groupreadaccess() {
	$data = array();
	$gf_data = C::t('common_usergroup_field')->fetch_readaccess_by_readaccess(0);
	$ug_data = C::t('common_usergroup')->fetch_all(array_keys($gf_data));

	foreach($gf_data as $key => $datarow) {
		if(!$ug_data[$key]['groupid']) {
			continue;
		}
		$datarow['grouptitle'] = $ug_data[$key]['grouptitle'];
		$data[] = $datarow;
	}

	savecache('groupreadaccess', $data);
}

?>