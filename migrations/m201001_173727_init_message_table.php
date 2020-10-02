<?php

use yii\db\Migration;

/**
 * Class m201001_173727_init_message_table
 */
class m201001_173727_init_message_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%message}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'message' => $this->text()->notNull(),
            'date' => $this->dateTime()->notNull(),
            'status' => $this->string()->notNull()->defaultValue('approved'),
        ]);

        $this->addForeignKey('fk-message-user_id', '{{%message}}', 'user_id', '{{%user}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%message}}');
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m201001_173727_init_message_table cannot be reverted.\n";

        return false;
    }
    */
}
