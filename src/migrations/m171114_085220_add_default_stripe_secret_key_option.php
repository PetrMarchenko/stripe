<?php

use yii\db\Migration;

class m171114_085220_add_default_stripe_secret_key_option extends Migration
{
    public function up()
    {
        $this->insert('options', [
            'namespace' => 'stripe',
            'key' => 'secretKey',
            'value' => 'sk_test_TpDfy0lzGjN0fOy2og38jdHm',
            'description' => 'Default stripe`s secret_key',
        ]);
    }

    public function down()
    {
        $this->delete('options', ['namespace' => 'stripe', 'key' => 'secretKey']);
    }
}
