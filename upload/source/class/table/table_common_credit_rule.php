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
 *      $Id: table_common_credit_rule.php 27900 2012-02-16 07:50:00Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_credit_rule extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_credit_rule';
		$this->_pk    = 'rid';

		parent::__construct();
	}

	public function fetch_all_by_rid($rid = 0) {
		$parameter = array($this->_table);
		$wherearr = array();
		if($rid) {
			$rid = dintval($rid, true);
			$parameter[] = $rid;
			$wherearr[] = is_array($rid) ? 'rid IN(%n)' : 'rid=%d';
		}
		$wheresql = !empty($wherearr) && is_array($wherearr) ? ' WHERE '.implode(' AND ', $wherearr) : '';
		return DB::fetch_all("SELECT * FROM %t $wheresql ORDER BY rid DESC", $parameter, $this->_pk);
	}

	public function fetch_all_rule() {
		return DB::fetch_all('SELECT * FROM %t ORDER BY rid DESC', array($this->_table));
	}

	public function fetch_all_by_action($action) {
		if(!empty($action)) {
			return DB::fetch_all('SELECT * FROM %t WHERE action IN(%n)', array($this->_table, $action), $this->_pk);
		}
		return array();
	}

}

?>