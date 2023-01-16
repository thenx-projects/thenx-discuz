<?php

/*
	[UCenter] (C)2001-2099 Comsenz Inc.
	This is NOT a freeware, use is subject to license terms

	$Id: base.php 1167 2014-11-03 03:06:21Z hypowang $
*/

!defined('IN_UC') && exit('Access Denied');

class base {

	var $sid;
	var $time;
	var $onlineip;
	var $db;
	var $view;
	var $settings;
	var $cache;
	var $_CACHE;
	var $app;
	var $user;
	var $lang;
	var $input;

	function __construct() {
		$this->base();
	}

	function base() {
		require_once UC_ROOT.'./model/var.php';
		base_var::bind($this);
		if(empty($this->time)) {
			$this->init_var();
			$this->init_db();
			$this->init_cache();
			$this->init_app();
			$this->init_user();
			$this->init_template();
			$this->init_note();
			$this->init_mail();
		}
	}

	function init_var() {
		$this->time = time();

		$this->onlineip = $_SERVER['REMOTE_ADDR'];
		if (!defined('UC_ONLYREMOTEADDR') || (defined('UC_ONLYREMOTEADDR') && !constant('UC_ONLYREMOTEADDR'))) {
			require_once UC_ROOT.'./lib/ucip.class.php';
			if(defined('UC_IPGETTER') && !empty(constant('UC_IPGETTER'))) {
				$s = defined('UC_IPGETTER_'.strtoupper(constant('UC_IPGETTER'))) && is_array(constant('UC_IPGETTER_'.strtoupper(constant('UC_IPGETTER')))) ? constant('UC_IPGETTER_'.strtoupper(constant('UC_IPGETTER'))) : array();
				$c = 'ucip_getter_'.strtolower(constant('UC_IPGETTER'));
				require_once UC_ROOT.'./lib/'.$c.'.class.php';
				$r = $c::get($s);
				$this->onlineip = ucip::validate_ip($r) ? $r : $this->onlineip;
			} else if (isset($_SERVER['HTTP_CLIENT_IP']) && ucip::validate_ip($_SERVER['HTTP_CLIENT_IP'])) {
				$this->onlineip = $_SERVER['HTTP_CLIENT_IP'];
			} elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
				if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ",") > 0) {
					$exp = explode(",", $_SERVER['HTTP_X_FORWARDED_FOR']);
					$this->onlineip = ucip::validate_ip(trim($exp[0])) ? $exp[0] : $this->onlineip;
				} else {
					$this->onlineip = ucip::validate_ip($_SERVER['HTTP_X_FORWARDED_FOR']) ? $_SERVER['HTTP_X_FORWARDED_FOR'] : $this->onlineip;
				}
			}
		}

		define('FORMHASH', $this->formhash());
		$_GET['page'] =  max(1, intval(getgpc('page')));

		include_once UC_ROOT.'./view/default/main.lang.php';
		$this->lang = &$lang;
	}

	function init_cache() {
		$this->settings = $this->cache('settings');
		$this->cache['apps'] = $this->cache('apps');
		if(PHP_VERSION > '5.1') {
			$timeoffset = intval($this->settings['timeoffset'] / 3600);
			@date_default_timezone_set('Etc/GMT'.($timeoffset > 0 ? '-' : '+').(abs($timeoffset)));
		}
	}

	function init_input($getagent = '') {
		$input = getgpc('input', 'R');
		if($input) {
			$input = $this->authcode($input, 'DECODE', $this->app['authkey']);
			parse_str($input, $this->input);
			$this->input = daddslashes($this->input, 1, TRUE);
			$agent = $getagent ? $getagent : $this->input['agent'];

			if(($getagent && $getagent != $this->input['agent']) || (!$getagent && md5($_SERVER['HTTP_USER_AGENT']) != $agent)) {
				exit('Access denied for agent changed');
			} elseif($this->time - $this->input('time') > 3600) {
				exit('Authorization has expired');
			}
		}
		if(empty($this->input)) {
			exit('Invalid input');
		}
	}

	function init_db() {
		require_once UC_ROOT.'lib/dbi.class.php';
		$this->db = new ucserver_db();
		$this->db->connect(UC_DBHOST, UC_DBUSER, UC_DBPW, UC_DBNAME, UC_DBCHARSET, UC_DBCONNECT, UC_DBTABLEPRE);
	}

	function init_app() {
		$appid = intval(getgpc('appid'));
		$appid && $this->app = $this->cache['apps'][$appid];
	}

	function init_user() {
		if(isset($_COOKIE['uc_auth'])) {
			@list($uid, $username, $agent) = explode('|', $this->authcode($_COOKIE['uc_auth'], 'DECODE', ($this->input ? $this->app['appauthkey'] : UC_KEY)));
			if($agent != md5($_SERVER['HTTP_USER_AGENT'])) {
				$this->setcookie('uc_auth', '');
			} else {
				@$this->user['uid'] = $uid;
				@$this->user['username'] = $username;
			}
		}
	}

	function init_template() {
		$charset = UC_CHARSET;
		require_once UC_ROOT.'lib/template.class.php';
		$this->view = new template();
		$this->view->assign('dbhistories', $this->db->histories);
		$this->view->assign('charset', $charset);
		$this->view->assign('dbquerynum', $this->db->querynum);
		$this->view->assign('user', $this->user);
	}

	function init_note() {
		if($this->note_exists() && !getgpc('inajax')) {
			$this->load('note');
			$_ENV['note']->send();
		}
	}

	function init_mail() {
		if($this->mail_exists() && !getgpc('inajax')) {
			$this->load('mail');
			$_ENV['mail']->send();
		}
	}

	function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {

		// 动态密钥长度, 通过动态密钥可以让相同的 string 和 key 生成不同的密文, 提高安全性
		$ckey_length = 4;

		$key = md5($key ? $key : UC_KEY);
		// a参与加解密, b参与数据验证, c进行密文随机变换
		$keya = md5(substr($key, 0, 16));
		$keyb = md5(substr($key, 16, 16));
		$keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';

		// 参与运算的密钥组
		$cryptkey = $keya.md5($keya.$keyc);
		$key_length = strlen($cryptkey);

		// 前 10 位用于保存时间戳验证数据有效性, 10 - 26位保存 $keyb , 解密时通过其验证数据完整性
		// 如果是解码的话会从第 $ckey_length 位开始, 因为密文前 $ckey_length 位保存动态密匙以保证解密正确
		$string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
		$string_length = strlen($string);

		$result = '';
		$box = range(0, 255);

		// 产生密钥簿
		$rndkey = array();
		for($i = 0; $i <= 255; $i++) {
			$rndkey[$i] = ord($cryptkey[$i % $key_length]);
		}

		// 打乱密钥簿, 增加随机性
		// 类似 AES 算法中的 SubBytes 步骤
		for($j = $i = 0; $i < 256; $i++) {
			$j = ($j + $box[$i] + $rndkey[$i]) % 256;
			$tmp = $box[$i];
			$box[$i] = $box[$j];
			$box[$j] = $tmp;
		}

		// 从密钥簿得出密钥进行异或，再转成字符 
		for($a = $j = $i = 0; $i < $string_length; $i++) {
			$a = ($a + 1) % 256;
			$j = ($j + $box[$a]) % 256;
			$tmp = $box[$a];
			$box[$a] = $box[$j];
			$box[$j] = $tmp;
			$result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
		}

		if($operation == 'DECODE') {
			// 这里按照算法对数据进行验证, 保证数据有效性和完整性
			// $result 01 - 10 位是时间, 如果小于当前时间或为 0 则通过
			// $result 10 - 26 位是加密时的 $keyb , 需要和入参的 $keyb 做比对
			if(((int)substr($result, 0, 10) == 0 || (int)substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) === substr(md5(substr($result, 26).$keyb), 0, 16)) {
				return substr($result, 26);
			} else {
				return '';
			}
		} else {
			// 把动态密钥保存在密文里, 并用 base64 编码保证传输时不被破坏
			return $keyc.str_replace('=', '', base64_encode($result));
		}

	}

	function page($num, $perpage, $curpage, $mpurl) {
		$multipage = '';
		$mpurl .= strpos($mpurl, '?') ? '&' : '?';
		if($num > $perpage) {
			$page = 10;
			$offset = 2;

			$pages = @ceil($num / $perpage);

			if($page > $pages) {
				$from = 1;
				$to = $pages;
			} else {
				$from = $curpage - $offset;
				$to = $from + $page - 1;
				if($from < 1) {
					$to = $curpage + 1 - $from;
					$from = 1;
					if($to - $from < $page) {
						$to = $page;
					}
				} elseif($to > $pages) {
					$from = $pages - $page + 1;
					$to = $pages;
				}
			}

			$multipage = ($curpage - $offset > 1 && $pages > $page ? '<a href="'.$mpurl.'page=1" class="first"'.$ajaxtarget.'>1 ...</a>' : '').
			($curpage > 1 && !$simple ? '<a href="'.$mpurl.'page='.($curpage - 1).'" class="prev"'.$ajaxtarget.'>&lsaquo;&lsaquo;</a>' : '');
			for($i = $from; $i <= $to; $i++) {
				$multipage .= $i == $curpage ? '<strong>'.$i.'</strong>' :
				'<a href="'.$mpurl.'page='.$i.($ajaxtarget && $i == $pages && $autogoto ? '#' : '').'"'.$ajaxtarget.'>'.$i.'</a>';
			}

			$multipage .= ($curpage < $pages && !$simple ? '<a href="'.$mpurl.'page='.($curpage + 1).'" class="next"'.$ajaxtarget.'>&rsaquo;&rsaquo;</a>' : '').
			($to < $pages ? '<a href="'.$mpurl.'page='.$pages.'" class="last"'.$ajaxtarget.'>... '.$realpages.'</a>' : '').
			(!$simple && $pages > $page && !$ajaxtarget ? '<kbd><input type="text" name="custompage" size="3" onkeydown="if(event.keyCode==13) {window.location=\''.$mpurl.'page=\'+this.value; return false;}" /></kbd>' : '');

			$multipage = $multipage ? '<div class="pages">'.(!$simple ? '<em>&nbsp;'.$num.'&nbsp;</em>' : '').$multipage.'</div>' : '';
		}
		return $multipage;
	}

	function page_get_start($page, $ppp, $totalnum) {
		$totalpage = ceil($totalnum / $ppp);
		$page =  max(1, min($totalpage, intval($page)));
		return ($page - 1) * $ppp;
	}

	function load($model, $base = NULL, $release = '') {
		$base = $base ? $base : $this;
		if(empty($_ENV[$model])) {
			$release = !$release ? RELEASE_ROOT : $release;
			if(file_exists(UC_ROOT.$release."model/$model.php")) {
				require_once UC_ROOT.$release."model/$model.php";
			} else {
				require_once UC_ROOT."model/$model.php";
			}
			$modelname = $model.'model';
			$_ENV[$model] = new $modelname($base);
		}
		return $_ENV[$model];
	}

	function get_setting($k = array(), $decode = FALSE) {
		$return = array();
		$sqladd = $k ? "WHERE k IN (".$this->implode($k).")" : '';
		$settings = $this->db->fetch_all("SELECT * FROM ".UC_DBTABLEPRE."settings $sqladd");
		if(is_array($settings)) {
			foreach($settings as $arr) {
				$return[$arr['k']] = $decode ? unserialize($arr['v']) : $arr['v'];
			}
		}
		return $return;
	}

	function set_setting($k, $v, $encode = FALSE) {
		$v = is_array($v) || $encode ? addslashes(serialize($v)) : $v;
		$this->db->query("REPLACE INTO ".UC_DBTABLEPRE."settings SET k='$k', v='$v'");
	}

	function message($message, $redirect = '', $type = 0, $vars = array()) {
		include_once UC_ROOT.'view/default/messages.lang.php';
		if(isset($lang[$message])) {
			$message = $lang[$message] ? str_replace(array_keys($vars), array_values($vars), $lang[$message]) : $message;
		}
		$this->view->assign('message', $message);
		if($redirect != 'BACK' && !preg_match('/^https?:\/\//is', $redirect) && strpos($redirect, 'sid=') === FALSE) {
			if(strpos($redirect, '?') === FALSE) {
				$redirect .= '?sid='.$this->sid;
			} else {
				$redirect .= '&sid='.$this->sid;
			}
		}
		$this->view->assign('redirect', $redirect);
		if($type == 0) {
			$this->view->display('message');
		} elseif($type == 1) {
			$this->view->display('message_client');
		}
		exit;
	}

	function formhash() {
		return substr(md5(substr($this->time, 0, -4).UC_KEY), 16);
	}

	function submitcheck() {
		return @getgpc('formhash', 'P') == FORMHASH ? true : false;
	}

	function date($time, $type = 3) {
		$format[] = $type & 2 ? (!empty($this->settings['dateformat']) ? $this->settings['dateformat'] : 'Y-n-j') : '';
		$format[] = $type & 1 ? (!empty($this->settings['timeformat']) ? $this->settings['timeformat'] : 'H:i') : '';
		return gmdate(implode(' ', $format), $time + $this->settings['timeoffset']);
	}

	function implode($arr) {
		return "'".implode("','", (array)$arr)."'";
	}

	function set_home($uid, $dir = '.') {
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		!is_dir($dir.'/'.$dir1) && mkdir($dir.'/'.$dir1, 0777) && @touch($dir.'/'.$dir1.'/index.htm');
		!is_dir($dir.'/'.$dir1.'/'.$dir2) && mkdir($dir.'/'.$dir1.'/'.$dir2, 0777) && @touch($dir.'/'.$dir1.'/'.$dir2.'/index.htm');
		!is_dir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3) && mkdir($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3, 0777) && @touch($dir.'/'.$dir1.'/'.$dir2.'/'.$dir3.'/index.htm');
	}

	function get_home($uid) {
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		return $dir1.'/'.$dir2.'/'.$dir3;
	}

	function get_avatar($uid, $size = 'big', $type = '') {
		$size = in_array($size, array('big', 'middle', 'small')) ? $size : 'big';
		$uid = abs(intval($uid));
		$uid = sprintf("%09d", $uid);
		$dir1 = substr($uid, 0, 3);
		$dir2 = substr($uid, 3, 2);
		$dir3 = substr($uid, 5, 2);
		$typeadd = $type == 'real' ? '_real' : '';
		return  $dir1.'/'.$dir2.'/'.$dir3.'/'.substr($uid, -2).$typeadd."_avatar_$size.jpg";
	}

	function &cache($cachefile) {
		if(!isset($this->_CACHE[$cachefile])) {
			$cachepath = UC_DATADIR.'./cache/'.$cachefile.'.php';
			if(!file_exists($cachepath)) {
				$this->load('cache');
				$_ENV['cache']->updatedata($cachefile);
			} else {
				include_once $cachepath;
				$this->_CACHE[$cachefile] = $_CACHE[$cachefile];
			}
		}
		return $this->_CACHE[$cachefile];
	}

	function input($k) {
		if($k == 'uid') {
		    if(is_array($this->input[$k])) {
		        foreach ($this->input[$k] as $value) {
		            if(!preg_match("/^[0-9]+$/", $value)) {
		                return NULL;
		            }
		        }
		    } elseif(!preg_match("/^[0-9]+$/", $this->input[$k])) {
		        return NULL;
		    }
		}		
		return isset($this->input[$k]) ? (is_array($this->input[$k]) ? $this->input[$k] : trim($this->input[$k])) : NULL;
	}

	function serialize($s, $htmlon = 0) {
		if(file_exists(UC_ROOT.RELEASE_ROOT.'./lib/xml.class.php')) {
			include_once UC_ROOT.RELEASE_ROOT.'./lib/xml.class.php';
		} else {
			include_once UC_ROOT.'./lib/xml.class.php';
		}

		return xml_serialize($s, $htmlon);
	}

	function unserialize($s) {
		if(file_exists(UC_ROOT.RELEASE_ROOT.'./lib/xml.class.php')) {
			include_once UC_ROOT.RELEASE_ROOT.'./lib/xml.class.php';
		} else {
			include_once UC_ROOT.'./lib/xml.class.php';
		}

		return xml_unserialize($s);
	}

	function cutstr($string, $length, $dot = ' ...') {
		if(strlen($string) <= $length) {
			return $string;
		}

		$string = str_replace(array('&amp;', '&quot;', '&lt;', '&gt;'), array('&', '"', '<', '>'), $string);

		$strcut = '';
		if(strtolower(UC_CHARSET) == 'utf-8') {

			$n = $tn = $noc = 0;
			while($n < strlen($string)) {

				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t < 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}

				if($noc >= $length) {
					break;
				}

			}
			if($noc > $length) {
				$n -= $tn;
			}

			$strcut = substr($string, 0, $n);

		} else {
			for($i = 0; $i < $length; $i++) {
				$strcut .= ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
			}
		}

		$strcut = str_replace(array('&', '"', '<', '>'), array('&amp;', '&quot;', '&lt;', '&gt;'), $strcut);

		return $strcut.$dot;
	}

	function setcookie($key, $value, $life = 0, $httponly = false) {
		(!defined('UC_COOKIEPATH')) && define('UC_COOKIEPATH', '/');
		(!defined('UC_COOKIEDOMAIN')) && define('UC_COOKIEDOMAIN', '');

		if($value === '' || $life < 0) {
			$value = '';
			$life = -1;
		}

		$life = $life > 0 ? $this->time + $life : ($life < 0 ? $this->time - 31536000 : 0);
		$path = $httponly && PHP_VERSION < '5.2.0' ? UC_COOKIEPATH."; HttpOnly" : UC_COOKIEPATH;
		$secure = is_https();
		if(PHP_VERSION < '5.2.0') {
			setcookie($key, $value, $life, $path, UC_COOKIEDOMAIN, $secure);
		} else {
			setcookie($key, $value, $life, $path, UC_COOKIEDOMAIN, $secure, $httponly);
		}
	}

	function note_exists() {
		$noteexists = $this->db->result_first("SELECT value FROM ".UC_DBTABLEPRE."vars WHERE name='noteexists'");
		if(empty($noteexists)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function mail_exists() {
		$mailexists = $this->db->result_first("SELECT value FROM ".UC_DBTABLEPRE."vars WHERE name='mailexists'");
		if(empty($mailexists)) {
			return FALSE;
		} else {
			return TRUE;
		}
	}

	function dstripslashes($string) {
		if(is_array($string)) {
			foreach($string as $key => $val) {
				$string[$key] = $this->dstripslashes($val);
			}
		} else {
			$string = stripslashes($string);
		}
		return $string;
	}

	function detectescape($basepath, $relativepath) {
		// 感谢 oldhu 贡献此代码
		// 如果base不存在，有问题
		if(!file_exists($basepath)) {
			return FALSE;
		}

		// 如果文件或目录不存在，有可能是创建前的检查，使用其上一级路径
		if(!file_exists($basepath . $relativepath)) {
			$relativepath = dirname($relativepath);
			// 上一级还不存在，按最坏情况处理，阻止请求
			// 不区分返回值的目的也是为了避免给攻击者有价值的信息
			if(!file_exists($basepath . $relativepath)) {
				return FALSE;
			}
		}

		$real_base = realpath($basepath);
		$real_target = realpath($basepath . $relativepath);

		// $real_base与$real_target相等，表示就是在访问base目录，允许
		// 或者
		// $real_target的开头就是$real_base，表示在访问base之下的文件/目录，允许
		if(strcmp($real_target, $real_base) !== 0 && strpos($real_target, $real_base . DIRECTORY_SEPARATOR) !== 0) {
			return FALSE;
		}

		return TRUE;
	}

	function random($length, $numeric = 0) {
		$seed = base_convert(md5(microtime().$_SERVER['DOCUMENT_ROOT']), 16, $numeric ? 10 : 35);
		$seed = $numeric ? (str_replace('0', '', $seed).'012340567890') : ($seed.'zZ'.strtoupper($seed));
		if($numeric) {
			$hash = '';
		} else {
			$hash = chr(rand(1, 26) + rand(0, 1) * 32 + 64);
			$length--;
		}
		$max = strlen($seed) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $seed[mt_rand(0, $max)];
		}
		return $hash;
	}

	function secrandom($length, $numeric = 0, $strong = false) {
		// Thank you @popcorner for your strong support for the enhanced security of the function.
		$chars = $numeric ? array('A','B','+','/','=') : array('+','/','=');
		$num_find = str_split('CDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz');
		$num_repl = str_split('01234567890123456789012345678901234567890123456789');
		$isstrong = false;
		if(function_exists('random_bytes')) {
			$isstrong = true;
			$random_bytes = function($length) {
				return random_bytes($length);
			};
		} elseif(extension_loaded('mcrypt') && function_exists('mcrypt_create_iv')) {
			// for lower than PHP 7.0, Please Upgrade ASAP.
			$isstrong = true;
			$random_bytes = function($length) {
				$rand = mcrypt_create_iv($length, MCRYPT_DEV_URANDOM);
				if ($rand !== false && strlen($rand) === $length) {
					return $rand;
				} else {
					return false;
				}
			};
		} elseif(extension_loaded('openssl') && function_exists('openssl_random_pseudo_bytes')) {
			// for lower than PHP 7.0, Please Upgrade ASAP.
			// openssl_random_pseudo_bytes() does not appear to cryptographically secure
			// https://github.com/paragonie/random_compat/issues/5
			$isstrong = true;
			$random_bytes = function($length) {
				$rand = openssl_random_pseudo_bytes($length, $secure);
				if($secure === true) {
					return $rand;
				} else {
					return false;
				}
			};
		}
		if(!$isstrong) {
			return $strong ? false : random($length, $numeric);
		}
		$retry_times = 0;
		$return = '';
		while($retry_times < 128) {
			$getlen = $length - strlen($return); // 33% extra bytes
			$bytes = $random_bytes(max($getlen, 12));
			if($bytes === false) {
				return false;
			}
			$bytes = str_replace($chars, '', base64_encode($bytes));
			$return .= substr($bytes, 0, $getlen);
			if(strlen($return) == $length) {
				return $numeric ? str_replace($num_find, $num_repl, $return) : $return;
			}
			$retry_times++;
		}
	}

	function generate_key($length = 32) {
		$random = $this->secrandom($length);
		$info = md5($_SERVER['SERVER_SOFTWARE'].$_SERVER['SERVER_NAME'].$_SERVER['SERVER_ADDR'].$_SERVER['SERVER_PORT'].$_SERVER['HTTP_USER_AGENT'].time());
		$return = '';
		for($i=0; $i<$length; $i++) {
			$return .= $random[$i].$info[$i];
		}
		return $return;
	}

}

?>