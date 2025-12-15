<?php
declare(strict_types=1);

namespace frontend\controllers;

use yii\web\Controller;

class HelpController extends Controller
{
    public function actionAccountSetting(): string
    {
        return $this->render('account-setting');
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }

    public function actionLoginAndSecurity(): string
    {
        return $this->render('login-and-security');
    }

    public function actionPrivacy(): string
    {
        return $this->render('privacy');
    }

}
