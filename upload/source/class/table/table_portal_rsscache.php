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
 *      $Id: table_portal_rsscache.php 27793 2012-02-14 10:02:48Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_portal_rsscache extends discuz_table
{
	public function __construct() {

		$this->_table = 'portal_rsscache';
		$this->_pk    = 'aid';

		parent::__construct();
	}

	public function fetch_all_by_catid($catid, $limit = 20) {
		return $catid ? DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' WHERE '.DB::field('catid', $catid).' ORDER BY dateline DESC LIMIT '.dintval($limit), null, 'aid') : array();
	}
}

?>