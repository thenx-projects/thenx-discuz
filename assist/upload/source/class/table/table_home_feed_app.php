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
 *      $Id: table_home_feed_app.php 27903 2012-02-16 08:06:10Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_home_feed_app extends discuz_table
{
	public function __construct() {

		$this->_table = 'home_feed_app';
		$this->_pk    = 'feedid';

		parent::__construct();
	}

	public function fetch_all_by_uid_icon($uids = null, $icon = '', $start = 0, $limit = 0) {
		$parameter = array($this->_table);
		$wherearr = array();
		if($uids !== null) {
			$uids = dintval($uids, true);
			$wherearr[] = is_array($uids) ? 'uid IN(%n)' : 'uid=%d';
			$parameter[] = $uids;
		}
		if(!empty($icon)) {
			$wherearr[] = 'icon=%s';
			$parameter[] = $icon;
		}
		$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
		return DB::fetch_all("SELECT * FROM %t $wheresql ORDER BY dateline DESC ".DB::limit($start, $limit), $parameter, $this->_pk);
	}

	public function optimize_table() {
		return DB::query("OPTIMIZE TABLE %t", array($this->_table), true);
	}

	public function delete_by_dateline($dateline) {
		$dateline = dintval($dateline);
		if($dateline) {
			return DB::delete($this->_table, DB::field('dateline', $dateline, '<'));
		}
		return 0;
	}

}

?>