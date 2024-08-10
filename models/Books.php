<?php

namespace app\models;

use app\forms\BookForm;
use Yii;
use yii\db\ActiveQuery;

/**
 * This is the model class for table "books".
 *
 * @property int $id
 * @property string $title
 * @property string $isbn
 * @property int|null $pageCount
 * @property int|null $publishedDate
 * @property string|null $thumbnailUrl
 * @property string|null $shortDescription
 * @property string|null $longDescription
 * @property int|null $status
 * @property int|null $author_id
 * @property int|null $category_id
 *
 * @property Authors $author
 * @property Categories $category
 */
class Books extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 10;
    const STATUS_DRAFT = 0;
    const STATUS_DELETED = 9;

    public static function tableName()
    {
        return 'books';
    }

    public function rules()
    {
        return [
            [['title', 'isbn'], 'required'],
            [['pageCount', 'publishedDate', 'status', 'author_id', 'category_id'], 'integer'],
            [['longDescription', 'shortDescription','title', 'isbn', 'thumbnailUrl'], 'string'],
            [['thumbnailUrl', 'isbn'], 'unique'],
            [['author_id'], 'exist', 'skipOnError' => true, 'targetClass' => Authors::class, 'targetAttribute' => ['author_id' => 'id']],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Categories::class, 'targetAttribute' => ['category_id' => 'id']],
        ];
    }


    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'isbn' => 'Isbn',
            'pageCount' => 'Page Count',
            'publishedDate' => 'Published Date',
            'thumbnailUrl' => 'Thumbnail Url',
            'shortDescription' => 'Short Description',
            'longDescription' => 'Long Description',
            'status' => 'Status',
            'author_id' => 'Author ID',
            'category_id' => 'Category ID',
        ];
    }

    public static function create(BookForm $bookForm): self
    {
        $model = new static();
        $model->title = $bookForm->title;
        $model->isbn = $bookForm->isbn;
        $model->pageCount = $bookForm->pageCount;
        $model->publishedDate = $bookForm->publishedDate;
        $model->thumbnailUrl = $bookForm->thumbnailUrl;
        $model->shortDescription = $bookForm->shortDescription;
        $model->longDescription = $bookForm->longDescription;
        $model->status = self::STATUS_ACTIVE;
//        $model->author_id = $bookForm->author_id;
//        $model->category_id = $bookForm->category_id;

        return $model;
    }

    public function getAuthor(): ActiveQuery
    {
        return $this->hasOne(Authors::class, ['id' => 'author_id']);
    }


    public function getCategory(): ActiveQuery
    {
        return $this->hasOne(Categories::class, ['id' => 'category_id']);
    }
}
