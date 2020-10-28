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
 *      $Id: magic_friendnum.php 26749 2011-12-22 07:38:37Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class magic_friendnum {

	var $version = '1.0';
	var $name = 'friendnum_name';
	var $description = 'friendnum_desc';
	var $price = '20';
	var $weight = '20';
	var $useevent = 0;
	var $targetgroupperm = false;
	var $copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';
	var $magic = array();
	var $parameters = array();

	function getsetting(&$magic) {
		$settings = array(
			'addnum' => array(
				'title' => 'friendnum_addnum',
				'type' => 'select',
				'value' => array(
					array('5', '5'),
					array('10', '10'),
					array('20', '20'),
					array('50', '50'),
				),
				'default' => '10'
			),
		);
		return $settings;
	}

	function setsetting(&$magicnew, &$parameters) {
		$magicnew['addnum'] = in_array($parameters['addnum'], array(5,10,20,50)) ? intval($parameters['addnum']) : '10';
	}

	function usesubmit() {
		global $_G;

		$addnum = !empty($this->parameters['addnum']) ? intval($this->parameters['addnum']) : 10;
		C::t('common_member_field_home')->increase($_G['uid'], array('addfriend' => $addnum));
		usemagic($this->magic['magicid'], $this->magic['num']);
		updatemagiclog($magic['magicid'], '2', '1', '0', '0', 'uid', $_G['uid']);
		showmessage('magics_friendadd_message', '', array('num'=>intval($this->parameters['addnum'])), array('alert' => 'right', 'showdialog' => 1));
	}

	function show() {
		magicshowtips(lang('magic/friendnum', 'friendnum_info', array('num'=>intval($this->parameters['addnum']))));
	}

}

?>