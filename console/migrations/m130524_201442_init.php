<?php

use yii\db\Migration;

class m130524_201442_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        //crate user table (without password)
        $this->createTable('{{%user}}', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull()->unique()
        ], $tableOptions);
        
        
        // create table transfer to store transactions
        $this->createTable('transfer', [
            'id' => $this->primaryKey(),
            'dt' => $this->integer()->notNull(),
            'from_user_id' => $this->integer()->notNull(),
            'to_user_id' => $this->integer()->notNull(),
            'amount' => $this->decimal(10,2)->defaultValue(0)
        ], $tableOptions);
        
        
        // add foriegn key to table user
        $this->addForeignKey(
            'fk-transfer-from_user_id',
            'transfer',
            'from_user_id',
            'user',
            'id',
            'CASCADE'
        );
        
        
        // add foriegn key to table user
        $this->addForeignKey(
            'fk-transfer-to_user_id',
            'transfer',
            'to_user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('transfer');
        $this->dropTable('{{%user}}');
    }
}
