<?php

namespace app\commands;

use app\forms\BookForm;
use Yii;
use yii\console\Controller;
use app\services\BookManager;

class ParsingController extends Controller
{
    private BookManager $manager;

    public function __construct($id, $module, BookManager $manager, $config = [])
    {
        parent::__construct($id, $module, $config);
        $this->manager = $manager;
    }

    public function actionIndex()
    {
        $jsonData = file_get_contents('https://gitlab.grokhotov.ru/hr/yii-test-vacancy/-/raw/master/books.json');
        $booksJson = json_decode($jsonData, true);
        $bookForm = new BookForm();
        foreach ($booksJson as $bookJson) {
            $bookForm->load($bookJson, '');
            echo 'Parsing book isbn - ' . $bookForm->isbn. PHP_EOL;
            $this->manager->add($bookForm);
            try {
                $this->manager->save($bookForm);
            } catch (\Exception $exception) {
                $this->stdout('Error saving book '. $bookForm->isbn);
            }
        }
    }
}