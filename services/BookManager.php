<?php
namespace app\services;

use app\forms\BookForm;
use app\models\Books;
use RuntimeException;

class BookManager
{
    public function add(BookForm $bookForm): void
    {
        if (!$this->checkIsset($bookForm->isbn)){
            $this->save($bookForm);
        }
    }

    public function checkIsset($isbn): bool
    {
        if (Books::findOne(['isbn' => $isbn])) {
            return true;
        }
        return false;
    }

    public function save(BookForm $bookForm): Books | \Exception
    {
        $book = Books::create($bookForm);
        if (!$book->validate() || !$book->save()) {
            return new RuntimeException('Error saving book.');
        }

        return $book;
    }
}