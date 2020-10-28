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
 *      $Id: cache_fields_connect_register.php 24935 2011-10-17 07:41:48Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_fields_connect_register() {
	global $_G;
	$data = array();
	$fields = array();
	if($_G['setting']['connect']['register_gender']) {
		$fields[] = 'gender';
	}
	if($_G['setting']['connect']['register_birthday']) {
		$fields[] = 'birthyear';
		$fields[] = 'birthmonth';
		$fields[] = 'birthday';
	}
	if($fields) {

		foreach(C::t('common_member_profile_setting')->fetch_all($fields) as $field) {
			$choices = array();
			if($field['selective']) {
				foreach(explode("\n", $field['choices']) as $item) {
					list($index, $choice) = explode('=', $item);
					$choices[trim($index)] = trim($choice);
				}
				$field['choices'] = $choices;
			} else {
				unset($field['choices']);
			}
			$field['showinregister'] = 1;
			$field['available'] = 1;
			$data['field_'.$field['fieldid']] = $field;
		}
	}

	savecache('fields_connect_register', $data);
}

?>