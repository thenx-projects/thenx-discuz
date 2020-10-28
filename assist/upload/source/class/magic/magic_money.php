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
 *      $Id: magic_money.php 26715 2011-12-21 01:35:43Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class magic_money {

	var $version = '1.0';
	var $name = 'money_name';
	var $description = 'money_desc';
	var $price = '10';
	var $weight = '10';
	var $useevent = 1;
	var $copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';
	var $magic = array();
	var $parameters = array();

	function getsetting(&$magic) {
	}

	function setsetting(&$magicnew, &$parameters) {
	}

	function usesubmit() {
		global $_G;
		$getmoney = rand(1, intval($this->magic['price'] * 1.5));
		updatemembercount($_G['uid'], array($_G['setting']['creditstransextra'][3] => $getmoney), 1, 'MRC', $this->magic['magicid']);

		usemagic($this->magic['magicid'], $this->magic['num']);
		updatemagiclog($this->magic['magicid'], '2', '1', '0', 0, 'uid', $_G['uid']);
		showmessage('magics_credit_message', '', array('credit' => $_G['setting']['extcredits'][$_G['setting']['creditstransextra'][3]]['title'].' '.$getmoney.' '.$_G['setting']['extcredits'][$_G['setting']['creditstransextra'][3]]['unit']), array('alert' => 'right', 'showdialog' => 1));
	}

	function show() {
		magicshowtips(lang('magic/money', 'money_info'));
	}

	function buy() {
	}

}

?>