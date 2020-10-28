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
 *      $Id: cache_bbcodes_display.php 24599 2011-09-27 11:06:53Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_bbcodes_display() {
	$data = array();
	$i = 0;
	foreach(C::t('forum_bbcode')->fetch_all_by_available_icon(2, true) as $bbcode) {
		$bbcode['perm'] = explode("\t", $bbcode['perm']);
		if(in_array('', $bbcode['perm']) || !$bbcode['perm']) {
			continue;
		}
		$i++;
		$tag = $bbcode['tag'];
		$bbcode['i'] = $i;
		$bbcode['explanation'] = dhtmlspecialchars(trim($bbcode['explanation']));
		$bbcode['prompt'] = addcslashes($bbcode['prompt'], '\\\'');
		unset($bbcode['tag']);
		foreach($bbcode['perm'] as $groupid) {
			$data[$groupid][$tag] = $bbcode;
		}
	}

	savecache('bbcodes_display', $data);
}

?>