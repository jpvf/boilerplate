<div class="box col-4">
    <div class="box-container">
        <?php echo Form::open('users/save', array('class' => 'content-forms inline')); ?>
            <ul>
                <li>
                                        <?php echo Form::label('Username', 'username'); ?>
                                        <?php echo Form::text(array('name' => 'username', 'id' => 'username')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('First Name', 'first_name'); ?>
                                        <?php echo Form::text(array('name' => 'first_name', 'id' => 'first_name')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Last Name', 'last_name'); ?>
                                        <?php echo Form::text(array('name' => 'last_name', 'id' => 'last_name')); ?>
                                    </li>
	<li>
                                    <?php echo Form::label('Password', 'password'); ?>
                                    <?php echo Form::password(array('name' => 'password', 'id' => 'password')); ?>
                                </li>
	<li>
                                        <?php echo Form::label('Email', 'email'); ?>
                                        <?php echo Form::text(array('name' => 'email', 'id' => 'email')); ?>
                                    </li>
	<li>
                                        <?php echo Form::label('Profile', 'id_profile'); ?>
                                        <?php echo Form::select($options,'',array('name' => 'id_profile', 'id' => 'id_profile')); ?>
                                    </li>
                <li>
                    <?php echo Form::button('Guardar', array('class' => 'button','type' => 'submit')) ?>
                </li>
            </ul>
        <?php echo Form::close(); ?>
    </div>
</div>