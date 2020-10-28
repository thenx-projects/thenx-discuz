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
 *      $Id: table_common_block_pic.php 27802 2012-02-15 02:34:36Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_block_pic extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_block_pic';
		$this->_pk    = 'picid';

		parent::__construct();
	}

	public function fetch_all_by_bid_itemid($bid, $itemid = array()) {
		return $bid ? DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' WHERE '.DB::field('bid', $bid).($itemid ? ' AND '.DB::field('itemid', $itemid) : '')) : array();
	}

	public function insert_by_bid($bid, $data) {
		if($bid && $data && is_array($data)) {
			$data = daddslashes($data);
			$str = array();
			foreach($data as $value) {
				$str[] = "('$value[bid]', '$value[pic]', '$value[picflag]', '$value[type]')";
			}
			if($str) {
				DB::query('INSERT INTO '.DB::table($this->_table).' (bid, pic, picflag, `type`) VALUES '.implode(',', $str));
			}
		}
	}

	public function count_by_bid_pic($bid, $pic) {
		return DB::result_first('SELECT COUNT(*) FROM %t WHERE bid=%d AND pic=%s', array($this->_table, $bid, $pic));
	}
}

?>