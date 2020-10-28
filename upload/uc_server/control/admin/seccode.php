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

	$Id: seccode.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class control extends base {

	function __construct() {
		$this->control();
	}

	function control() {
		parent::__construct();
		$authkey = md5(UC_KEY.$_SERVER['HTTP_USER_AGENT'].$this->onlineip);

		$this->time = time();
		$seccodeauth = getgpc('seccodeauth');
		$seccode = $this->authcode($seccodeauth, 'DECODE', $authkey);

		@header("Expires: -1");
		@header("Cache-Control: no-store, private, post-check=0, pre-check=0, max-age=0", FALSE);
		@header("Pragma: no-cache");

		include_once UC_ROOT.'lib/seccode.class.php';
		$code = new seccode();
		$code->code = $seccode;
		$code->type = 0;
		$code->width = 70;
		$code->height = 21;
		$code->background = 0;
		$code->adulterate = 1;
		$code->ttf = 1;
		$code->angle = 0;
		$code->color = 1;
		$code->size = 0;
		$code->shadow = 1;
		$code->animator = 0;
		$code->fontpath = UC_ROOT.'images/fonts/';
		$code->datapath = UC_ROOT.'images/';
		$code->includepath = '';
		$code->display();
	}

}

?>