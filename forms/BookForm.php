<?php

namespace app\forms;

use app\models\Authors;
use app\models\Categories;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;

class BookForm extends Model
{
    public $_publishedDate;
    public $_thumbnailUrl;
    public $title;
    public $isbn;
    public $pageCount;
    public $shortDescription;
    public $longDescription;
    public $status;
    public $authors;
    public $categories;



    public function rules()
    {
        return [
            [['title', 'isbn'], 'required'],
            [['title', 'isbn','pageCount', 'publishedDate', 'status', 'authors', 'categories', 'longDescription', 'thumbnailUrl', 'shortDescription'], 'string'],
        ];
    }

    public function setPublishedDate($arrDate)
    {
        $this->_publishedDate = ArrayHelper::getValue($arrDate, '$date');
    }

    public function getPublishedDate(): int|false
    {
        return strtotime($this->_publishedDate);
    }

    public function setThumbnailUrl($url)
    {
        $imageName = $this->isbn . '-'. basename($url);
        $savePath = Yii::getAlias('@uploads') . '/books/' .$imageName;

        $imageData = file_get_contents($url);
        if ($imageData === false) {
            echo 'Не удалось загрузить изображение.';
        } else {
            $success = file_put_contents($savePath, $imageData);
            if ($success === false) {
                $this->_thumbnailUrl = null;
                echo 'Не удалось сохранить изображение на сервер.';
            } else {
                $this->_thumbnailUrl = $imageName;
            }
        }
    }

    public function getThumbnailUrl(): string|null
    {
        return $this->_thumbnailUrl;
    }
}