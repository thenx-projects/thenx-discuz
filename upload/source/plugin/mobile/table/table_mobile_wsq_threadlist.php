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
 *      $Id: table_mobile_wsq_threadlist.php 34398 2014-04-14 07:11:22Z nemohou $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_mobile_wsq_threadlist extends discuz_table {

	public function __construct() {
		$this->_table = 'mobile_wsq_threadlist';
		$this->_pk = 'skey';
		$this->_pre_cache_key = 'wsq_threadlist_';
		$this->_cache_ttl = 0;

		parent::__construct();
	}

	public function insert($tid, $data, $return_insert_id = false, $replace = false, $silent = false) {
		if($this->_allowmem) {
			$this->store_cache($tid, $data);
		}
		return DB::insert($this->_table, $data, $return_insert_id, $replace, $silent);
	}
}