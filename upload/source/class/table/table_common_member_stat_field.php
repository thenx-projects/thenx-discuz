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
 *      $Id: table_common_member_stat_field.php 27774 2012-02-14 06:55:13Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_member_stat_field extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_member_stat_field';
		$this->_pk    = 'optionid';

		parent::__construct();
	}

	public function count_by_fieldid($fieldid) {
		return $fieldid ? DB::result_first('SELECT COUNT(*) FROM %t WHERE fieldid=%s', array($this->_table, $fieldid)) : 0;
	}

	public function fetch_all_by_fieldid($fieldid, $start = 0, $limit = 0) {
		return DB::fetch_all('SELECT * FROM %t WHERE fieldid=%s'.DB::limit($start, $limit), array($this->_table, $fieldid));
	}

	public function insert_batch($inserts) {
		$sql = array();
		foreach($inserts as $value) {
			if($value['fieldid']) {
				$sql[] = "('$value[fieldid]', '".addslashes($value['fieldvalue'])."')";
			}
		}
		if($sql) {
			DB::query('INSERT INTO '.DB::table($this->_table)."(fieldid, fieldvalue) VALUES ".implode(', ', $sql));
		}
	}
}

?>