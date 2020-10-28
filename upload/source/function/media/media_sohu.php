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

$checkurl = array('my.tv.sohu.com/u/', 'v.blog.sohu.com/u/');

function media_sohu($url, $width, $height) {
	if(preg_match("/^http:\/\/my.tv.sohu.com\/u\/[^\/]+\/(\d+)/i", $url, $matches)) {
		$flv = 'http://v.blog.sohu.com/fo/v4/'.$matches[1];
		if(!$width && !$height) {
			$api = 'http://v.blog.sohu.com/videinfo.jhtml?m=view&id='.$matches[1].'&outType=3';
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str) && preg_match("/\"cutCoverURL\":\"(.+?)\"/i", $str, $image)) {
				$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
			}
		}
	} elseif(preg_match("/^http:\/\/v.blog.sohu.com\/u\/[^\/]+\/(\d+)/i", $url, $matches)) {
		$flv = 'http://v.blog.sohu.com/fo/v4/'.$matches[1];
		if(!$width && !$height) {
			$api = 'http://v.blog.sohu.com/videinfo.jhtml?m=view&id='.$matches[1].'&outType=3';
			$str = file_get_contents($api, false, $ctx);
			if(!empty($str) && preg_match("/\"cutCoverURL\":\"(.+?)\"/i", $str, $image)) {
				$imgurl = str_replace(array('\u003a', '\u002e'), array(':', '.'), $image[1]);
			}
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}