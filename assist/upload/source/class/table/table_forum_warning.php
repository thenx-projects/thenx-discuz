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
 *      $Id: table_forum_warning.php 27800 2012-02-15 02:13:57Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_warning extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_warning';
		$this->_pk    = 'wid';

		parent::__construct();
	}

	public function count_by_author($authors = null) {
		return DB::result_first('SELECT COUNT(*) FROM %t '.($authors ? 'WHERE '.DB::field('author', $authors) : ''), array($this->_table));
	}

	public function count_by_authorid_dateline($authorid, $dateline = null) {
		return DB::result_first('SELECT COUNT(*) FROM %t WHERE authorid=%d '.($dateline ? ' AND '.DB::field('dateline', dintval($dateline), '>=') : ''), array($this->_table, $authorid));
	}

	public function fetch_all_by_author($authors, $start, $limit) {
		return DB::fetch_all('SELECT * FROM %t '.($authors ? 'WHERE '.DB::field('author', $authors) : '').' ORDER BY wid DESC '.DB::limit($start, $limit), array($this->_table));
	}

	public function fetch_all_by_authorid($authorid) {
		return DB::fetch_all('SELECT * FROM %t WHERE authorid=%d', array($this->_table, $authorid));
	}

	public function delete_by_pid($pids) {
		if(empty($pids)) {
			return false;
		}
		return DB::query('DELETE FROM %t WHERE '.DB::field('pid', $pids), array($this->_table), false, true);
	}

}

?>