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
 *      $Id: block_line.php 23608 2011-07-27 08:10:07Z cnteacher $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('commonblock_html', 'class/block/html');

class block_line extends commonblock_html {

	function __construct() {}

	function name() {
		return lang('blockclass', 'blockclass_html_script_line');
	}

	function getsetting() {
		global $_G;
		$settings = array(
			'style' => array(
				'title' => 'line_style',
				'type' => 'mradio',
				'value' => array(
					array('dash', 'line_style_dash'),
					array('line', 'line_style_line'),
				),
				'default' => 'dash'
			)
		);

		return $settings;
	}

	function getdata($style, $parameter) {
		$class = $parameter['style'] == 'line' ? 'l' : 'da';
		$return = "<hr class='$class' />";
		return array('html' => $return, 'data' => null);
	}
}

?>