<?php

namespace app\services;

use app\models\Categories;
use RuntimeException;

class CategoryManager
{
    public function parse($name): int
    {
        $category = Categories::findOne(['name' => $name]);
        if ($category) {
            return $category->id;
        }
        $model = Categories::create($name);
        $category = $this->save($model);
        return $category->id;
    }

    public function save(Categories $categories): Categories | \Exception
    {
        if (!$categories->validate() || !$categories->save()) {
            throw new RuntimeException('Error saving category.');
        }

        return $categories;
    }
}