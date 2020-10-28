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

function submitForm() {

	if (dialogHtml == '') {
		dialogHtml = $('siteInfo').innerHTML;
		$('siteInfo').innerHTML = '';
	}

	showWindow('open_cloud', dialogHtml, 'html');

	$('fwin_open_cloud').style.top = '80px';
	$('cloud_api_ip').value = cloudApiIp;

	return false;
}

function dealHandle(msg) {

	getMsg = true;

	if (msg['status'] == 'error') {
		$('loadinginner').innerHTML = '<font color="red">' + msg['content'] + '</font>';
		return;
	}

	$('loading').style.display = 'none';
	$('mainArea').style.display = '';

	if(cloudStatus == 'upgrade') {
		$('title').innerHTML = msg['cloudIntroduction']['upgrade_title'];
		$('msg').innerHTML = msg['cloudIntroduction']['upgrade_content'];
	} else {
		$('title').innerHTML = msg['cloudIntroduction']['open_title'];
		$('msg').innerHTML = msg['cloudIntroduction']['open_content'];
	}

	if (msg['navSteps']) {
		$('nav_steps').innerHTML = msg['navSteps'];
	}

	if (msg['protocalUrl']) {
		$('protocal_url').href = msg['protocalUrl'];
	}

	if (msg['cloudApiIp']) {
		cloudApiIp = msg['cloudApiIp'];
	}

	if (msg['manyouUpdateTips']) {
		$('manyou_update_tips').innerHTML = msg['manyouUpdateTips'];
	}
}

function expiration() {

	if(!getMsg) {
		$('loadinginner').innerHTML = '<font color="red">' + expirationText + '</font>';
		clearTimeout(expirationTimeout);
	}
}