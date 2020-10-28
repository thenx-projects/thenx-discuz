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
 *      $Id: index.php 34314 2014-02-20 01:04:24Z nemohou $
 */

define('IN_OPEN', 1);
define('SUB_DIR', 'api/open/');
chdir('../../');

require_once 'source/class/helper/helper_open.php';
class open_api_base extends helper_open_base {}

$_GET['mobile'] = 'no';

if(empty($_GET['module']) || !preg_match('/^[\w\.]+$/', $_GET['module'])) {
	helper_open::result(array('error' => 'param_error'));
}

$apifile = 'api/open/'.$_GET['module'].'.php';

if(file_exists($apifile)) {
	require_once $apifile;
} else {
	helper_open::result(array('error' => 'module_not_exists'));
}

?>