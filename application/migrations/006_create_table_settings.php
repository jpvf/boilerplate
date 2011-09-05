<?php

class Migration_Create_Table_settings extends Migration {
    
    function up()
    {
        $this->forge->add_field("id");
	$this->forge->add_field("setting varchar(20)  NOT NULL");
	$this->forge->add_field("title varchar(20)  NOT NULL");
	$this->forge->add_field("type varchar(20)  NOT NULL");
	$this->forge->add_field("default text NOT NULL");
	$this->forge->add_field("value text NOT NULL");
	$this->forge->add_field("options text NOT NULL");
	$this->forge->add_field("is_required tinyint(1) NOT NULL DEFAULT '0'");
	$this->forge->add_field("module int(11) NOT NULL DEFAULT '0'");
	$this->forge->add_field("order int(11) NOT NULL DEFAULT '0'");
        $this->forge->add_key('title');

        $this->forge->create_table('settings', TRUE);
    }

    function down()
    {
        $this->forge->drop_table('settings');
    }

}