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

$checkurl = array('www.youtube.com/watch?');

function media_youtube($url, $width, $height) { 
	if(preg_match("/^https?:\/\/www.youtube.com\/watch\?v=([^\/&]+)&?/i", $url, $matches)) {
		$flv = 'https://www.youtube.com/v/'.$matches[1].'&hl=zh_CN&fs=1';
		$iframe = 'https://www.youtube.com/embed/'.$matches[1];
		if(!$width && !$height) {
			$str = file_get_contents($url, false, $ctx);
			if(!empty($str) && preg_match("/'VIDEO_HQ_THUMB':\s'(.+?)'/i", $str, $image)) {
				$url = substr($image[1], 0, strrpos($image[1], '/')+1);
				$filename = substr($image[1], strrpos($image[1], '/')+3);
				$imgurl = $url.$filename;
			}
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}