<?php

namespace app\models;

use app\forms\BookForm;
use lhs\Yii2SaveRelationsBehavior\SaveRelationsBehavior;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

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
 *
 * @property Authors[] $authors
 * @property BooksAuthorsAssign[] $booksAuthorsAssigns
 * @property BooksCategoryAssign[] $booksCategoryAssigns
 * @property Categories[] $categories
 */
class Books extends \yii\db\ActiveRecord
{
    public $file;
    const STATUS_ACTIVE = 10;
    const STATUS_DRAFT = 0;

    public static function tableName()
    {
        return 'books';
    }


    public function rules()
    {
        return [
            [['title', 'isbn'], 'required'],
            [['pageCount', 'publishedDate', 'status'], 'integer'],
            [['shortDescription', 'longDescription'], 'string'],
            [['title', 'isbn', 'thumbnailUrl'], 'string', 'max' => 255],
            [['file'], 'file', 'extensions' => 'png, jpg, jpeg', 'maxSize' => 1024 * 1024],
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
        ];
    }

    public function behaviors(): array
    {
        return [

            [
                'class' => SaveRelationsBehavior::class,
                'relations' => ['authors', 'categories'],
            ],
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

        return $model;
    }


    public function getAuthors()
    {
        return $this->hasMany(Authors::class, ['id' => 'author_id'])->viaTable('books_authors_assign', ['book_id' => 'id']);
    }


    public function getBooksAuthorsAssigns()
    {
        return $this->hasMany(BooksAuthorsAssign::class, ['book_id' => 'id']);
    }


    public function getBooksCategoryAssigns()
    {
        return $this->hasMany(BooksCategoryAssign::class, ['book_id' => 'id']);
    }


    public function getCategories()
    {
        return $this->hasMany(Categories::class, ['id' => 'category_id'])->viaTable('books_category_assign', ['book_id' => 'id']);
    }

//    public function afterSave($insert, $changedAttributes)
//    {
//        parent::afterSave($insert, $changedAttributes);
//        $bookCategoryAssign = $this->booksCategoryAssigns;
//        if (is_array($bookCategoryAssign)) {
//            $bookCategoryAssign[0]->updateAttributes(['parent' => 1]);
//        }
//    }

    public function getStatusLabel($status)
    {
        switch ($status) {
            case self::STATUS_DRAFT:
                $class = 'badge bg-secondary';
                break;
            case self::STATUS_ACTIVE:
                $class = 'badge bg-success';
                break;
            default:
                $class = 'badge bg-primary';
        }

        return Html::tag('span', ArrayHelper::getValue(self::getStatusesList(), $status), [
            'class' => $class,
        ]);
    }

    public function getStatusesList(): array
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_DRAFT => 'Draft',
        ];
    }
}
