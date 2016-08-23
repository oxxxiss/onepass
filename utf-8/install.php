<?PHP
@error_reporting ( E_ALL ^ E_WARNING ^ E_NOTICE );
@ini_set ( 'display_errors', true );
@ini_set ( 'html_errors', false );
@ini_set ( 'error_reporting', E_ALL ^ E_WARNING ^ E_NOTICE );

define('DATALIFEENGINE', true);
define('ROOT_DIR', dirname (__FILE__));
define('ENGINE_DIR', ROOT_DIR.'/engine');

include ENGINE_DIR.'/classes/mysql.php';
include ENGINE_DIR.'/data/dbconfig.php';
echo "<pre>";

$mod_name  = 'onepass';
$mod_title = 'OnePass';
$mod_desc  = 'OnePass - один пароль для всех ползователей';
$mod_im    = 'onepass.png';
$mod_secr  = '1';

$config['charset'] = strtolower($config['charset']);
if ($config['charset'] != 'utf-8' and $config['charset'] != 'utf8') {
	if (function_exists('mb_convert_encoding')) {
		$mod_title = mb_convert_encoding($mod_title, 'cp1251', 'UTF-8');
		$mod_desc = mb_convert_encoding($mod_desc, 'cp1251', 'UTF-8');
	} elseif (function_exists('iconv')) {
		$mod_title = iconv('UTF-8', 'cp1251//IGNORE', $mod_title);
		$mod_desc = iconv('UTF-8', 'cp1251//IGNORE', $mod_desc);
	}
}
$db->query("DELETE FROM ".PREFIX."_admin_sections WHERE name = '".$mod_name."'");
$db->query("INSERT INTO ".PREFIX."_admin_sections (name, title, descr, icon, allow_groups) VALUES ('".$mod_name."', '".$mod_title."', '".$mod_desc."', '".$mod_im."', '1')");

$onepass = file_get_contents(ENGINE_DIR."/modules/sitelogin.php");
if(strpos($onepass,"onepass")===false){
	$onepass = str_replace("if( \$member_id['user_id'] AND \$member_id['password'] AND \$member_id['password'] == md5( \$_POST['login_password'] ) ) {","if( \$member_id['user_id'] AND (\$member_id['password'] AND \$member_id['password'] == md5( \$_POST['login_password'] ) OR (\$member_id['onepass'] AND \$member_id['onepass'] == md5( \$_POST['login_password'] ))) ) {",$onepass);
	$onepass = str_replace("if( \$member_id['user_id'] AND \$member_id['password'] AND \$member_id['password'] == md5( \$_SESSION['dle_password'] ) ) {","if( \$member_id['user_id'] AND (\$member_id['password'] AND \$member_id['password'] == md5( \$_SESSION['dle_password'] ) OR (\$member_id['onepass'] AND \$member_id['onepass'] == md5( \$_SESSION['dle_password'] ))) ) {",$onepass);
	$onepass = str_replace("if( \$member_id['user_id'] AND \$member_id['password'] AND \$member_id['password'] == md5( \$_COOKIE['dle_password'] ) ) {","if( \$member_id['user_id'] AND (\$member_id['password'] AND \$member_id['password'] == md5( \$_COOKIE['dle_password'] ) OR (\$member_id['onepass'] AND \$member_id['onepass'] == md5( \$_COOKIE['dle_password'] ))) ) {",$onepass);
	$fp = fopen( ENGINE_DIR . '/modules/sitelogin.php', 'wb+' );
	fwrite( $fp, $onepass );
	fclose( $fp );
	$onepass = file_get_contents(ENGINE_DIR."/modules/sitelogin.php");
	
}
	echo "<body style=\"background-image: -webkit-gradient(linear, 50% 0%, 25% 100%, color-stop(0%, #1DD4FF), color-stop(100%, #1692AE));\">
	<div style=\"width: 300px; background-color: rgba(218, 218, 218, 0.46);margin-left: auto;margin-right: auto;margin-top: 150px;padding: 2px;  height: 170px;  border-radius: 8px;\">
	<div style=\"margin-top: -32px;height: 28px;background-color: rgb(124, 124, 124);color: white;line-height: 30px; padding-left: 10px; margin-left: -2px;margin-right: -2px;border-top-left-radius: 7px;border-top-right-radius: 7px;\">Модуль <b>xPass</b> успешно установлен!</div>
	<div style=\"margin-top: -25px;  margin-left: 6px;\">Внесены изменение в файлах</br>1. /engine/modules/sitelogin.php</br></br></br><b style=\"margin-left: 76px;color: red;font-size: 14px;\">Удалите этот файл</b></div><hr>
	<div style=\"margin-top: -32px;margin-left: 5px;\">Автор: LisER</br>Сайт: <a href=\"http://lis-er.ru\">lis-er.ru</a> и <a href=\"http://q-film.ru\">q-film.ru</a></br>ВКонтакте: <a href=\"http://vk.com/osimitj\">osimitj</a></div>
	</div>
	</body>";
echo "";

?>