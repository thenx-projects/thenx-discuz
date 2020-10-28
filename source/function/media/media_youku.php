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

$checkurl = array('v.youku.com/v_show/');

function media_youku($url, $width, $height) { 
	$ctx = stream_context_create(array('http' => array('timeout' => 10)));
	if(preg_match("/^https?:\/\/v.youku.com\/v_show\/id_([^\/]+)(.html|)/i", $url, $matches)) {
		$params = explode('.', $matches[1]);
		$flv = 'https://player.youku.com/player.php/sid/'.$params[0].'/v.swf';
		$iframe = 'https://player.youku.com/embed/'.$params[0];
		if(!$width && !$height) {
			$api = 'http://v.youku.com/player/getPlayList/VideoIDS/'.$params[0];
			$str = stripslashes(file_get_contents($api, false, $ctx));
			if(!empty($str) && preg_match("/\"logo\":\"(.+?)\"/i", $str, $image)) {
				$url = substr($image[1], 0, strrpos($image[1], '/')+1);
				$filename = substr($image[1], strrpos($image[1], '/')+2);
				$imgurl = $url.'0'.$filename;
			}
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}