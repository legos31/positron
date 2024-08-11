<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property int $id
 * @property string $name
 *
 * @property Books[] $books
 * @property BooksAuthorsAssign[] $booksAuthorsAssigns
 */
class Authors extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'authors';
    }


    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    public static function create($name): self
    {
        $model = new static();
        $model->name = $name;
        return $model;
    }


    public function getBooks()
    {
        return $this->hasMany(Books::class, ['id' => 'book_id'])->viaTable('books_authors_assign', ['author_id' => 'id']);
    }


    public function getBooksAuthorsAssigns()
    {
        return $this->hasMany(BooksAuthorsAssign::class, ['author_id' => 'id']);
    }
}
