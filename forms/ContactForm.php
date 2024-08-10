<?php

namespace app\forms;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public string $name = '';
    public string $email = '';
    public string $message = '';
    public string $phone = '';
    public $verifyCode;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'message'], 'required'],
            ['email', 'email'],
            ['name', 'string', 'min' => 2, 'max' => 60],
            [['phone'], 'string' , 'max' => 20],
            [['message'], 'string' , 'max' => 2048],
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'email' => 'Email',
            'phone' => 'Phone',
            'message' => 'Message',
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     * @param ContactForm $form the target email address
     * @return bool whether the model passes validation
     */
    public function sendMessage(ContactForm $form): bool
    {
        Yii::$app->mailer->compose()
            ->setTo(Yii::$app->params['senderEmail'])
            ->setFrom([$form->email => $form->name])
            ->setSubject('New contact from ContactForm')
            ->setTextBody($form->message)
            ->send();

        return true;
    }
}
