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
 *      $Id: task_promotion.php 24735 2011-10-10 02:45:39Z svn_project_zhangjie $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class task_promotion {

	var $version = '1.0';
	var $name = 'promotion_name';
	var $description = 'promotion_desc';
	var $copyright = '<a href="http://www.comsenz.com" target="_blank">Comsenz Inc.</a>';
	var $icon = '';
	var $period = '';
	var $periodtype = 0;
	var $conditions = array(
		'num' => array(
			'title' => 'promotion_complete_var_iplimit',
			'type' => 'text',
			'value' => '',
			'default' => 100,
			'sort' => 'complete',
		),
	);

	function preprocess($task) {
		global $_G;

		$promotions = C::t('forum_promotion')->count_by_uid($_G['uid']);
		C::t('forum_spacecache')->insert(array(
			'uid' => $_G['uid'],
			'variable' => 'promotion'.$task['taskid'],
			'value' => $promotions,
			'expiration' => $_G['timestamp'],
		), false, true);
	}

	function csc($task = array()) {
		global $_G;

		$promotion = C::t('forum_spacecache')->fetch($_G['uid'], 'promotion'.$task['taskid']);
		$promotion = $promotion['value'];
		$num = C::t('forum_promotion')->count_by_uid($_G['uid']) - $promotion;
		$numlimit = C::t('common_taskvar')->get_value_by_taskid($task['taskid'], 'num');
		if($num && $num >= $numlimit) {
			return TRUE;
		} else {
			return array('csc' => $num > 0 && $numlimit ? sprintf("%01.2f", $num / $numlimit * 100) : 0, 'remaintime' => 0);
		}
	}

	function sufprocess($task) {
		global $_G;

		C::t('forum_spacecache')->delete($_G['uid'], 'promotion'.$task['taskid']);
	}

}

?>