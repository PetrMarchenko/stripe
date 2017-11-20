<?php

use yii\db\Migration;

class m171117_162600_stripe extends Migration
{
    public function up()
    {
        $this->createTable('stripe', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer()->notNull(),
            'user_id' => $this->integer(),
            'status' => $this->integer()->notNull(),
            'stripe_id' => $this->integer()->notNull(),
            'currency' => $this->string(255)->notNull(),
            'description' => $this->string(255)->notNull(),
            'source' => $this->string(255)->notNull(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    public function down()
    {
        $this->dropTable('stripe');
    }
}
