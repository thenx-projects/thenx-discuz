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
 *      $Id: task_profile.php 24704 2011-10-08 10:19:11Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class task_profile {

	var $version = '1.0';
	var $name = 'profile_name';
	var $description = 'profile_desc';
	var $copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';
	var $icon = '';
	var $period = '';
	var $periodtype = 0;
	var $conditions = array();

	function csc($task = array()) {
		global $_G;

		$data = $this->checkfield();
		if(!$data[0]) {
			return true;
		}
		return array('csc' => $data[1], 'remaintime' => 0);
	}

	function view() {
		$data = $this->checkfield();
		return lang('task/profile', 'profile_view', array('profiles' => implode(', ', $data[0])));
	}

	function checkfield() {
		global $_G;

		$fields = array('realname', 'gender', 'birthyear', 'birthmonth', 'birthday', 'bloodtype', 'affectivestatus',
				'birthprovince','birthcity', 'resideprovince', 'residecity');
		loadcache('profilesetting');
		$fieldsnew = array();
		foreach($fields as $v) {
			if(isset($_G['cache']['profilesetting'][$v])) {
				$fieldsnew[$v] = $_G['cache']['profilesetting'][$v]['title'];
			}
		}
		if($fieldsnew) {
			space_merge($_G['member'], 'profile');
			$none = array();
			foreach($_G['member'] as $k => $v) {
				if(in_array($k, $fields, true) && !trim($v)) {
					$none[] = $fieldsnew[$k];
				}
			}
			$all = count($fields);
			$csc = intval(($all - count($none)) / $all * 100);
			return array($none, $csc);
		} else {
			return true;
		}
	}

}

?>