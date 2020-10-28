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
 *      $Id: table_portal_article_trash.php 27836 2012-02-15 08:14:02Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_portal_article_trash extends discuz_table
{
	public function __construct() {

		$this->_table = 'portal_article_trash';
		$this->_pk    = 'aid';

		parent::__construct();
	}

	public function insert_batch($inserts) {
		$sql = array();
		foreach($inserts as $value) {
			if(($value['aid'] = dintval($value['aid']))) {
				$sql[] = "('$value[aid]', '".addslashes($value['content'])."')";
			}
		}
		if($sql) {
			DB::query('INSERT INTO '.DB::table($this->_table)."(`aid`, `content`) VALUES ".implode(', ', $sql));
		}
	}
}

?>