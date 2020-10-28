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
 *      $Id: table_common_style.php 29200 2012-03-28 09:11:54Z monkey $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_style extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_style';
		$this->_pk    = 'styleid';

		parent::__construct();
	}

	public function fetch_all_data($withtemplate = false, $available = false) {
		if($withtemplate) {
			$available = $available !== false ? 'WHERE s.available='.intval($available) : '';
			return DB::fetch_all('SELECT s.*, t.name AS tplname, t.directory, t.copyright FROM %t s LEFT JOIN %t t ON t.templateid=s.templateid %i ORDER BY s.styleid ASC', array($this->_table, 'common_template', $available));
		} else {
			$available = $available !== false ? 'WHERE available='.intval($available) : '';
			return DB::fetch_all('SELECT * FROM %t %i', array($this->_table, $available));
		}
	}

	public function fetch_by_styleid($styleid) {
		return DB::fetch_first("SELECT s.*, t.name AS tplname, t.directory, t.copyright FROM %t s LEFT JOIN %t t ON s.templateid=t.templateid WHERE s.styleid=%d", array($this->_table, 'common_template', $styleid));
	}

	public function check_stylename($stylename) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE name=%s", array($this->_table, $stylename));
	}

}

?>