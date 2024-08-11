<?php
namespace app\services;

use app\forms\BookForm;
use app\models\Books;
use RuntimeException;
use Yii;

class BookManager
{
    private AuthorManager $authorManager;
    private CategoryManager $categoryManager;

    public function __construct(AuthorManager $authorManager, CategoryManager $categoryManager)
    {
        $this->authorManager = $authorManager;
        $this->categoryManager = $categoryManager;
    }

    public function parse(BookForm $bookForm): void
    {
        if (!$this->checkIsset($bookForm->isbn)){
            $authors = $this->getAuthors($bookForm);
            $categories = $this->getCategories($bookForm);
            $book = Books::create($bookForm);
            $book->authors = $authors;
            $book->categories = $categories;
            $this->save($book);
        }
    }

    public function checkIsset($isbn): bool
    {
        if (Books::findOne(['isbn' => $isbn])) {
            return true;
        }
        return false;
    }

    public function save(Books $book): Books | \Exception
    {
        if (!$book->validate() || !$book->save()) {
            throw new RuntimeException('Error saving book.');
            //var_dump($book->getErrors());
        }

        return $book;
    }

    private function getAuthors (BookForm $bookForm): array
    {
        $idsAuthor = [];
        $authors = $bookForm->authors;
        if (is_array($authors)) {
            foreach ($authors as $author) {
                if ($author !== '') {
                    $idsAuthor[] = $this->authorManager->parse($author);
                }
            }
        }
        return $idsAuthor;
    }

    private function getCategories (BookForm $bookForm): array
    {
        $idsCategories = [];
        $categories = $bookForm->categories;
        if (is_array($categories) && !empty($categories)) {
            foreach ($categories as $category) {
                if ($category !== '') {
                    $idsCategories[] = $this->categoryManager->parse($category);
                }
            }
        } elseif (empty($categories)) {
            $idsCategories[] = 1;
        }
        return $idsCategories;
    }

    public function upload($model)
    {
        $currentFile = Yii::getAlias('@webroot'). '/images/books/'. $model->thumbnailUrl;
        if ($model->validate() && $model->file) {
            if (file_exists($currentFile)  && !empty($currentFile)) {
                unlink($currentFile);
            }
            $path = Yii::getAlias('@webroot'). '/images/books/'. $model->file->baseName . '.' . $model->file->extension;
            $model->file->saveAs($path);
            $model->updateAttributes(['thumbnailUrl' => $model->file->baseName . '.' . $model->file->extension]);
            $model->file = null;
        } else {
            return false;
        }
    }
}