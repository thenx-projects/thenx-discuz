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
 *      $Id: table_common_adminnote.php 31558 2012-09-10 03:22:31Z liulanbo $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_adminnote extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_adminnote';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function delete($id, $admin = '') {
		if(empty($id)) {
			return false;
		}
		return DB::query('DELETE FROM %t WHERE '.DB::field('id', $id).' %i', array($this->_table, ($admin ? ' AND '.DB::field('admin', $admin) : '')));
	}

	public function fetch_all_by_access($access) {
		if(!is_numeric($access) && !is_array($access)) {
			return array();
		}
		return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('access', $access).' ORDER BY dateline DESC', array($this->_table));
	}

	public function count_by_access($access) {
		if(!is_numeric($access) && !is_array($access)) {
			return 0;
		}
		return DB::result_first('SELECT COUNT(*) FROM %t WHERE '.DB::field('access', $access), array($this->_table));
	}

}

?>