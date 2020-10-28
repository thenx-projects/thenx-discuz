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
 *      $Id: table_home_click.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_home_click extends discuz_table
{
	public function __construct() {

		$this->_table = 'home_click';
		$this->_pk    = 'clickid';

		parent::__construct();
	}

	public function fetch_all_by_idtype($idtype) {
		return DB::fetch_all('SELECT * FROM %t WHERE idtype=%s ORDER BY displayorder DESC', array($this->_table, $idtype), $this->_pk);
	}

	public function fetch_all_by_available($available = 1) {
		return DB::fetch_all('SELECT * FROM %t WHERE available=%d ORDER BY displayorder DESC', array($this->_table, $available), $this->_pk);
	}

}

?>