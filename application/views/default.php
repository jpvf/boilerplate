<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Admin Theme</title>
<?php 
 Assets::css('reset');
 Assets::css('jquery-ui');
 Assets::css('style');
 echo Assets::show_css();
?>
<!--[if IE 7]>
<style>
.clearfix{content:"\0020";display:block;height:0;clear:both;visibility:hidden;overflow:hidden;}
</style>
<![endif]-->
</head>
<body>
<div id="container">
  <div id="header">
      <h1><a href="#">Admin Theme</a></h1>
      <ul id="menu">
        <li>
			<a href="#">Dashboard</a>
			<div class="submenu">
				<div class="triangle"></div>
				<ul>
					<li><a href="#">Uno</a></li>
					<li><a href="#">Dos</a></li>
					<li><a href="#">Tres</a></li>
				</ul>
			</div>
		</li>
        <li class="selected"><a href="#">New Items<span class="notification-number">1</span></a></li>
        <li><a href="#">Messages<span class="notification-number-zero">0</span></a></li>
        <li>
			<a href="#">Pages</a>
			<div class="submenu">
				<div class="triangle"></div>
				<ul>
					<li><a href="#">Uno</a></li>
					<li><a href="#">Dos</a></li>
					<li><a href="#">Tres</a></li>
				</ul>
			</div>
		</li>
        <li>
			<a href="#">Settings</a>
			<div class="submenu">
				<div class="triangle"></div>
				<ul>
					<li><a href="#">Uno</a></li>
					<li><a href="#">Dos</a></li>
					<li><a href="#">Tres</a></li>
				</ul>
			</div>
		</li>
        <li><a href="#">Logout</a></li>
      </ul>
  </div>
	<div id="messages">
      <?php echo Message::get(); ?>
    </div>
  <div id="content">
    <?php echo $this->template->get_content(); ?>
  </div>


<div class="push">
  </div>

  <div id="footer">	
      <p>
        &copy; 2011 Unnamed. Theme by <a href="#">Juan Velandia</a>
      </p>
  </div>

  <div style="height:1%"></div>
<?php 
	Assets::js('jquery');
	Assets::js('jquery-ui');
	Assets::js('jquery.qtselect');
	Assets::js('grid');
	Assets::js('main');
	echo Assets::show_js();
?>
<script type="text/javascript">
jQuery(function($){
	$('.button-check').button({
		icons: {
	        primary: "ui-icon-locked"
        }
	});
	
	$('.button-close').button({
		icons: {
	        primary: "ui-icon-close"
        }
	});
	
	$('.tabs').tabs();
	$('.accordion').accordion();
	//Not necessary, up to the dev.
	//$(".table-full tbody tr:odd").addClass("odd");
});
</script>
</body>
</html>