<h2>Navigation</h2>
<div class="box">      
	<div class="box-container">   
		<?php echo anchor('#', 'New Item', array('class' => 'button align-right', 'id' => 'new-item')); ?>
		<?php echo clear_fix(); ?>
		<br>
		<div class="hidden" id="menu-new-item">
			<?php echo form_open('', array('class' => 'content-forms')); ?>
				<ul style='background:#f7f7f7;border:1px solid #e5e5e5'>
					<li> 
						<?php echo form_label('titulo', 'Titulo'); ?>
						<?php echo form_input(array('name' => 'titulo')); ?>
					</li>
					<li> 
						<?php echo form_label('uri', 'Uri'); ?>
						<?php echo form_input(array('name' => 'uri')); ?>
					</li>
					<li> 
						<?php echo form_button('Save', array('type' => 'submit', 'class' => 'button')); ?>
						<?php echo anchor('#', 'Cancel', array('id' => 'cancel-new-item', 'class' => 'button')) ?>
					</li>
				</ul>
			<?php echo form_close(); ?>
		</div>
		<h3>Main Menu</h3>
		<br>
		<?php echo form_open(); ?>                    
			<ul id="" class="navigation">
				<li>Dashboard<span class="ui-icon ui-icon-arrow-4-diag align-right"></span></li>
				<li>Pages<span class="ui-icon ui-icon-arrow-4-diag align-right"></span></li>
				<li>Modules<span class="ui-icon ui-icon-arrow-4-diag align-right"></span></li>
				<li>Design<span class="ui-icon ui-icon-arrow-4-diag align-right"></span></li>
				<li>Users<span class="ui-icon ui-icon-arrow-4-diag align-right"></span></li>
				<li>Settings<span class="ui-icon ui-icon-arrow-4-diag align-right"></span></li>
			</ul>
			<?php echo form_button('Save', array('class' => 'button positive')); ?> 
		<?php echo form_close(); ?>
	</div>
</div>

<style>
.navigation {width:100%;}
.navigation li {padding:10px;border:1px solid #e5e5e5;margin-bottom:10px;height:14px}
.navigation .ui-icon {background-image: url(<?php echo base_url(); ?>images/ui-icons_666666_256x240.png);}
</style>