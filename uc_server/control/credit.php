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

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: credit.php 1059 2011-03-01 07:25:09Z monkey $
*/

!defined('IN_UC') && exit('Access Denied');

class creditcontrol extends base {

	function __construct() {
		$this->creditcontrol();
	}

	function creditcontrol() {
		parent::__construct();
		$this->init_input();
		$this->load('note');
		$this->load('misc');
	}

	function onrequest() {
		$uid = intval($this->input('uid'));
		$from = intval($this->input('from'));
		$to = intval($this->input('to'));
		$toappid = intval($this->input('toappid'));
		$amount = intval($this->input('amount'));
		$status = 0;
		$this->settings['creditexchange'] = @unserialize($this->settings['creditexchange']);
		if(isset($this->settings['creditexchange'][$this->app['appid'].'_'.$from.'_'.$toappid.'_'.$to])) {
			$toapp = $app = $this->cache['apps'][$toappid];
			$apifilename = isset($toapp['apifilename']) && $toapp['apifilename'] ? $toapp['apifilename'] : 'uc.php';
			if($toapp['extra']['apppath'] && $this->detectescape($toapp['extra']['apppath'].'./api/', $apifilename) && substr(strrchr($apifilename, '.'), 1, 10) == 'php' && @include $toapp['extra']['apppath'].'./api/'.$apifilename) {
				$uc_note = new uc_note();
				$status = $uc_note->updatecredit(array('uid' => $uid, 'credit' => $to, 'amount' => $amount), '');
			} else {
				$url = $_ENV['note']->get_url_code('updatecredit', "uid=$uid&credit=$to&amount=$amount", $toappid);
				$status = trim($_ENV['misc']->dfopen($url, 0, '', '', 1, $toapp['ip'], UC_NOTE_TIMEOUT));
			}
		}
		echo $status ? 1 : 0;
		exit;
	}
}

?>