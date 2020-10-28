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

/*
	[Discuz!] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: logging.js 23838 2011-08-11 06:51:58Z monkey $
*/

function lsSubmit(op) {
	var op = !op ? 0 : op;
	if(op) {
		$('lsform').cookietime.value = 2592000;
	}
	if($('ls_username').value == '' || $('ls_password').value == '') {
		showWindow('login', 'member.php?mod=logging&action=login' + (op ? '&cookietime=1' : ''));
	} else {
		ajaxpost('lsform', 'return_ls', 'return_ls');
	}
	return false;
}

function errorhandle_ls(str, param) {
	if(!param['type']) {
		showError(str);
	}
}