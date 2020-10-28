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
 *      $Id: table_portal_attachment.php 27817 2012-02-15 04:45:17Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_portal_attachment extends discuz_table
{
	public function __construct() {

		$this->_table = 'portal_attachment';
		$this->_pk    = 'attachid';

		parent::__construct();
	}

	public function fetch_all_by_aid($aid) {
		return ($aid = dintval($aid, true)) ? DB::fetch_all('SELECT * FROM %t WHERE '.DB::field('aid', $aid).' ORDER BY attachid DESC', array($this->_table), $this->_pk) : array();
	}

	public function fetch_by_aid_image($aid) {
		return $aid ? DB::fetch_first('SELECT * FROM %t WHERE aid=%d AND isimage=1', array($this->_table, $aid)) : array();
	}

	public function update_to_used($newaids, $aid) {
		$aid = dintval($aid);
		return ($newaids = dintval($newaids, true)) ? DB::update($this->_table, array('aid'=>$aid), DB::field('attachid', $newaids).' AND aid=0') : false;
	}

}

?>