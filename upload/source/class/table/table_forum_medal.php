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
 *      $Id: table_forum_medal.php 27745 2012-02-14 01:43:38Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_medal extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_medal';
		$this->_pk    = 'medalid';

		parent::__construct();
	}

	public function fetch_all_data($available = false) {
		$available = $available !== false ? ' WHERE available='.intval($available) : '';
		return DB::fetch_all('SELECT * FROM %t %i ORDER BY displayorder', array($this->_table, $available));
	}
	public function fetch_all_name_by_available($available = 1) {
		$data = array();
		foreach($this->fetch_all_data($available) as $value) {
			$data[$value['medalid']] = array('medalid' => $value['medalid'], 'name' => $value['name']);
		}
		return $data;
	}

	public function count_by_available() {
		return DB::result_first('SELECT COUNT(*) FROM %t WHERE available=1', array($this->_table));
	}


	public function fetch_all_by_id($id) {
		if(!$id) {
			return;
		}
		return DB::fetch_all("SELECT * FROM %t WHERE %i ORDER BY displayorder", array($this->_table, DB::field('medalid', $id)));
	}



}

?>