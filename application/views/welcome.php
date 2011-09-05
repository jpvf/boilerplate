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
      <div class="message success" style="display: block;"><p>Proyecto creado</p><span class="hide" title="Hide"></span></div>
      <div class="message error" style="display: block;"><p>Ha ocurrido un error, vuelva a intentarlo.</p><span class="hide" title="Hide"></span></div>
      <div class="message info" style="display: block;"><p>Este es un mensaje de informacion</p><span class="hide" title="Hide"></span></div> 
      <div class="message warning" style="display: block;"><p>Y yo soy un mensaje de alerta</p><span class="hide" title="Hide"></span></div> 
    </div>
  <div id="content">
  	<div class="box col-4">
  		
  		<div class="box-container">
	  		<h2>Welcome</h2>
	  		<p>Welcome to the framework, everything seems ok, enjoy the ride!</p>
  		</div>
  	</div>
  	<span class="clearfix"></span>
    <div class="box col-1">
        
      <h4>Titulo</h4>
      <div class="box-container">  
        <ul class="items-list">
			<li><a href="#">Uno</a></li>
			<li>Item 2</li>
			<li>Item 3</li>
			<li>Item 4</li>
		</ul>
		<a href='#' class="button">Button</a>
		<a href='#' class="button negative">Button</a>
		<a href='#' class="button positive">Button</a>
		<br><br>
		<button class="button button-check">Button</button>
		<button class="button button-close negative">Button</button>
      </div>

      <h4>Titulo</h4>
      <div class="box-container">  
        <ul class="items-list">
			<li>Item 1</li>
			<li>Item 2</li>
			<li>Item 3</li>
			<li>Item 4</li>
		</ul>
      </div>

      <h4>Titulo</h4>
      <div class="box-container">  
        <input type="text" />
      </div>
    </div>
    <div class="box col-1">
      <h4>Titulo</h4>
      <div class="box-container">
        <ul class="items-list-full">
			<li>Item 1</li>
			<li>Item 2</li>
			<li>Item 3</li>
			<li>Item 4</li>
		</ul>
      </div>
    </div>
    <div class="box col-1">
      <h4>Titulo</h4>
      <div class="box-container">
     	<a href='#'>Link!</a>
		<a href='#'>Link 2!</a>
		<a href='#'>Link 3!</a>
      </div>

      <h4>Titulo</h4>
      <div class="box-container">
       3
      </div>
      
      <h4>Titulo</h4>
      <div class="box-container">
       3
      </div>

<h4>Titulo</h4>
      <div class="box-container">
       3
      </div>
    </div>
    <div class="box col-1 last">
      <h4>Titulo</h4>
      <div class="box-container">
        4
      </div>
    </div>
    <span class="clearfix"></span>
    <div class="box col-2">
<h4>Titulo</h4>
      <div class="box-container">
       		<table class='table-full no-grid'> 
              <thead> 
                <tr> 
                  <td class="grid-check"><input class='check-all' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>Lorem Ipsum</td> 
				  <td>Lorem Ipsum</td> 
				  <td>Lorem Ipsum</td> 
				  <td>Lorem Ipsum</td> 
                </tr> 
              </thead> 
              <tbody> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='81471255' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='15449836' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='81671942' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='27732272' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='77558139' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='18725557' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='49156128' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>4</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='31324416' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>2</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='37197416' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>6</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
              </tbody> 
              <tfoot> 
              </tfoot> 
            </table>
      </div>
    </div>
    <div class="box col-2 last">
<h4>Titulo</h4>
      <div class="box-container">
        	<table class='table-full no-grid-alt'> 
              <thead> 
                <tr> 
                  <td class="grid-check"><input class='check-all' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>Lorem Ipsum</td> 
					<td>Lorem Ipsum</td> 
					<td>Lorem Ipsum</td> 
					<td>Lorem Ipsum</td> 
                </tr> 
              </thead> 
              <tbody> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='81471255' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='15449836' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='81671942' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='27732272' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='77558139' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='18725557' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='49156128' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>4</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='31324416' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>2</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='37197416' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>6</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
              </tbody> 
              <tfoot> 
              </tfoot> 
            </table>
      </div>
    </div>
    <span class="clearfix"></span>
    <div class="box col-3">
      <h4>Titulo</h4>
      <div class="box-container">
        4
      </div>
      <div class="box-container">
        4
      </div>
      
      <div class="box-container">
        <div class="tabs">
			<ul>
				<li><a href="#tabs-1">Nunc tincidunt</a></li>
				<li><a href="#tabs-2">Proin dolor</a></li>
				<li><a href="#tabs-3">Aenean lacinia</a></li>
			</ul>
			<div id="tabs-1">
				<p>
					Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.
					Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliq
					uet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. 
					Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vi
					tae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius soll
					icitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tem
					pus lectus.
				</p>
			</div>
			<div id="tabs-2">
				<p>
					Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.
					Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliq
					uet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. 
					Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vi
					tae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius soll
					icitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tem
					pus lectus.
				</p>
			</div>
			<div id="tabs-3">
				<p>
					Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.
					Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliq
					uet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. 
					Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vi
					tae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius soll
					icitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tem
					pus lectus.
				</p>
				<p>
					Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.
					Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliq
					uet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. 
					Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vi
					tae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius soll
					icitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tem
					pus lectus.
				</p>
			</div>
		</div>
		
      </div>
    </div>
    <div class="box col-1 last">
      <h4>Titulo</h4>
      <div class="box-container">
        4
      </div>
    </div>
    <span class="clearfix"></span>
    <div class="box col-1">
      <h4>Titulo</h4>
      <div class="box-container">
        4
      </div>
    </div>
    <div class="box col-3 last">
      <h4>Titulo</h4>
      <div class="box-container">
        4
      </div>
    </div>
    <span class="clearfix"></span>
    
    <div class="box col-1">
      <div class="box-container">
        <div class="tabs">
			<ul>
				<li><a href="#tabs-1">Nunc tincidunt</a></li>
				<li><a href="#tabs-2">Proin dolor</a></li>
			</ul>
			<div id="tabs-1">
				<p>
					Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.
					Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliq
					uet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. 
					Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vi
					tae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius soll
					icitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tem
					pus lectus.
				</p>
			</div>
			<div id="tabs-2">
				<p>
					Proin elit arcu, rutrum commodo, vehicula tempus, commodo a, risus. Curabitur nec arcu.
					Donec sollicitudin mi sit amet mauris. Nam elementum quam ullamcorper ante. Etiam aliq
					uet massa et lorem. Mauris dapibus lacus auctor risus. Aenean tempor ullamcorper leo. 
					Vivamus sed magna quis ligula eleifend adipiscing. Duis orci. Aliquam sodales tortor vi
					tae ipsum. Aliquam nulla. Duis aliquam molestie erat. Ut et mauris vel pede varius soll
					icitudin. Sed ut dolor nec orci tincidunt interdum. Phasellus ipsum. Nunc tristique tem
					pus lectus.
				</p>
			</div>
		</div>
      </div>
    </div>
    <div class="box col-2">
<h4>Titulo</h4>
      <div class="box-container">
        <div class="accordion">
			<h3><a href="#">Section 1</a></h3>
			<div>
				<p>
				Mauris mauris ante, blandit et, ultrices a, suscipit eget, quam. Integer
				ut neque. Vivamus nisi metus, molestie vel, gravida in, condimentum sit
				amet, nunc. Nam a nibh. Donec suscipit eros. Nam mi. Proin viverra leo ut
				odio. Curabitur malesuada. Vestibulum a velit eu ante scelerisque vulputate.
				</p>
			</div>
			<h3><a href="#">Section 2</a></h3>
			<div>
				<p>
				Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet
				purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor
				velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In
				suscipit faucibus urna.
				</p>
			</div>
			<h3><a href="#">Section 3</a></h3>
			<div>
				<p>
				Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis.
				Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero
				ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis
				lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui.
				</p>
				<ul>
					<li>List item one</li>
					<li>List item two</li>
					<li>List item three</li>
				</ul>
			</div>
			<h3><a href="#">Section 4</a></h3>
			<div>
				<p>
				Cras dictum. Pellentesque habitant morbi tristique senectus et netus
				et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in
				faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia
				mauris vel est.
				</p>
				<p>
				Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus.
				Class aptent taciti sociosqu ad litora torquent per conubia nostra, per
				inceptos himenaeos.
				</p>
			</div>
		</div>
      </div>
    </div>
    <div class="box col-1 last">
<h4>Titulo</h4>
      <div class="box-container">
        4
      </div>
    </div>
<span class="clearfix"></span>
    <div class="box col-4">
<h4>Titulo</h4>
      <div class="box-container">
        	<table class='table-full'> 
              <thead> 
                <tr> 
                  <td class="grid-check"><input class='check-all' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>Lorem Ipsum</td> 
					<td>Lorem Ipsum</td> 
					<td>Lorem Ipsum</td> 
					<td>Lorem Ipsum</td> 
                </tr> 
              </thead> 
              <tbody> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='81471255' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='15449836' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='81671942' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='27732272' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='77558139' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='18725557' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>1</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='49156128' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>4</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr> 
                  <td class="grid-check"><input name='action[]' value='31324416' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>2</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
                <tr class="odd"> 
                  <td class="grid-check"><input name='action[]' value='37197416' type='checkbox'/></td> 
                  <td>Lorem Ipsum</td> 
                  <td>email@email.com</td> 
                  <td>6</td> 
                  <td>profile</td> 
                  <td>Lorem Ipsum</td> 
                </tr> 
              </tbody> 
              <tfoot> 
              </tfoot> 
            </table>
      </div>
    </div>
  </div>
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
	$('input').datepicker();
	//Not necessary, up to the dev.
	//$(".table-full tbody tr:odd").addClass("odd");
});
</script>
</body>
</html>