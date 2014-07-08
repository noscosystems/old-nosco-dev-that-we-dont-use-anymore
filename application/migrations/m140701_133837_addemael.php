<?php

class m140701_133837_addemael extends CDbMigration
{
	public function up()
	{
		
		$this->addColumn('{{user}}', 'email', 'VARCHAR(255)    NOT NULL    UNIQUE          COMMENT "The email address of the user used to register within the system. This is the primary credential for the user, used for authentication."');
	}

	public function down()
	{
		//$this->dropColumn('{{user}}', 'email');
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}