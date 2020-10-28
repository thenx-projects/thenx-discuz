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
 *      $Id: block_xml.php 28663 2012-03-07 05:50:37Z zhangguosheng $
 */

if(!defined('IN_DISCUZ')) {
	exit('Access Denied');
}

class block_xml extends discuz_block {

	var $blockdata = array();

	function __construct($xmlid = null) {
		if(!empty($xmlid)) {
			if(!($blockxml = C::t('common_block_xml')->fetch($xmlid))) {
				return;
			}
			$this->blockdata = $blockxml;
			$this->blockdata['data'] = (array)dunserialize($blockxml['data']);
		} else {
			foreach(C::t('common_block_xml')->range() as $value) {
				$one = $value;
				$one['data'] = (array)dunserialize($value['data']);
				$this->blockdata[] = $one;
			}
		}
	}

	function name() {
		return dhtmlspecialchars($this->blockdata['data']['name']);
	}

	function blockclass() {
		return dhtmlspecialchars($this->blockdata['data']['blockclass']);
	}

	function fields() {
		return dhtmlspecialchars($this->blockdata['data']['fields']);
	}

	function getsetting() {
		return dhtmlspecialchars($this->blockdata['data']['getsetting']);
	}

	function getdata($style, $parameter) {
		$parameter = $this->cookparameter($parameter);
		$array = array();
		foreach($parameter as $key => $value) {
			if(is_array($value)) {
				$parameter[$key] = implode(',', $value);
			}
		}
		$parameter['clientid'] = $this->blockdata['clientid'];
		$parameter['op'] = 'getdata';
		$parameter['charset'] = CHARSET;
		$parameter['version'] = $this->blockdata['version'];
		$xmlurl = $this->blockdata['url'];
		$parse = parse_url($xmlurl);
		if(!empty($parse['host'])) {
			define('IN_ADMINCP', true);
			require_once libfile('function/importdata');
			$importtxt = @dfsockopen($xmlurl, 0, create_sign_url($parameter, $this->blockdata['key'], $this->blockdata['signtype']));
		} else {
			$ctx = stream_context_create(array('http' => array('timeout' => 20)));
			$importtxt = @file_get_contents($xmlurl, false, $ctx);
		}
		if($importtxt) {
			require libfile('class/xml');
			$array = xml2array($importtxt);
		}
		$idtype = 'xml_'.$this->blockdata['id'];
		foreach($array['data'] as $key=>$value) {
			$value['idtype'] = $idtype;
			$array['data'][$key] = $value;
		}
		if(empty($array['data'])) $array['data'] = null;
		return $array;
	}

}

?>