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
 *      $Id: table_forum_typeoptionvar.php 27800 2012-02-15 02:13:57Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_typeoptionvar extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_typeoptionvar';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch_all_by_tid_optionid($tids, $optionids = null) {
		if(empty($tids)) {
			return array();
		}
		return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('tid', $tids).($optionids ? ' AND '.DB::field('optionid', $optionids) : ''), array($this->_table));
	}

	public function fetch_all_by_search($sortids = null, $fids = null, $tids = null, $optionids = null) {
		$sql = array();
		$sortids && $sql[] = DB::field('sortid', $sortids);
		$fids && $sql[] = DB::field('fid', $fids);
		$tids && $sql[] = DB::field('tid', $tids);
		$optionids && $sql[] = DB::field('optionid', $optionids);
		if($sql) {
			return DB::fetch_all('SELECT * FROM %t WHERE %i', array($this->_table, implode(' AND ', $sql)));
		} else {
			return array();
		}
	}

	public function update_by_tid($tid, $data, $unbuffered = false, $low_priority = false, $optionid = null, $sortid = null) {
		if(empty($data)) {
			return false;
		}
		$where = array();
		$where[] = DB::field('tid', $tid);
		if($optionid !== null) {
			$where[] = DB::field('optionid', $optionid);
		}
		if($sortid !== null) {
			$where[] = DB::field('sortid', $sortid);
		}
		return DB::update($this->_table, $data, implode(' AND ', $where), $unbuffered, $low_priority);
	}

	public function delete_by_sortid($sortids) {
		if(empty($sortids)) {
			return false;
		}
		return DB::query('DELETE FROM %t WHERE '.DB::field('sortid', $sortids), array($this->_table));
	}

	public function delete_by_tid($tids) {
		if(empty($tids)) {
			return false;
		}
		return DB::query('DELETE FROM %t WHERE '.DB::field('tid', $tids), array($this->_table), false, true);
	}

}

?>