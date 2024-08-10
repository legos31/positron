<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%books}}`.
 */
class m240810_063049_create_books_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%books}}', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'isbn' => $this->string()->notNull(),
            'pageCount' => $this->integer(),
            'publishedDate' => $this->integer(),
            'thumbnailUrl' => $this->string(),
            'shortDescription' => $this->text(),
            'longDescription' =>  $this->text(),
            'status' => $this->integer(),
            'author_id' => $this->integer(),
            'category_id' => $this->integer(),
        ]);

        $this->createIndex('{{%idx-books-title}}', '{{%books}}', 'title');
        $this->createIndex('{{%idx-books-isbn}}', '{{%books}}', 'isbn');
        $this->createIndex('{{%idx-books-status}}', '{{%books}}', 'status');
        $this->createIndex('{{%idx-books-author_id}}', '{{%books}}', 'author_id');

        $this->addForeignKey('{{%fk-books-author_id}}', '{{%books}}', 'author_id', '{{%authors}}', 'id');
        $this->addForeignKey('{{%fk-books-category_id}}', '{{%books}}', 'category_id', '{{%categories}}', 'id');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%books}}');
    }
}
