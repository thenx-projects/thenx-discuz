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
 *      $Id: table_forum_faq.php 30560 2012-06-04 03:03:56Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_forum_faq extends discuz_table
{
	public function __construct() {

		$this->_table = 'forum_faq';
		$this->_pk    = 'id';

		parent::__construct();
	}

	public function fetch_all_by_fpid($fpid = '', $srchkw = '') {
		$sql = array();
		if($fpid !== '' && $fpid) {
			$sql[] = DB::field('fpid', $fpid);
		}
		if($srchkw) {
			$sql[] = DB::field('title', '%'.$srchkw.'%', 'like').' OR '.DB::field('message', '%'.$srchkw.'%', 'like');
		}
		$sql = implode(' AND ', $sql);
		if($sql) {
			$sql = 'WHERE '.$sql;
		}
		return DB::fetch_all("SELECT *  FROM %t  %i ORDER BY displayorder", array($this->_table, $sql));
	}

	public function check_identifier($identifier, $id) {
		return DB::result_first("SELECT COUNT(*) FROM %t WHERE identifier=%s AND id!=%s", array($this->_table, $identifier, $id));
	}

}

?>