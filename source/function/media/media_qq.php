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

$checkurl = array('v.qq.com/x/page/','v.qq.com/x/cover/');

function media_qq($url, $width, $height) {
	if(preg_match("/https?:\/\/v.qq.com\/x\/page\/([^\/]+)(.html|)/i", $url, $matches)) {
			$vid = explode(".html", $matches[1]);
			$flv = 'https://imgcache.qq.com/tencentvideo_v1/playerv3/TPout.swf?vid='.$vid[0];
			$iframe = 'https://v.qq.com/txp/iframe/player.html?vid='.$vid[0];
			$imgurl = '';
	} else if(preg_match("/https?:\/\/v.qq.com\/x\/cover\/([^\/]+)\/([^\/]+)(.html|)/i", $url, $matches)) {
			$vid = explode(".html", $matches[2]);
			$flv = 'https://imgcache.qq.com/tencentvideo_v1/playerv3/TPout.swf?vid='.$vid[0];
			$iframe = 'https://v.qq.com/txp/iframe/player.html?vid='.$vid[0];
			$imgurl = '';
	}
	return array($flv, $iframe, $url, $imgurl);
}