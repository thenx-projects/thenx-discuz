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

$checkurl = array('v.ku6.com/show/', 'v.ku6.com/special/show_');

function media_ku6($url, $width, $height) { 
	if(preg_match("/^http:\/\/v.ku6.com\/show\/([^\/]+).html/i", $url, $matches)) {
		$flv = 'http://player.ku6.com/refer/'.$matches[1].'/v.swf';
		if(!$width && !$height) {
			$api = 'http://vo.ku6.com/fetchVideo4Player/1/'.$matches[1].'.html';
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str) && preg_match("/\"picpath\":\"(.+?)\"/i", $str, $image)) {
				$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
			}
		}
	} elseif(preg_match("/^http:\/\/v.ku6.com\/special\/show_\d+\/([^\/]+).html/i", $url, $matches)) {
		$flv = 'http://player.ku6.com/refer/'.$matches[1].'/v.swf';
		if(!$width && !$height) {
			$api = 'http://vo.ku6.com/fetchVideo4Player/1/'.$matches[1].'.html';
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str) && preg_match("/\"picpath\":\"(.+?)\"/i", $str, $image)) {
				$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
			}
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}