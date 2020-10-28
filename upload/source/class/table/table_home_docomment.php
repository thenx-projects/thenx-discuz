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
 *      $Id: table_home_docomment.php 27819 2012-02-15 05:12:23Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_home_docomment extends discuz_table
{
	public function __construct() {

		$this->_table = 'home_docomment';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function delete_by_doid_uid($doids = null, $uids = null) {
		$sql = array();
		$doids && $sql[] = DB::field('doid', $doids);
		$uids && $sql[] = DB::field('uid', $uids);
		if($sql) {
			return DB::query('DELETE FROM %t WHERE %i', array($this->_table, implode(' OR ', $sql)));
		} else {
			return false;
		}
	}

	public function fetch_all_by_doid($doids) {
		if(empty($doids)) {
			return array();
		}
		return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('doid', $doids).' ORDER BY dateline', array($this->_table));
	}

}

?>