<?php

use yii\db\Migration;

class m171117_162600_stripe extends Migration
{
    public function up()
    {
        $this->createTable('stripe', [
            'id' => $this->primaryKey(),
            'amount' => $this->integer()->notNull(),
            'status' => $this->string(25)->notNull(),
            'stripe_id' => $this->string(255)->notNull(),
            'type' => $this->integer(2)->notNull(),
            'updated_at' => $this->dateTime(),
        ]);

    }

    public function down()
    {
        $this->dropTable('stripe');
    }
}
