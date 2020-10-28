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

$checkurl = array('acfun.cn', 'acfun.tv');

function media_acfun($url, $width, $height) {
	if(preg_match("/https?:\/\/(www.|)acfun.(cn|tv)\/v\/ac(\d+)/i", $url, $matches)) {
		$vid = $matches[3];
		$flv = '';
		$iframe = 'https://www.acfun.cn/player/ac'.$vid;
		$imgurl = '';
	} elseif(preg_match("/https?:\/\/m.acfun.(cn|tv)\/v\/\?ac=(\d+)/i", $url, $matches)) {
		$vid = $matches[2];
		$flv = '';
		$iframe = 'https://www.acfun.cn/player/ac'.$vid;
		$imgurl = '';
	}
	return array($flv, $iframe, $url, $imgurl);
}
