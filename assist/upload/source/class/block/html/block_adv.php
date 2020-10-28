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
 *      $Id: block_adv.php 25525 2011-11-14 04:39:11Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

require_once libfile('commonblock_html', 'class/block/html');

class block_adv extends commonblock_html {

	function __construct() {}

	function name() {
		return lang('blockclass', 'blockclass_html_script_adv');
	}

	function getsetting() {
		global $_G;
		$settings = array(
			'adv' => array(
				'title' => 'adv_adv',
				'type' => 'mradio',
				'value' => array(),
			),
			'title' => array(
				'title' => 'adv_title',
				'type' => 'text',
			)
		);
		foreach(C::t('common_advertisement_custom')->fetch_all_data() as $value) {
			$settings['adv']['value'][] = array($value['name'], $value['name']);
		}
		return $settings;
	}

	function getdata($style, $parameter) {
		$advid = 0;
		if(!empty($parameter['title'])) {
			$adv = C::t('common_advertisement_custom')->fetch_by_name($parameter['title']);
			if(empty($adv)) {
				$advid = C::t('common_advertisement_custom')->insert(array('name' => $parameter['title']), true);
			} else {
				$advid = $adv['id'];
			}
		} elseif(!empty($parameter['adv'])) {
		   $adv = C::t('common_advertisement_custom')->fetch_by_name($parameter['adv']);
		   $advid = intval($adv['id']);
		} else {
			$return = 'Empty Ads';
		}
		if($advid) {
			$flag = false;
			if(getglobal('inajax')) {
				$flag = true;
				setglobal('inajax', 0);
			}
			$return = adshow('custom_'.$advid);
			if($flag) setglobal('inajax', 1);
		}
		return array('html' => $return, 'data' => null);
	}
}

?>