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
 *      $Id$
 */
if (!defined('IN_MOBILE_API')) {
	exit('Access Denied');
}
include_once 'misc.php';

class mobile_api {

    function common() {
        global $_G;
        if(submitcheck('hash', true) && $_G['uid']){
            $r = updatecreditbyaction('mobilesign', $_G['uid']);
            if($r['updatecredit']) {
              $_G['messageparam'][0] = 'mobilesign_success';
            } else {
              $_G['messageparam'][0] = 'mobilesign_failed';
            }
        } else {
            $_G['messageparam'][0] = 'mobilesign_formhash_failed';
        }
        mobile_core::result(mobile_core::variable(array()));
    }

    function output() {
    }

}

?>