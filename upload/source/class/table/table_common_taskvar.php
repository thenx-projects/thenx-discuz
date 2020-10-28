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
 *      $Id: table_common_taskvar.php 27781 2012-02-14 07:38:55Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_taskvar extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_taskvar';
		$this->_pk    = 'taskvarid';

		parent::__construct();
	}

	public function fetch_all_by_taskid($taskid, $variable = '') {
		if(!$taskid) {
			return;
		}
		$variable = $variable ? ' AND '.($variable !== 'IS NOT NULL' ? DB::field('variable', $variable) : 'variable IS NOT NULL') : '';
		return DB::fetch_all("SELECT * FROM %t WHERE %i%i", array($this->_table, DB::field('taskid', $taskid), $variable));
	}

	public function get_value_by_taskid($taskid, $variable) {
		$result = $this->fetch_all_by_taskid($taskid, $variable);
		return $result[0]['value'];
	}

	public function update_by_taskid($taskid, $variable, $val) {
		if(!$val || !is_array($val)) {
			return;
		}
		return DB::update($this->_table, $val, array('taskid' => $taskid, 'variable' => $variable), 'UNBUFFERED');
	}

	public function delete_by_taskid($taskid) {
		if(!$taskid) {
			return;
		}
		return DB::delete($this->_table, DB::field('taskid', $taskid));
	}

}

?>