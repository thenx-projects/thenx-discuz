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
 *      $Id: cache_secqaa.php 24522 2011-09-23 02:12:46Z zhengqingpeng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

function build_cache_secqaa() {
	$data = array();
	$secqaanum = C::t('common_secquestion')->count();

	$start_limit = $secqaanum <= 10 ? 0 : mt_rand(0, $secqaanum - 10);
	$i = 1;
	foreach(C::t('common_secquestion')->fetch_all($start_limit, 10) as $secqaa) {
		if(!$secqaa['type'])  {
			$secqaa['answer'] = md5($secqaa['answer']);
		}
		$data[$i] = $secqaa;
		$i++;
	}
	while(($secqaas = count($data)) < 9) {
		$data[$secqaas + 1] = $data[array_rand($data)];
	}
	savecache('secqaa', $data);
}

?>