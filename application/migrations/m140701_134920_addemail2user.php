<?php

class m140701_134920_addemail2user extends CDbMigration
{
	public function up()
	{
		$this->addColumn(
                '{{user}}',
                array(
                    // Entities.
                    
                    'email'         => 'VARCHAR(255)    NOT NULL    UNIQUE          COMMENT "The email address of the user used to register within the system. This is the primary credential for the user, used for authentication."',
                    
                ),
                implode(' ', array(
                    'ENGINE          = InnoDB',
                    'DEFAULT CHARSET = utf8',
                    'COLLATE         = utf8_general_ci',
                    'COMMENT         = "The user definitions and credentials of the staff members using this system."',
                    'AUTO_INCREMENT  = 1',
                ))
            );
	}

	public function down()
	{
		echo "m140701_134920_addemail2user does not support migration down.\n";
		return false;
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