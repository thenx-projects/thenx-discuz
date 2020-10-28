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
 *      $Id: table_portal_article_count.php 29078 2012-03-26 06:55:04Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_portal_article_count extends discuz_table
{
	public function __construct() {

		$this->_table = 'portal_article_count';
		$this->_pk    = 'aid';

		parent::__construct();
	}

	public function increase($ids, $data) {
		$ids = array_map('intval', (array)$ids);
		$sql = array();
		$allowkey = array('commentnum', 'viewnum', 'favtimes', 'sharetimes');
		foreach($data as $key => $value) {
			if(($value = intval($value)) && in_array($key, $allowkey)) {
				$sql[] = "`$key`=`$key`+'$value'";
			}
		}
		if(!empty($sql)){
			DB::query("UPDATE ".DB::table($this->_table)." SET ".implode(',', $sql)." WHERE aid IN (".dimplode($ids).")", 'UNBUFFERED');
		}
	}

	public function fetch_all_hotarticle($wheresql, $dateline) {
		if(!empty($wheresql) && ($wheresql = (string)$wheresql) && $dateline = dintval($dateline)) {
			return DB::fetch_all("SELECT at.* FROM ".DB::table($this->_table)." ac, ".DB::table('portal_article_title')." at WHERE $wheresql AND at.dateline>'$dateline' AND ac.aid=at.aid ORDER BY ac.viewnum DESC LIMIT 10");
		} else {
			return array();
		}
	}
}

?>