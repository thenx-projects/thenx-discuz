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
 *      $Id: table_home_album_category.php 27449 2012-02-01 05:32:35Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_home_album_category extends discuz_table
{
	public function __construct() {

		$this->_table = 'home_album_category';
		$this->_pk    = 'catid';

		parent::__construct();
	}

	public function fetch_all_by_displayorder() {
		return DB::fetch_all('SELECT * FROM %t ORDER BY displayorder', array($this->_table), $this->_pk);
	}

	public function fetch_all_numkey($numkey) {
		$allow_numkey = array('portal', 'articles', 'num');
		if(!in_array($numkey, $allow_numkey)) {
			return null;
		}
		return DB::fetch_all("SELECT catid, $numkey FROM %t", array($this->_table), $this->_pk);
	}

	public function update_num_by_catid($num, $catid, $numlimit = false) {
		$args = array($this->_table, $num, $catid);
		if($numlimit !== false) {
			$sql = ' AND num>0';
			$args[] = $numlimit;
		}
		return DB::query("UPDATE %t SET num=num+'%d' WHERE catid=%d {$sql}", $args);
	}

	public function fetch_catname_by_catid($catid) {
		return DB::result_first('SELECT catname FROM %t WHERE catid=%d', array($this->_table, $catid));
	}

}

?>