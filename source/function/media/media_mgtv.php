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

$checkurl = array('mgtv.com/b/', 'hunantv.com/b/');

function media_mgtv($url, $width, $height) {
	if(preg_match("/https?:\/\/(m.|www.|)(mg|hunan)tv.com\/b\/(\d+)\/(\d+).html/i", $url, $matches)) {
		$vid = $matches[4];
		$flv = 'https://player.mgtv.com/mgtv_v6_out/main.swf?video_id='.$vid;
		$iframe = '';
		$imgurl = '';
	}
	return array($flv, $iframe, $url, $imgurl);
}
