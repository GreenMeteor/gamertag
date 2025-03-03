<?php

use yii\db\Migration;

/**
 * Migration for the GamerTag module
 */
class m230228_584738_gamertag extends Migration
{
    public function up()
    {
        $this->createTable('gamertag', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'platform' => $this->string(50)->notNull(),
            'gamertag' => $this->string(64)->notNull(),
            'visibility' => $this->string(10)->notNull()->defaultValue('members'),
            'created_at' => $this->dateTime()->notNull(),
            'created_by' => $this->integer()->notNull(),
            'updated_at' => $this->dateTime(),
            'updated_by' => $this->integer(),
        ]);

        // Add indexes
        $this->createIndex('idx-gamertag-user_id', 'gamertag', 'user_id');
        $this->createIndex('idx-gamertag-platform', 'gamertag', 'platform');
        $this->createIndex('idx-gamertag-visibility', 'gamertag', 'visibility');
        
        // Add foreign key to user table
        $this->addForeignKey(
            'fk-gamertag-user_id',
            'gamertag',
            'user_id',
            'user',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropTable('gamertag');
    }
}