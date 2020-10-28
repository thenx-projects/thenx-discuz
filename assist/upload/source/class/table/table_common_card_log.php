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
 *      $Id: table_common_card_log.php 31076 2012-07-13 03:30:58Z zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_card_log extends discuz_table_archive
{
	public function __construct() {

		$this->_table = 'common_card_log';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function fetch_by_operation($operation) {
		return DB::fetch_first('SELECT * FROM %t WHERE operation=%d ORDER BY dateline DESC LIMIT 1', array($this->_table, $operation));
	}

	public function fetch_all_by_operation($operation, $start = 0, $limit = 0) {
		return DB::fetch_all('SELECT * FROM %t WHERE operation=%d ORDER BY dateline DESC '.DB::limit($start, $limit), array($this->_table, $operation));
	}

	public function count_by_operation($operation) {
		return DB::result_first('SELECT COUNT(*) FROM %t WHERE operation=%d', array($this->_table, $operation));
	}
}

?>