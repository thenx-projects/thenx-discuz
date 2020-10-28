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

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: setting.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class settingmodel {

	var $db;
	var $base;

	function __construct(&$base) {
		$this->settingmodel($base);
	}

	function settingmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function get_settings($keys = '') {
		if($keys) {
			$keys = $this->base->implode($keys);
			$sqladd = "k IN ($keys)";
		} else {
			$sqladd = '1';
		}
		$arr = array();
		$arr = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."settings WHERE $sqladd");
		if($arr) {
			foreach($arr as $k => $v) {
				$arr[$v['k']] = $v['v'];
				unset($arr[$k]);
			}
		}
		return $arr;
	}

}

?>