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
 *      $Id: table_home_blogfield.php 27740 2012-02-13 10:05:22Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_home_blogfield extends discuz_table
{
	public function __construct() {

		$this->_table = 'home_blogfield';
		$this->_pk    = 'blogid';

		parent::__construct();
	}

	public function delete_by_uid($uids) {
		if(!$uids) {
			return null;
		}
		return DB::delete($this->_table, DB::field('uid', $uids));
	}

	public function fetch_targetids_by_blogid($blogid) {
		return DB::fetch_first('SELECT target_ids, hotuser FROM %t WHERE blogid = %d', array($this->_table, $blogid));
	}

	public function fetch_tag_by_blogid($blogid) {
		return DB::result_first('SELECT tag FROM %t WHERE blogid = %d', array($this->_table, $blogid));
	}

}

?>