<?php

class Migration_Create_Table_users_permissions extends Migration {
    
    function up()
    {
        $this->forge->add_field("id");
	$this->forge->add_field("id_user int(11) NOT NULL");
	$this->forge->add_field("id_resource int(11) NOT NULL");
	$this->forge->add_field("allowed tinyint(1) NOT NULL");
        $this->forge->add_key('id_user');
	$this->forge->add_key('id_resource');

        $this->forge->create_table('users_permissions', TRUE);
    }

    function down()
    {
        $this->forge->drop_table('users_permissions');
    }

}