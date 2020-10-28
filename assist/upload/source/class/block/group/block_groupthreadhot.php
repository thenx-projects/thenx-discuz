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
 *      $Id: block_groupthreadhot.php 23608 2011-07-27 08:10:07Z cnteacher $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('block_groupthread', 'class/block/group');

class block_groupthreadhot extends block_groupthread {
	function __construct() {
		$this->setting = array(
			'gtids' => array(
				'title' => 'groupthread_gtids',
				'type' => 'mselect',
				'value' => array(
				),
			),
			'special' => array(
				'title' => 'groupthread_special',
				'type' => 'mcheckbox',
				'value' => array(
					array(1, 'groupthread_special_1'),
					array(2, 'groupthread_special_2'),
					array(3, 'groupthread_special_3'),
					array(4, 'groupthread_special_4'),
					array(5, 'groupthread_special_5'),
					array(0, 'groupthread_special_0'),
				)
			),
			'rewardstatus' => array(
				'title' => 'groupthread_special_reward',
				'type' => 'mradio',
				'value' => array(
					array(0, 'groupthread_special_reward_0'),
					array(1, 'groupthread_special_reward_1'),
					array(2, 'groupthread_special_reward_2')
				),
				'default' => 0,
			),
			'picrequired' => array(
				'title' => 'groupthread_picrequired',
				'type' => 'radio',
				'value' => '0'
			),
			'orderby' => array(
				'title' => 'groupthread_orderby',
				'type'=> 'mradio',
				'value' => array(
					array('replies', 'groupthread_orderby_replies'),
					array('views', 'groupthread_orderby_views'),
					array('heats', 'groupthread_orderby_heats'),
					array('recommends', 'groupthread_orderby_recommends'),
				),
				'default' => 'replies'
			),
			'lastpost' => array(
				'title' => 'groupthread_lastpost',
				'type'=> 'mradio',
				'value' => array(
					array('0', 'groupthread_lastpost_nolimit'),
					array('3600', 'groupthread_lastpost_hour'),
					array('86400', 'groupthread_lastpost_day'),
					array('604800', 'groupthread_lastpost_week'),
					array('2592000', 'groupthread_lastpost_month'),
				),
				'default' => '0'
			),
			'gviewperm' => array(
				'title' => 'groupthread_gviewperm',
				'type' => 'mradio',
				'value' => array(
					array('0', 'groupthread_gviewperm_only_member'),
					array('1', 'groupthread_gviewperm_all_member')
				),
				'default' => '1'
			),
			'titlelength' => array(
				'title' => 'groupthread_titlelength',
				'type' => 'text',
				'default' => 40
			),
			'summarylength' => array(
				'title' => 'groupthread_summarylength',
				'type' => 'text',
				'default' => 80
			),
		);
	}

	function name() {
		return lang('blockclass', 'blockclass_groupthread_script_groupthreadhot');
	}
}

?>