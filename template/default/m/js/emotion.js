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

var emotion = {
	exprePath: DOMAIN + 'static/image/smiley/',
	expreCode: {},
	init: function () {
		var expreCon = jQuery(".expreList .expreConDiscuz");

		if (!expreCon) {
			return;
		}

		TOOLS.dget(API_URL + "module=smiley&version=4", null,
			function (json) {
				emotion.expreCode = json.Variables.smilies;
			},
			function (error) {
				TOOLS.hideLoading();
			}
		);

	},
	unquote: function (code) {
		code = code.replace(/^\/|\/$|\\/g, '');
		return code;
	},
	show: function () {
		var tabHtml = '', conHtml = '', j = 0;
		for (i in emotion.expreCode) {
			tabHtml += '<a class="expreS" g="' + j + '" href="javascript:;"><img width="16" src="' + emotion.exprePath + emotion.expreCode[i][0].image + '"></a>';
			conHtml += '<li class="expreG" g="' + j + '">';
			for (k in emotion.expreCode[i]) {
				conHtml += '<a class="expre" title="' + emotion.unquote(emotion.expreCode[i][k].code) + '" href="javascript:;"><img width="20" src="' + emotion.exprePath + emotion.expreCode[i][k].image + '"></a>';
			}
			conHtml += '</li>';
			conHtml = '<ul class="expreCon" style="margin-left:0;">' + conHtml + '</ul>';
			j++;
		}
		jQuery('.expreBox .expressionMenu').html(tabHtml);
		jQuery('.expreBox .expreList').html(conHtml);

		jQuery(".expreBox").show();
		jQuery(".photoList").hide();
		jQuery(".photoSelect").removeClass("on");
		jQuery(".expreS").on('click', function () {
			jQuery(".expreS").removeClass("on");
			jQuery(".expreS[g=" + jQuery(this).attr('g') + "]").addClass("on");
			jQuery(".expreG").hide();
			jQuery(".expreG[g=" + jQuery(this).attr('g') + "]").show();
		});
		jQuery(".expreG").hide();
		jQuery(".expreS[g=0]").addClass("on");
		jQuery(".expreG[g=0]").show();
		jQuery('.expre').on('click', function () {
			var msg = jQuery("#message");
			var content = msg.val();
			content += jQuery(this).attr("title");
			msg.val(content);
			msg[0].scrollTop = msg[0].scrollHeight;
		});
		jQuery(".expreSelect").addClass("on");
	},
	hide: function () {
		jQuery(".expreBox").hide();
		jQuery(".photoList").show();
		jQuery(".photoSelect").addClass("on");
		jQuery(" .expreSelect").removeClass("on");
	}
};