<!DOCTYPE html>
<html>

  <head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/> 

  <title>{Nombre curioso de cms}</title>
  
  <?php Assets::css('reset') ?>
  <?php Assets::css('admin/jquery-ui') ?>
  <?php Assets::css('admin/style') ?>
  <?php (isset($css) AND !empty($css)) ? Assets::css($css) : '';?>
  <?php echo Assets::show_css(); ?>

  </head>
  <body>

    <div class="header">

    	<h1><?php echo anchor('admin', '{Nombre curioso de cms}'); ?></a></h1>

    	<div class="user-box align-right">
    		<p>
    		  <a href='#' class="user-settings">User Admin</a> 
          <a href="login.html" class="button logout">Logout</a>
        </p> 
      </div>
    </div>
    <div id='container'>
      <div id='left'>
		    <ul id="menu">
            <li <?php echo menu_selected('dashboard', 2).menu_selected('', 2); ?>>
              <?php echo anchor('admin/dashboard', 'Dashboard'); ?>   
          	</li>
            <li <?php echo menu_selected('pages', 2); ?>>
              <a href ="#">Pages</a>                     
              <ul>
                  <li><a href="#" title="" <?php echo menu_selected('pages', 2); ?>>View Pages</a></li>
                  <li><a href="#" title="" <?php echo menu_selected('pages', 2); ?>>Create Page</a></li>
              </ul>  
          	</li>
            <li>
              <a href ="#">Modules</a>
          	</li>
            <li <?php echo menu_selected('design', 2); ?>>
              <a href="<?php echo get_url(); ?>/admin/design/navigation" title="">Design</a>
              <ul>
                  <li><a href="<?php echo get_url(); ?>/admin/design/navigation" title="" <?php echo menu_selected('navigation', 3); ?>>Navigation</a></li>
              </ul>  
            </li>
            <li>
              <a href ="#">Users</a></li>
            <li>
            	<a href ="#">Settings</a>            	
            </li>                  
        </ul> <!-- end #menu -->       

      </div> <!-- end #left -->
      <div id='main'>
        <div id='content-wrapper'  >
          <table id='content'>
            <tbody>
              <tr>   
                <td id='col-mid'>
                    <div id='messages-layer'></div>
                    <?php echo $this->template->get_content() ?>
            		</td> 
              </tr>
            </tbody> <!-- end tbody#content -->
          </table> <!-- end table#content -->
        </div><!-- div#content-wrapper -->
      </div><!-- div#main -->
    </div><!-- end#container -->
    <?php Assets::js('jquery'); ?>
    <?php Assets::js('jquery-ui'); ?> 
    <?php Assets::js('main'); ?>
    <?php (isset($js) AND ! empty($js)) ? Assets::js($js) : '';?>
    <?php echo Assets::show_js(); ?>
 	</body>
</html>