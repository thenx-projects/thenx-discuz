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
 *      $Id: table_forum_threadtype.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_threadtype extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_threadtype';
		$this->_pk    = 'typeid';

		parent::__construct();
	}

	public function fetch_all_for_cache() {
		return DB::fetch_all("SELECT t.typeid AS sortid, tt.optionid, tt.title, tt.type, tt.unit, tt.rules, tt.identifier, tt.description, tt.permprompt, tv.required, tv.unchangeable, tv.search, tv.subjectshow, tt.expiration, tt.protect
			FROM ".DB::table('forum_threadtype')." t
			LEFT JOIN ".DB::table('forum_typevar')." tv ON t.typeid=tv.sortid
			LEFT JOIN ".DB::table('forum_typeoption')." tt ON tv.optionid=tt.optionid
			WHERE t.special='1' AND tv.available='1'
			ORDER BY tv.displayorder");
	}
	public function fetch_all_for_order($typeid = array()) {
		if(!empty($typeid)) {
			$where = ' WHERE '.DB::field('typeid', $typeid);
		}
		return DB::fetch_all("SELECT * FROM ".DB::table('forum_threadtype')." $where ORDER BY displayorder");
	}
	public function checkname($name) {
		return DB::result_first("SELECT typeid FROM %t WHERE name=%s", array($this->_table, $name));
	}
}

?>