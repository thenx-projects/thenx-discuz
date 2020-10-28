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
 *      $Id: table_common_setting.php 30476 2012-05-30 07:05:06Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class table_common_setting extends discuz_table
{
	public function __construct() {

		$this->_table = 'common_setting';
		$this->_pk    = 'skey';

		parent::__construct();
	}

	public function fetch($skey, $auto_unserialize = false) {
		$data = DB::result_first('SELECT svalue FROM '.DB::table($this->_table).' WHERE '.DB::field($this->_pk, $skey));
		return $auto_unserialize ? (array)unserialize($data) : $data;
	}

	public function fetch_all($skeys = array(), $auto_unserialize = false){
		$data = array();
		$where = !empty($skeys) ? ' WHERE '.DB::field($this->_pk, $skeys) : '';
		$query = DB::query('SELECT * FROM '.DB::table($this->_table).$where);
		while($value = DB::fetch($query)) {
			$data[$value['skey']] = $auto_unserialize ? (array)unserialize($value['svalue']) : $value['svalue'];
		}
		return $data;
	}

	public function update($skey, $svalue){
		return DB::insert($this->_table, array($this->_pk => $skey, 'svalue' => is_array($svalue) ? serialize($svalue) : $svalue), false, true);
	}

	public function update_batch($array) {
		$settings = array();
		foreach($array as $key => $value) {
			$key = addslashes($key);
			$value = addslashes(is_array($value) ? serialize($value) : $value);
			$settings[] = "('$key', '$value')";
		}
		if($settings) {
			return DB::query("REPLACE INTO ".DB::table('common_setting')." (`skey`, `svalue`) VALUES ".implode(',', $settings));
		}
		return false;
	}

	public function skey_exists($skey) {
		return DB::result_first('SELECT skey FROM %t WHERE skey=%s LIMIT 1', array($this->_table, $skey)) ? true : false;
	}

	public function fetch_all_not_key($skey) {
		return DB::fetch_all('SELECT * FROM '.DB::table($this->_table).' WHERE skey NOT IN('.dimplode($skey).')');
	}

	public function fetch_all_table_status() {
		return DB::fetch_all('SHOW TABLE STATUS');
	}

	public function get_tablepre() {
		return DB::object()->tablepre;
	}

	public function update_count($skey, $num) {
		return DB::query("UPDATE %t SET svalue = svalue + %d WHERE skey = %s", array($this->_table, $num, $skey), false, true);
	}

}

?>