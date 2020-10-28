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

var initSideBar = function (data, hookpre) {
	var hook_sidebar = TOOLS.hook(data, hookpre + '_sideBar');
	if (hook_sidebar !== null && typeof hook_sidebar === 'string') {
		data.hook_sidebar = hook_sidebar;
	}
	TC.load("sidebar.htm");
	var tmpl = template.render('sideBar_' + hookpre, data);

	var mask = '<div id="fwin_mask_tips" class="g-mask" style="display:none;position:absolute;top:-0px;left:-0px;width:' + jQuery(document).width() + 'px;height:' + jQuery(document).height() + 'px;background:#000;filter:alpha(opacity=60);opacity:0.5; z-index:10000;"></div>';
	jQuery(mask + tmpl).appendTo('body');
	var sideBarInit = jQuery('#fwin_normal_sideBar');
	sideBarInit.attr('showed', '');

	$('.g-mask').on('click', function (e) {
		showSideBar();
	});
	if (data.Variables.member_uid != '0') {
		$('.s_prfile').on('click', function (e) {
			TOOLS.openNewPage('?a=profile');
		});
	} else {
		$('.s_prfile').html('登录');
		$('.s_prfile').on('click', function (e) {
			TOOLS.openNewPage('?a=login&referer=' + escape(window.location.search));
		});
	}
	TOOLS.getCheckInfo(function (re) {
		var num = 0;
		if (data.Variables.notice.newmypost != '0') {
			num += parseInt(data.Variables.notice.newmypost);
		}
		if (data.Variables.notice.newpm != '0') {
			num += parseInt(data.Variables.notice.newpm);
		}
		if (num > 0) {
			$('.sidePerMan .numP').show();
			$('.sidePerMan .numP').html(num);
		}
	});
};

var showSideBar = function () {
	var sideBar = jQuery('#fwin_normal_sideBar');
	var mask = jQuery('#fwin_mask_tips');
	mask.height(jQuery(document).height());
	if (sideBar.attr('showed')) {
		sideBar.hide();
		mask.hide();
		sideBar.attr('showed', '');
	} else {
		sideBar.show();
		mask.show();
		sideBar.attr('showed', '1');
	}

};