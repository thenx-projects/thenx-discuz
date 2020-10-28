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
 *      $Id: cache_smileycodes.php 24968 2011-10-19 09:51:28Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_smileycodes() {
	$data = array();
	foreach(C::t('forum_imagetype')->fetch_all_by_type('smiley', 1) as $type) {
		foreach(C::t('common_smiley')->fetch_all_by_type_code_typeid('smiley', $type['typeid']) as $smiley) {
			if($size = @getimagesize('./static/image/smiley/'.$type['directory'].'/'.$smiley['url'])) {
				$data[$smiley['id']] = $smiley['code'];
			}
		}
	}

	savecache('smileycodes', $data);
}

?>