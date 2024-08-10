<?php

namespace app\models;

use app\forms\ContactForm;
use Yii;

/**
 * This is the model class for table "contact_form".
 *
 * @property int $id
 * @property string|null $name
 * @property string $email
 * @property string|null $phone
 * @property string $message
 */
class Contacts extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contacts';
    }


    public static function create(ContactForm $contactForm): self
    {
        $model = new static();
        $model->name = $contactForm->name;
        $model->email = $contactForm->email;
        $model->message = $contactForm->message;
        $model->phone = $contactForm->phone;

        return $model;
    }
}
