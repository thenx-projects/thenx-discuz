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

	$Id: home_blog.js 23838 2011-08-11 06:51:58Z monkey $
*/

function validate_ajax(obj) {
	var subject = $('subject');
	if (subject) {
		var slen = strlen(subject.value);
		if (slen < 1 || slen > 80) {
			alert("标题长度(1~80字符)不符合要求");
			subject.focus();
			return false;
		}
	}
	if($('seccode')) {
		var code = $('seccode').value;
		var x = new Ajax();
		x.get('cp.php?ac=common&op=seccode&code=' + code, function(s){
			s = trim(s);
			if(s.indexOf('succeed') == -1) {
				alert(s);
				$('seccode').focus();
		   		return false;
			} else {
				edit_save();
				obj.form.submit();
				return true;
			}
		});
	} else {
		edit_save();
		obj.form.submit();
		return true;
	}
}

function edit_album_show(id) {
	var obj = $('uchome-edit-'+id);
	if(id == 'album') {
		$('uchome-edit-pic').style.display = 'none';
	}
	if(id == 'pic') {
		$('uchome-edit-album').style.display = 'none';
	}
	if(obj.style.display == '') {
		obj.style.display = 'none';
	} else {
		obj.style.display = '';
	}
}