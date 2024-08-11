<?php

use yii\db\Migration;

/**
 * Class m240810_185913_create_books_authors_assign
 */
class m240810_185913_create_books_authors_assign extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books_authors_assign}}', [
            'book_id' => $this->integer()->notNull(),
            'author_id' => $this->integer()->notNull(),
        ]);

        $this->addPrimaryKey('{{%pk-books_authors_assign}}', '{{%books_authors_assign}}', ['book_id', 'author_id']);

        $this->createIndex('{{%idx-books_authors_assign-book_id}}', '{{%books_authors_assign}}', 'book_id');
        $this->createIndex('{{%idx-books_authors_assign-author_id}}', '{{%books_authors_assign}}', 'author_id');

        $this->addForeignKey('{{%fk-books_authors_assign-book_id}}', '{{%books_authors_assign}}', 'book_id', '{{%books}}', 'id', 'CASCADE', 'RESTRICT');
        $this->addForeignKey('{{%fk-books_authors_assign-author_id}}', '{{%books_authors_assign}}', 'author_id', '{{%authors}}', 'id', 'CASCADE', 'RESTRICT');
    }


    public function safeDown()
    {
        $this->dropTable('{{%books_authors_assign}}');
    }

}
