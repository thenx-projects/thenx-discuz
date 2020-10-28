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
 *      $Id: table_forum_spacecache.php 27819 2012-02-15 05:12:23Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_spacecache extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_spacecache';
		$this->_pk    = '';

		parent::__construct();
	}

	public function fetch($uid, $variable) {
		return DB::fetch_first('SELECT * FROM %t WHERE uid=%d AND variable=%s', array($this->_table, $uid, $variable));
	}

	public function fetch_all($uids, $variables) {
		if(empty($uids) || empty($variables)) {
			return array();
		}
		return DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('uid', $uids).' AND '.DB::field('variable', $variables), array($this->_table));
	}

	public function delete($uid, $variable) {
		return DB::query('DELETE FROM %t WHERE uid=%d AND variable=%s', array($this->_table, $uid, $variable));
	}

}

?>