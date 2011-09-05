<?php

class Migration_Create_Table_users extends Migration {
    
    function up()
    {
        $this->forge->add_field("id");
	$this->forge->add_field("username varchar(20)  NOT NULL");
	$this->forge->add_field("first_name varchar(20)  NOT NULL");
	$this->forge->add_field("last_name varchar(20)  NOT NULL");
	$this->forge->add_field("password varchar(20)  NOT NULL");
	$this->forge->add_field("email varchar(20)  NOT NULL");
	$this->forge->add_field("active tinyint(1) NOT NULL DEFAULT '1'");
	$this->forge->add_field("id_profile int(11) NOT NULL");
	$this->forge->add_field("uid int(11) NOT NULL");
        $this->forge->add_key('active');
	$this->forge->add_key('uid');

        $this->forge->create_table('users', TRUE);
    }

    function down()
    {
        $this->forge->drop_table('users');
    }

}