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

$checkurl = array('www.56.com');

function media_56($url, $width, $height) {
	if(preg_match("/^http:\/\/www.56.com\/\S+\/play_album-aid-(\d+)_vid-(.+?).html/i", $url, $matches)) {
		$flv = 'http://player.56.com/v_'.$matches[2].'.swf';
		$matches[1] = $matches[2];
	} elseif(preg_match("/^http:\/\/www.56.com\/\S+\/([^\/]+).html/i", $url, $matches)) {
		$flv = 'http://player.56.com/'.$matches[1].'.swf';
	}
	if(!$width && !$height && !empty($matches[1])) {
		$api = 'http://vxml.56.com/json/'.str_replace('v_', '', $matches[1]).'/?src=out';
		$str = file_get_contents($api, false, $ctx);
		if(!empty($str) && preg_match("/\"img\":\"(.+?)\"/i", $str, $image)) {
			$imgurl = trim($image[1]);
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}