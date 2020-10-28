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
 *      $Id: index.php 23508 2011-07-21 06:34:40Z cnteacher $
 */

define('IN_API', true);
define('CURSCRIPT', 'api_mserver');
define('APPTYPEID', 200);

$_ENV['remote'] = new discuz_remote();
$_ENV['remote']->init();
$_ENV['remote']->loadservice();

class discuz_remote {

	var $mod;
	var $modobj;
	var $core;

	function init() {

		require_once('../../source/class/class_core.php');

		$cachelist = array();
		$this->core = C::app();

		$this->core->cachelist = $cachelist;


		$this->core->init_setting = true;

		$this->core->init_cron = false;
		$this->core->init_user = false;
		$this->core->init_session = false;
		$this->core->init_misc = false;
		$this->core->init_mobile = false;

		$this->core->init();

		define('SERVICE_DIR', getglobal('config/remote/dir') ? getglobal('config/remote/dir') : 'remote');
		$this->core->reject_robot();

		if (empty($_GET['mod']) || preg_match('/[^0-9a-z]/i', $_GET['mod'])) {
			$this->mod = 'index';
		} else {
			$this->mod = $_GET['mod'];
		}
	}

	function loadservice() {

		if(!$this->core->config['remote']['on']) {
			remote_service::error(1, 'remote service is down');
		}

		if(!$this->core->config['remote']['appkey']) {
			remote_service::error(1, 'remote service need a appkey, please edit you config.global.php');
		}

		if ($this->mod != 'index') {

			$sign = $_GET['sign'];
			unset($_GET['sign']);

			if (empty($sign) || $sign != $this->sign($_GET)) {
			}
		}

		if(!$this->check_timestamp()) {
			remote_service::error(5, 'your request is time out');
		}

		$modfile = DISCUZ_ROOT . './api/' . SERVICE_DIR . '/mod/mod_' . $this->mod . '.php';
		if (!is_file($modfile)) {
			remote_service::error(3, 'mod file is missing');
		}

		require $modfile;
		$classname = 'mod_'.$this->mod;
		if(class_exists($classname)) {
			$service = new $classname;
			$service->run();
		}
	}

	function check_timestamp()
	{
		if(empty($_GET['timestamp'])) {
			return 1;
		}

		$ttl = abs(empty($_GET['ttl']) ? 600 : $_GET['ttl']);
		$check = abs(TIMESTAMP - $_GET['timestamp']);
		return $check > $ttl ? 0 : 1;
	}

	function sign($arg) {
		$str = '';
		foreach ($arg as $k => $v) {
			$str .= $k . '=' . $v . '&';
		}
		return md5($str . getglobal('config/remote/appkey'));
	}

}

class remote_service {

	var $version = '1.0.0';
	var $config;

	function __construct() {
		$this->config = getglobal('config/remote');
	}

	function run() {
		remote_service::success('service is done.');
	}

	function error($code, $msg) {
		$code = sprintf("%04d", $code);
		echo $code.':'.ucfirst($msg);
		exit();
	}

	function success($msg) {
		remote_service::error(0, $msg);
	}

}

?>