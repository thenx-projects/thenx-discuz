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
 *      $Id: mobile_extends_check.php 33590 2013-07-12 06:39:08Z andyzheng $
 */
if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}
class mobile_api {

	var $variable = array();

	function common() {


		$this->variable = array(
			'extends' => array(
				'extendversion' => '1',
				'extendlist' => array(
					array(
						'identifier' => 'dz_newthread',
						'name' => lang('plugin/mobile', 'mobile_extend_newthread'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
					array(
						'identifier' => 'dz_newreply',
						'name' => lang('plugin/mobile', 'mobile_extend_newreply'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
					array(
						'identifier' => 'dz_digest',
						'name' => lang('plugin/mobile', 'mobile_extend_digest'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
					array(
						'identifier' => 'dz_newpic',
						'name' => lang('plugin/mobile', 'mobile_extend_newpic'),
						'icon' => '0',
						'islogin' => '0',
						'iconright' => '0',
						'redirect' => '',
					),
				),
			)
		);
	}

	function output() {
		mobile_core::result(mobile_core::variable($this->variable));
	}
}
?>