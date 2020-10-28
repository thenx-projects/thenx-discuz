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
 *      $Id: table_common_plugin.php 32122 2012-11-14 01:55:46Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_plugin extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_plugin';
		$this->_pk    = 'pluginid';

		parent::__construct();
	}

	public function fetch_by_identifier($identifier) {
		return DB::fetch_first('SELECT * FROM %t WHERE identifier=%s', array($this->_table, $identifier));
	}

	public function fetch_all_identifier($identifier) {
		return DB::fetch_all('SELECT * FROM %t WHERE identifier IN (%n)', array($this->_table, $identifier), 'identifier');
	}

	public function fetch_all_data($available = false) {
		$available = $available !== false ? 'WHERE available='.intval($available) : '';
		return DB::fetch_all('SELECT * FROM %t %i ORDER BY available DESC, pluginid DESC', array($this->_table, $available));
	}

	public function fetch_all_by_identifier($identifier) {
		if(!$identifier) {
			return;
		}
		return DB::fetch_all('SELECT * FROM %t WHERE %i', array($this->_table, DB::field('identifier', $identifier)));
	}

	public function fetch_by_pluginvarid($pluginid, $pluginvarid) {
		return DB::fetch_first("SELECT * FROM %t p, %t pv WHERE p.pluginid=%d AND pv.pluginid=p.pluginid AND pv.pluginvarid=%d",
			array($this->_table, 'common_pluginvar', $pluginid, $pluginvarid));
	}

	public function delete_by_identifier($identifier) {
		if(!$identifier) {
			return;
		}
		DB::delete('common_plugin', DB::field('identifier', $identifier));
	}

}

?>