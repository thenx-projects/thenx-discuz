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

$checkurl = array('video.sina.com.cn/v/b/', 'you.video.sina.com.cn/b/');

function media_sina($url, $width, $height) {
	if(preg_match("/^http:\/\/video.sina.com.cn\/v\/b\/(\d+)-(\d+).html/i", $url, $matches)) {
		$flv = 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid='.$matches[1];
		if(!$width && !$height) {
			$api = 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid='.$matches[1];
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str)) {
				$imgurl = str_replace('imgurl=', '', trim($str));
			}
		}
	} elseif(preg_match("/^http:\/\/you.video.sina.com.cn\/b\/(\d+)-(\d+).html/i", $url, $matches)) {
		$flv = 'http://vhead.blog.sina.com.cn/player/outer_player.swf?vid='.$matches[1];
		if(!$width && !$height) {
			$api = 'http://interface.video.sina.com.cn/interface/common/getVideoImage.php?vid='.$matches[1];
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str)) {
				$imgurl = str_replace('imgurl=', '', trim($str));
			}
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}