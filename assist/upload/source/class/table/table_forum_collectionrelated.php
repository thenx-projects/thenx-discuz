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
 *      $Id: table_forum_collectionrelated.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_collectionrelated extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_collectionrelated';
		$this->_pk    = 'tid';
		$this->_pre_cache_key = 'forum_collectionrelated_';

		parent::__construct();
	}

	public function update_collection_by_ctid_tid($ctid, $tid, $replace = false) {
		if($replace === false) {
			$ctid .= "\t";
			$collection = 'CONCAT(collection, %s)';
		} else {
			$collection = '%s';
		}

		$result = DB::query('UPDATE %t SET collection='.$collection.' WHERE tid=%d', array($this->_table, $ctid, $tid));
		if($this->_allowmem) {
			$this->clear_cache($tid);
			$this->clear_cache($tid, 'forum_collection_tid_');
		}
		return $result;
	}
}

?>