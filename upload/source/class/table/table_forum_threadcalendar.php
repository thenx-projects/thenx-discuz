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
 *      $Id: table_forum_threadcalendar.php 31913 2012-10-24 06:52:26Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class table_forum_threadcalendar extends discuz_table {

	public function __construct() {

		$this->_table = 'forum_threadcalendar';
		$this->_pk    = 'cid';

		parent::__construct();
	}

	public function fetch_by_fid_dateline($fid, $dateline = 0, $order = 'dateline', $sort = 'DESC') {
		$parameter = array($this->_table);
		$wherearr = array();
		$wheresql = '';
		if($fid) {
			$wherearr[] = 'fid=%d';
			$parameter[] = $fid;
		}
		if($dateline) {
			$wherearr[] = 'dateline=%d';
			$parameter[] = $dateline;
		}
		if($wherearr) {
			$wheresql = ' WHERE '.implode(' AND ', $wherearr);
		}
		return DB::fetch_first('SELECT * FROM %t '.$wheresql.' ORDER BY '.DB::order($order, $sort), $parameter, $this->_pk);
	}

	public function fetch_all_by_dateline($dateline) {
		$dateline = dintval($dateline);
		if($dateline) {
			return DB::fetch_all('SELECT * FROM %t WHERE dateline=%d', array($this->_table, $dateline), 'fid');
		} else {
			return array();
		}
	}

	public function fetch_all_by_fid_dateline($fids, $dateline = 0) {
		$parameter = array($this->_table);
		$wherearr = array();
		$wheresql = '';
		$fids = dintval($fids, true);
		if($fids) {
			$wherearr[] = is_array($fids) ? 'fid IN(%n)' : 'fid=%d';
			$parameter[] = $fids;
		}
		$dateline = dintval($dateline);
		if($dateline) {
			$wherearr[] = 'dateline=%d';
			$parameter[] = $dateline;
		}
		if($wherearr) {
			$wheresql = ' WHERE '.implode(' AND ', $wherearr);
		}
		return DB::fetch_all('SELECT * FROM %t '.$wheresql, $parameter, 'fid');
	}

	public function insert_multiterm($dataarr) {
		$allkey = array('fid', 'dateline', 'hotnum');
		$sql = array();
		foreach($dataarr as $key => $value) {
			if(is_array($value)) {
				$fid = dintval($value['fid']);
				$dateline = dintval($value['dateline']);
				$hotnum = dintval($value['hotnum']);
				$sql[] = "($fid, $dateline, $hotnum)";
			}
		}
		if($sql) {
			return DB::query('INSERT INTO '.DB::table($this->_table)." (`fid`, `dateline`, `hotnum`) VALUES ".implode(',', $sql), true);
		}
		return false;
	}
}

?>