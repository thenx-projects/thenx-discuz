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

/**
 *      [Discuz!] (C)2001-2099 Comsenz Inc.
 *      This is NOT a freeware, use is subject to license terms
 *
 *      $Id: cache_postimg.php 31464 2012-08-30 08:59:27Z chenmengshu $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_postimg() {
	$imgextarray = array('jpg', 'gif', 'png');
	$imgdir = array('hrline', 'postbg');
	$postimgjs = 'var postimg_type = new Array();';
	foreach($imgdir as $perdir) {
		$count = 0;
		$pdir = DISCUZ_ROOT.'./static/image/'.$perdir;
		$postimgdir = dir($pdir);
		$postimgjs .= 'postimg_type["'.$perdir.'"]=[';
		while($entry = $postimgdir->read()) {
			if(in_array(strtolower(fileext($entry)), $imgextarray) && preg_match("/^[\w\-\.\[\]\(\)\<\> &]+$/", substr($entry, 0, strrpos($entry, '.'))) && strlen($entry) < 30 && is_file($pdir.'/'.$entry)) {
				$postimg[$perdir][] = array('url' => $entry);
				$postimgjs .= ($count ? ',' : '').'"'.$entry.'"';
				$count++;
			}
		}
		$postimgjs .='];';
		$postimgdir->close();
	}
	savecache('postimg', $postimg);
	$cachedir = DISCUZ_ROOT.'./data/cache/';
	if(@$fp = fopen($cachedir.'common_postimg.js', 'w')) {
		fwrite($fp, $postimgjs);
		fclose($fp);
	} else {
		exit('Can not write to cache files, please check directory ./data/ and ./data/cache/ .');
	}
}

?>