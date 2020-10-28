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

	$Id: mail.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class mailcontrol extends base {

	function __construct() {
		$this->mailcontrol();
	}

	function mailcontrol() {
		parent::__construct();
		$this->init_input();
	}

	function onadd() {
		$this->load('mail');
		$mail = array();
		$mail['appid']		= UC_APPID;
		$mail['uids']		= explode(',', $this->input('uids'));
		$mail['emails']		= explode(',', $this->input('emails'));
		$mail['subject']	= $this->input('subject');
		$mail['message']	= $this->input('message');
		$mail['charset']	= $this->input('charset');
		$mail['htmlon']		= intval($this->input('htmlon'));
		$mail['level']		= abs(intval($this->input('level')));
		$mail['frommail']	= $this->input('frommail');
		$mail['dateline']	= $this->time;
		return $_ENV['mail']->add($mail);
	}

}

?>