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

$checkurl = array('tudou.com/programs/view/');

function media_tudou($url, $width, $height) { 
	if(preg_match("/^http:\/\/(www.)?tudou.com\/programs\/view\/([^\/]+)/i", $url, $matches)) {
		$flv = 'http://www.tudou.com/v/'.$matches[2];
		$iframe = 'http://www.tudou.com/programs/view/html5embed.action?code='.$matches[2];
		if(!$width && !$height) {
			$str = file_get_contents($url, false, $ctx);
			if(!empty($str) && preg_match("/<span class=\"s_pic\">(.+?)<\/span>/i", $str, $image)) {
				$imgurl = trim($image[1]);
			}
		}
	}
	return array($flv, $iframe, $url, $imgurl);
}