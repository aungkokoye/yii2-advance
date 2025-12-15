<?php
declare(strict_types=1);

namespace frontend\controllers;

use yii\web\Controller;

class BlogController extends Controller
{
    public function actionHowToUseGii(): string
    {
        return $this->render('how-to-use-gii');
    }

    public function actionIAmStartingABlog(): string
    {
        return $this->render('i-am-starting-a-blog');
    }

    public function actionIndex(): string
    {
        return $this->render('index');
    }

}
