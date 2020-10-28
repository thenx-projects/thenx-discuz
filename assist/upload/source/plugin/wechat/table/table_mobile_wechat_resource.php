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
 *      $Id: table_mobile_wechat_resource.php 34748 2014-07-28 08:09:07Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_mobile_wechat_resource extends discuz_table {

	public function __construct() {
		$this->_table = 'mobile_wechat_resource';
		$this->_pk = 'id';

		parent::__construct();
	}

	public function insert($data, $return_insert_id = false, $replace = false, $silent = false) {
		if(!is_array($data['data'])) {
			return;
		}
		if(!$data['dateline']) {
			$data['dateline'] = TIMESTAMP;
		}
		$data['data'] = serialize($data['data']);
		return parent::insert($data, $return_insert_id, $replace, $silent);
	}

	public function update($val, $data, $unbuffered = false, $low_priority = false) {
		if(isset($data['data']) && is_array($data['data'])) {
			$data['data'] = serialize($data['data']);
		}
		return parent::update($val, $data, $unbuffered , $low_priority);
	}

	public function fetch($id, $force_from_db = false){
		$data = parent::fetch($id, $force_from_db);
		if($data) {
			$data['data'] = unserialize($data['data']);
			return $data;
		} else {
			return array();
		}
	}

	public function count_by_type($type = null) {
		$typesql = $type !== null ? "`type`=".intval($type) : 'TRUE';
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE %i", array($this->_table, $typesql));
	}

	public function fetch_by_type($type = null, $start = 0, $limit = 20) {
		$typesql = $type !== null ? "`type`=".intval($type) : 'TRUE';
		$datas = DB::fetch_all("SELECT * FROM %t WHERE %i ORDER BY id DESC LIMIT %d,%d", array($this->_table, $typesql, $start, $limit));
		if($datas) {
			foreach($datas as &$data) {
				$data['data'] = unserialize($data['data']);
			}
			return $datas;
		} else {
			return array();
		}
	}

	public function fetch_all($ids, $force_from_db = false) {
		$datas = parent::fetch_all($ids, $force_from_db);
		if($datas) {
			foreach($datas as &$data) {
				$data['data'] = unserialize($data['data']);
			}
			return $datas;
		} else {
			return array();
		}
	}

}