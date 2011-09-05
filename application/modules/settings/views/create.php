<div class="box col-4">
    <div class="box-container">
        <?php echo Form::open('admin/settings/save', array('class' => 'content-forms inline')); ?>
            <ul>
                <li>
                                        <?php echo Form::label('Setting', 'setting'); ?>
                                        <?php echo Form::text(array('name' => 'setting', 'id' => 'setting')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Title', 'title'); ?>
                                        <?php echo Form::text(array('name' => 'title', 'id' => 'title')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Type', 'type'); ?>
                                        <?php echo Form::text(array('name' => 'type', 'id' => 'type')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Default', 'default'); ?>
                                        <?php echo Form::text(array('name' => 'default', 'id' => 'default')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Value', 'value'); ?>
                                        <?php echo Form::text(array('name' => 'value', 'id' => 'value')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Options', 'options'); ?>
                                        <?php echo Form::text(array('name' => 'options', 'id' => 'options')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Is Required', 'is_required'); ?>
                                        <?php echo Form::text(array('name' => 'is_required', 'id' => 'is_required')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Module', 'module'); ?>
                                        <?php echo Form::text(array('name' => 'module', 'id' => 'module')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Order', 'order'); ?>
                                        <?php echo Form::text(array('name' => 'order', 'id' => 'order')); ?>
                                    </li>
                <li>
                    <?php echo Form::button('Guardar', array('class' => 'button','type' => 'submit')) ?>
                </li>
            </ul>
        <?php echo Form::close(); ?>
    </div>
</div>