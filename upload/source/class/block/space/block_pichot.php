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
 *      $Id: block_pichot.php 25525 2011-11-14 04:39:11Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('block_pic', 'class/block/space');

class block_pichot extends block_pic {
	function __construct() {
		$this->setting = array(
			'hours' => array(
				'title' => 'piclist_hours',
				'type' => 'mradio',
				'value' => array(
					array('', 'piclist_hours_nolimit'),
					array('1', 'piclist_hours_hour'),
					array('24', 'piclist_hours_day'),
					array('168', 'piclist_hours_week'),
					array('720', 'piclist_hours_month'),
					array('8760', 'piclist_hours_year'),
				),
				'default' => '720'
			),
			'titlelength' => array(
				'title' => 'piclist_titlelength',
				'type' => 'text',
				'default' => 40
			),
			'startrow' => array(
				'title' => 'piclist_startrow',
				'type' => 'text',
				'default' => 0
			),
		);
	}

	function name() {
		return lang('blockclass', 'blockclass_pic_script_pichot');
	}

	function cookparameter($parameter) {
		$parameter['orderby'] = 'hot';
		return parent::cookparameter($parameter);
	}
}

?>