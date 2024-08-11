<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "categories".
 *
 * @property int $id
 * @property string $name
 * @property integer $parent_id
 * @property Books[] $books
 * @property BooksCategoryAssign[] $booksCategoryAssigns
 */
class Categories extends \yii\db\ActiveRecord
{

    public static function tableName()
    {
        return 'categories';
    }


    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['parent_id'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'parent_id' => 'Parent ID'
        ];
    }

    public static function create($name, $parent = null): self
    {
        $model = new static();
        $model->name = $name;
        $model->parent_id = $parent;
        return $model;
    }

    public function getBooks()
    {
        return $this->hasMany(Books::class, ['id' => 'book_id'])->viaTable('books_category_assign', ['category_id' => 'id']);
    }


    public function getBooksCategoryAssigns()
    {
        return $this->hasMany(BooksCategoryAssign::class, ['category_id' => 'id']);
    }

    public function getParent()
    {
        return $this->hasOne(Categories::class, ['id' => 'parent_id']);
    }

    // Связь для дочерних категорий
    public function getChildren()
    {
        return $this->hasMany(Categories::class, ['parent_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(!$insert) {
                if($this->id != $this->parent_id) {
                    return true;
                } else {
                    $this->addError('parent_id', 'parent_id must not equal id');
                    return false;
                }
            } else {
                return true;
            }

        }
        $this->addError('parent_id', 'error saving category');
        return false;
    }
}
