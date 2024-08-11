<?php

namespace app\services;

use app\models\Authors;
use RuntimeException;

class AuthorManager
{
    public function parse($name): int
    {
        $author = Authors::findOne(['name' => $name]);
        if ($author) {
            return $author->id;
        }
        $model = Authors::create($name);
        $author = $this->save($model);
        return $author->id;
    }

    public function save(Authors $author): Authors | \Exception
    {
        if (!$author->validate() || !$author->save()) {
            throw new RuntimeException('Error saving author.');
        }

        return $author;
    }
}