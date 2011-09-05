<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="robots" content="noindex,nofollow" />
<title><?php echo Template::getInstance()->get_title(); ?></title>

    <?php 
        Assets::css('reset');
        Assets::css('style');
    ?>    
    <!--[if IE 6]>
    <link rel="stylesheet" href="<?php echo base_url()?>css/ie.css" type="text/css" />
    <![endif]-->  
    <style>
        .error-titulo{text-transform:uppercase;background:#000;color:#fff;padding:10px;font-weight:bolder;}
        .error-contenido{padding:10px;}
    </style>  
</head>

<body>
<!--[if IE 7]>
   <div style='height:auto !important'>
<![endif]-->  
    <div id="container">

    <div id="content">
            <div id="mid-col" style="margin:auto;float:none;width:555px">
      

        <div class="box">      
        <div class="box-container">
            <p class='error-titulo'>404, página no encontrada</p>
            <p class="paragraph error-contenido">
                La página solicitada no ha sido encontrada. Verifique la dirección URL, probablemente está mal escrita
                o no existe.
                <br>
                <br>
                <br>
                <?php echo anchor('', 'Volver al inicio.', array('class' => 'align-right'))?>
                <?php echo clear_fix(); ?>
            </p>
        </div><!-- end of div.box-container -->
        </div><!-- end of div.box -->
        
    
      
      </div><!-- end of div#mid-col -->
          <span class="clearFix">&nbsp;</span>     
    </div><!-- end of div#content -->
    </div><!-- end of #container -->

    </div>
<!--[if IE 7]>
   </div>
<![endif]-->  

</body>
</html>
 
