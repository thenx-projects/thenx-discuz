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

	$Id: feed.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class feedmodel {

	var $db;
	var $base;
	var $apps;
	var $operations = array();

	function __construct(&$base) {
		$this->feedmodel($base);
	}

	function feedmodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
	}

	function get_total_num() {
		$data = $this->db->result_first("SELECT COUNT(*) FROM ".UC_DBTABLEPRE."feeds");
		return $data;
	}

	function get_list($page, $ppp, $totalnum) {
		$start = $this->base->page_get_start($page, $ppp, $totalnum);
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."feeds LIMIT $start, $ppp");

		foreach((array)$data as $k=> $v) {
			$searchs = $replaces = array();
			$title_data = $_ENV['misc']->string2array($v['title_data']);
			foreach(array_keys($title_data) as $key) {
				$searchs[] = '{'.$key.'}';
				$replaces[] = $title_data[$key];
			}
			$searchs[] = '{actor}';
			$replaces[] = $v['username'];
			$searchs[] = '{app}';
			$replaces[] = $this->base->apps[$v['appid']]['name'];
			$data[$k]['title_template'] = str_replace($searchs, $replaces, $data[$k]['title_template']);
			$data[$k]['dateline'] = $v['dateline'] ? $this->base->date($data[$k]['dateline']) : '';
		}
		return $data;
	}
}
?>