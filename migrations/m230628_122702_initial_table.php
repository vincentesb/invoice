<?php

use yii\db\Migration;

/**
 * Class m230628_122702_initial_table
 */
class m230628_122702_initial_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        // Create database if not exists
        $this->db->createCommand("CREATE DATABASE IF NOT EXISTS `esb` /*!40100 DEFAULT CHARACTER SET latin1 */;")->execute();

        // Use the `esb` database
        $this->db->createCommand("USE `esb`;")->execute();

        // Create the `invoice` table
        $this->createTable('invoice', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer(),
            'issue_date' => $this->date(),
            'due_date' => $this->date(),
            'subject' => $this->string(50),
            'subtotal' => $this->integer(),
            'tax' => $this->integer(),
            'payments' => $this->integer(),
            'amount_due' => $this->integer(),
            'customer_name' => $this->string(45),
            'detail_address' => $this->text(),
            'status' => $this->string(20),
            'flag_active' => $this->integer()->defaultValue(1),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        // Create the `invoice_detail` table
        $this->createTable('invoice_detail', [
            'id' => $this->primaryKey(),
            'invoice_id' => $this->integer()->notNull(),
            'item_type' => $this->string(20),
            'description' => $this->string(100),
            'quantity' => $this->integer(),
            'unit_price' => $this->integer(),
            'amount' => $this->integer(),
            'flag_active' => $this->integer()->defaultValue(1),
            'created_at' => $this->dateTime()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);

        // Create the `user` table
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string(45)->notNull(),
            'address' => $this->text()->notNull(),
            'flag_active' => $this->tinyInteger(),
            'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
            'updated_at' => $this->dateTime(),
            'deleted_at' => $this->dateTime(),
        ]);
        // insert base user data
        $this->batchInsert('user', ['id', 'username', 'address', 'flag_active', 'created_at'], [
            [1, 'vincent', 'Jl. Gading Serpong Raya no 31 blok IV', 1, '2023-06-22 08:39:57'],
            [2, 'test', 'Jl Tangerang Raya no 22', 0, '2023-06-22 08:39:57'],
            [3, 'kent', 'Jl Kelapa dua raya no 15', 1, '2023-06-22 08:39:57'],
            [4, 'test', 'jalan testing 123', 0, '2023-06-28 19:30:34'],
        ]);
    }

    public function down()
    {
        // Drop the `user` table
        $this->dropTable('user');

        // Drop the `item` table
        $this->dropTable('item');

        // Drop the `invoice_detail` table
        $this->dropTable('invoice_detail');

        // Drop the `invoice` table
        $this->dropTable('invoice');

        // Drop the `esb` database
        $this->db->createCommand("DROP DATABASE IF EXISTS `esb`;")->execute();

        return false;
    }
}
