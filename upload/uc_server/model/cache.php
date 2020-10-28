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

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: cache.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

if(!function_exists('file_put_contents')) {
	function file_put_contents($filename, $s) {
		$fp = @fopen($filename, 'w');
		@fwrite($fp, $s);
		@fclose($fp);
	}
}

class cachemodel {

	var $db;
	var $base;
	var $map;

	function __construct(&$base) {
		$this->cachemodel($base);
	}

	function cachemodel(&$base) {
		$this->base = $base;
		$this->db = $base->db;
		$this->map = array(
			'settings' => array('settings'),
			'badwords' => array('badwords'),
			'plugins' => array('plugins'),
			'apps' => array('apps'),
		);
	}

	function updatedata($cachefile = '') {
		if($cachefile) {
			foreach((array)$this->map[$cachefile] as $modules) {
				$s = "<?php\r\n";
				foreach((array)$modules as $m) {
					$method = "_get_$m";
					$s .= '$_CACHE[\''.$m.'\'] = '.var_export($this->$method(), TRUE).";\r\n";
				}
				$s .= "\r\n?>";
				@file_put_contents(UC_DATADIR."./cache/$cachefile.php", $s);
			}
		} else {
			foreach((array)$this->map as $file => $modules) {
				$s = "<?php\r\n";
				foreach($modules as $m) {
					$method = "_get_$m";
					$s .= '$_CACHE[\''.$m.'\'] = '.var_export($this->$method(), TRUE).";\r\n";
				}
				$s .= "\r\n?>";
				@file_put_contents(UC_DATADIR."./cache/$file.php", $s);
			}
		}
	}

	function updatetpl() {
		$tpl = dir(UC_DATADIR.'view');
		while($entry = $tpl->read()) {
			if(preg_match("/\.php$/", $entry)) {
				@unlink(UC_DATADIR.'view/'.$entry);
			}
		}
		$tpl->close();
	}

	function _get_badwords() {
		$data = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."badwords");
		$return = array();
		if(is_array($data)) {
			foreach($data as $k => $v) {
				$return['findpattern'][$k] = $v['findpattern'];
				$return['replace'][$k] = $v['replacement'];
			}
		}
		return $return;
	}

	function _get_apps() {
		$this->base->load('app');
		$apps = $_ENV['app']->get_apps();
		$apps2 = array();
		if(is_array($apps)) {
			foreach($apps as $v) {
				$apps2[$v['appid']] = $v;
			}
		}
		return $apps2;
	}

	function _get_settings() {
		return $this->base->get_setting();
	}

	function _get_plugins() {
		$this->base->load('plugin');
		return $_ENV['plugin']->get_plugins();
	}
}

?>