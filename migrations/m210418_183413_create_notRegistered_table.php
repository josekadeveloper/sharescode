<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%notRegistered}}`.
 */
class m210418_183413_create_notRegistered_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%notRegistered}}', [
            'id' => $this->bigInteger(),
            'created_at' => $this->timestamp(0)->defaultExpression('LOCALTIMESTAMP'),
            'token' => $this->string(255),
        ]);

        $this->addPrimaryKey('pk_notRegistered', 'notRegistered', 'id');
        $this->addForeignKey(
            'fk_notRegistered_portrait',
            'notRegistered',
            'id',
            'portrait',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropPrimaryKey('pk_notRegistered', 'notRegistered', 'id');
        $this->dropForeignKey('fk_notRegistered_portrait', 'notRegistered');
        $this->dropTable('{{%notRegistered}}');
    }
}
