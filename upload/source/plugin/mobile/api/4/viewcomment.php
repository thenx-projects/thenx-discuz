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
 *      $Id: recommend.php 34398 2014-04-14 07:11:22Z nemohou $
 */
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}



$_GET['mod'] = 'misc';
$_GET['action'] = 'commentmore';
$_GET['inajax'] = 1;
include_once 'forum.php';

class mobile_api {

	function common() {

	}

	function output() {
        $comments = mobile_core::getvalues($GLOBALS['comments'], array('/^\d+$/'), array('id', 'tid', 'pid', 'author', 'authorid', 'dateline', 'comment', 'avatar'));
        foreach($GLOBALS['comments'] as $k => $c) {
            $comments[$k]['avatar'] = avatar($c['authorid'], 'small', true);
        }
        $variables = array(
            'tid' => $_GET['tid'],
            'pid' => $_GET['pid'],
            'comments' => array($_GET['pid'] => $comments),
            'totalcomment' => $GLOBALS['totalcomment'],
            'count' => $GLOBALS['count'],
        );
		mobile_core::result(mobile_core::variable($variables));
	}
}

?>