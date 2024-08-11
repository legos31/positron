<?php

use yii\db\Migration;

/**
 * Class m240810_185953_create_books_categories_assign
 */
class m240810_185953_create_books_categories_assign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_category_assign}}', [
            'book_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-books_category_assign}}', '{{%books_category_assign}}', ['book_id', 'category_id']);

        $this->createIndex('{{%idx-books_category_assign-book_id}}', '{{%books_category_assign}}', 'book_id');
        $this->createIndex('{{%idx-books_category_assign-category_id}}', '{{%books_category_assign}}', 'category_id');

        $this->addForeignKey('{{%fk-books_category_assign-book_id}}', '{{%books_category_assign}}', 'book_id', '{{%books}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-books_category_assign-category_id}}', '{{%books_category_assign}}', 'category_id', '{{%categories}}', 'id', 'CASCADE', 'RESTRICT');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {

    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m240810_185953_create_books_categories_assign cannot be reverted.\n";

        return false;
    }
    */
}
