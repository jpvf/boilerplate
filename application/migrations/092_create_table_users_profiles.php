<?php

class Migration_Create_Table_users_profiles extends Migration {
    
    function up()
    {
        $this->forge->add_field("id");
	$this->forge->add_field("name varchar(20)  NOT NULL");
	$this->forge->add_field("active tinyint(1) NOT NULL DEFAULT '1'");
        $this->forge->add_key('active');

        $this->forge->create_table('users_profiles', TRUE);
    }

    function down()
    {
        $this->forge->drop_table('users_profiles');
    }

}