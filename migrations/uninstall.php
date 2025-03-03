<?php

use yii\db\Migration;

/**
 * Uninstall script for the gamertag module
 */
class uninstall extends Migration
{
    public function up()
    {
        $this->dropTable('gamertag');

        return true;
    }
}
