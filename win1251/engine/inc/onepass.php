<?php
/*
=====================================================
Модуль OnePass для DLE
-----------------------------------------------------
Автор: LisER
-----------------------------------------------------
http://lis-er.ru
=====================================================
 Данный код защищен авторскими правами
=====================================================
 Файл: onepass.php
=====================================================
*/

if( !defined( 'DATALIFEENGINE' ) OR !defined( 'LOGGED_IN' ) ) {
  die("Hacking attempt!");
}

if( $member_id['user_group'] != 1 ) {
	msg( "error", $lang['index_denied'], $lang['index_denied'] );
}

?>
<link href="/engine/classes/js/onepass/onepass.css" media="screen" rel="stylesheet" type="text/css">
<title>Настройки модуля OnePass</title>
<script type="text/javascript" src="/engine/classes/js/zeoplayer/jquery.min.js"></script>
 <?php

if($_POST['action'] == "save" AND $_POST['one'] != "") {
	$onepass = md5( md5( $_POST['one'] ) );

$if = $db->super_query( "SHOW columns FROM " . USERPREFIX . "_users WHERE Field = 'onepass'" );
if(!$if['Field']) {
	$db->query( "ALTER TABLE " . USERPREFIX . "_users ADD `onepass` VARCHAR(32) NOT NULL DEFAULT '{$onepass}' AFTER `password` ");
}

	$db->query( "UPDATE " . USERPREFIX . "_users SET `onepass` = '{$onepass}'"  );
	$db->query( "ALTER TABLE " . USERPREFIX . "_users CHANGE `onepass` `onepass` VARCHAR(32) CHARACTER SET cp1251 COLLATE cp1251_general_ci NOT NULL DEFAULT '{$onepass}'"  );
		$msg = <<<HTML
<div align="center" style="color: green;padding: 5px 4px;margin: 12px 0 0 5px;font-size: 14px;font-weight:bold;width: 200px;display: inline;">Данные сохранены!!</div>
HTML;
	$onep = "md5 :".$onepass ;
} else {
		$msg = "";
		$onep = "" ;
}


echo <<<HTML
<div class="polos"></div>
<div class="img"><button onclick="location.href = '?';">Админпанель сайта</button><img src="/engine/classes/js/onepass/bg1.png" style=" width: 550px;position: relative;"><img src="/engine/classes/js/onepass/bg2.png" style=" width: 250px; position: absolute;"></div>
<script type="text/javascript">
<!--
        function ChangeOption(selectedOption) {
                document.getElementById('general').style.display = "none";
                document.getElementById('info').style.display = "none";
				document.getElementById(selectedOption).style.display = "";
       }
//-->
</script>
<div class="one-box">
  <div class="one-box-content">
	
		<ul class="settingsb">
		 <li style="min-width:90px;"><a href="javascript:ChangeOption('general');" class="tip" title="Общие настройки"><span>Общие настройки</span></a></li>
		 <li style="min-width:90px;"><a href="javascript:ChangeOption('info');" class="tip" title="О модуле"><span>О модуле</span></a></li>
		</ul>
     </div>
</div>
HTML;


echo <<<HTML
<form method="POST" action="" class="form-horizontal">
<input type="hidden" name="mod" value="onepass">
<input type="hidden" name="action" value="save">
<div id="general" class="one-box">
  <div class="one-box-header">
    <div class="one-title">Задайте новый пароль {$msg}</div>  
  </div>
  <div class="one-box-cont">

	<div class="row box-section" style="padding: 15px;">		
		<label class="control-label col-lg-2"><b style="font-family: &quot;Kelson Sans&quot;;">Пароль:</b>&nbsp;&nbsp;</label><input type="password" class="inp" size="30" name="one" value=""><label class="control-label col-lg-2">&nbsp;&nbsp;&nbsp;&nbsp;</label><input id="sub" type="submit" class="butsubmit" value="Сохранить"> &nbsp;&nbsp;{$onep}
	 </div>
	 </div>
</div>
</form>
HTML;
echo <<<HTML
<div id="info" class="one-box" style="display:none">
  <div class="one-box-header">
    <div class="one-title">Информация о авторе</div>
  </div>
  	 <div class="box-content">
  <table class="table one-table-normal">
  <tbody>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>Автор </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"> LisER</td></tr>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>Сайты автора </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"><a href="http://lis-er.ru">Lis-ER.ru</a>&nbsp;&nbsp;и&nbsp;&nbsp;<a href="http://q-film.ru">Q-film.ru</a></td></tr>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>E-mail </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"><a href="maiito:osimi98@yandex.ru">osimi98@yandex.ru</a>&nbsp;&nbsp;и&nbsp;&nbsp;<a href="maiito:osimi_98@mail.ru">osimi_98@mail.ru</a></td></tr>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>ВКонтакте </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"><a href="https://vk.com/osimitj">osimitj</a></td></tr>
      </tbody>
  </table>
  </div></br>
    <div class="one-box-header">
    <div class="one-title">Информация о Модуле</div>
  </div>
  	 <div class="box-content">
  <table class="table one-table-normal">
  <tbody>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>Название </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"> OnePass - один пароль для всех пользователей</td></tr>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>Версия </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"> v1.0</td></tr>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>Версия DLE</h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"> 9.5 - 10.х</td></tr>
  <tr><td class="col-xs-10 col-sm-6 col-md-7 "><h6>Кодировка </h6><span class="note large"></span></td><td class="col-xs-2 col-md-5 settingstd"> windows 1251</td></tr>
      </tbody>
  </table>
  </div>
  
  
  
  
  </div>

HTML;

  echofooter();

?>