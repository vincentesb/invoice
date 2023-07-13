<?php

use app\models\Invoice;
use app\models\InvoiceDetail;
use app\models\User;
use yii\db\Migration;
use yii\db\mysql\Schema;

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
        // Use the `esb` database
        $this->db->createCommand("USE `esb`;")->execute();

        // Create the `invoice` table
        if ($this->db->getTableSchema(Invoice::tableName(), true) === null) {
            $this->createTable('invoice', [
                'id' => Schema::TYPE_PK . ' NOT NULL AUTO_INCREMENT',
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
        }

        // Create the `invoice_detail` table
        if ($this->db->getTableSchema(InvoiceDetail::tableName(), true) === null) {
            $this->createTable('invoice_detail', [
                'id' => Schema::TYPE_PK . ' NOT NULL AUTO_INCREMENT',
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
        }

        // Create the `user` table
        if ($this->db->getTableSchema(User::tableName(), true) === null) {
            $this->createTable('user', [
                'id' => Schema::TYPE_PK . ' NOT NULL AUTO_INCREMENT',
                'username' => $this->string(45)->notNull(),
                'address' => $this->text()->notNull(),
                'flag_active' => $this->integer(),
                'created_at' => $this->dateTime()->notNull()->defaultExpression('CURRENT_TIMESTAMP'),
                'updated_at' => $this->dateTime(),
                'deleted_at' => $this->dateTime(),
            ]);
        }
        // insert base user data
        $this->batchInsert('user', ['username', 'address', 'flag_active', 'created_at'], [
            ['dummy_1', 'Jl. Gading Serpong Raya no 31 blok IV', 1, '2023-06-22 08:39:57'],
            ['dummy_2', 'Jl Tangerang Raya no 22', 0, '2023-06-22 08:39:57'],
            ['dummy_3', 'Jl Kelapa dua raya no 15', 1, '2023-06-22 08:39:57'],
        ]);
    }

    public function down()
    {
        // Drop the `user` table
        $this->dropTable('user');

        // Drop the `invoice_detail` table
        $this->dropTable('invoice_detail');

        // Drop the `invoice` table
        $this->dropTable('invoice');

        // Drop the `esb` database
        $this->db->createCommand("DROP DATABASE IF EXISTS `esb`;")->execute();

        return false;
    }
}
