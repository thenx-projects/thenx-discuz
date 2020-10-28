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
 *      $Id: table_common_failedip.php 33692 2013-08-02 10:26:20Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_failedip extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_failedip';
		$this->_pk    = '';

		parent::__construct();
	}

	public function get_ip_count($ip, $time) {
		return DB::result_first("SELECT SUM(`count`) FROM %t WHERE ip=%s AND lastupdate>%d", array($this->_table, $ip, $time));
	}

	public function insert_ip($ip) {
		if(DB::result_first("SELECT COUNT(*) FROM %t WHERE ip=%s AND lastupdate=%d", array($this->_table, $ip, TIMESTAMP))) {
			DB::query("UPDATE %t SET `count`=`count`+1 WHERE ip=%s AND lastupdate=%d", array($this->_table, $ip, TIMESTAMP));
		} else {
			DB::query("INSERT INTO %t VALUES (%s, %d, 1)", array($this->_table, $ip, TIMESTAMP));
		}
		DB::query("DELETE FROM %t WHERE lastupdate<%d", array($this->_table, TIMESTAMP - 3600));
	}

}

?>