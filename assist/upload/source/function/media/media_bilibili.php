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

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

$checkurl = array('bilibili.com/video/', 'bilibili.tv/video/', 'acg.tv', 'b23.tv');

function media_bilibili($url, $width, $height) {
	if(preg_match("/https?:\/\/(m.|www.|)bilibili.(com|tv)\/video\/(a|b)v([A-Za-z0-9]+)(\/?.*?&p=|\/?\?p=)?(\d+)?/i", $url, $matches)) {
		$vid = (is_numeric($matches[4]) ? 'aid='.$matches[4] : 'bvid='.$matches[4]) . (empty($matches[6]) ? '' : '&page='.intval($matches[6]));
		$flv = '';
		$iframe = 'https://player.bilibili.com/player.html?'.$vid;
		$imgurl = '';
	} else if(preg_match("/https?:\/\/(www.|)(acg|b23).tv\/(a|b)v([A-Za-z0-9]+)(\/?.*?&p=|\/?\?p=)?(\d+)?/i", $url, $matches)) {
		$vid = (is_numeric($matches[4]) ? 'aid='.$matches[4] : 'bvid='.$matches[4]) . (empty($matches[6]) ? '' : '&page='.intval($matches[6]));
		$flv = '';
		$iframe = 'https://player.bilibili.com/player.html?'.$vid;
		$imgurl = '';
	}
	return array($flv, $iframe, $url, $imgurl);
}
