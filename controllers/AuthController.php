<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\User;
use app\models\LoginForm;
use app\models\SignupForm;

class AuthController extends Controller
{
	
	/**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            // return $this->goBack();
            if (Yii::$app->user->getIdentity()->isAdmin) {
                return $this->redirect(['/admin']);
            } else {
                return $this->goBack();
            }
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();

        if (Yii::$app->request->isPost) {
            $model->load(Yii::$app->request->post());

            if ($model->signup()) {
                return $this->redirect(['auth/login']);
            }
        }

        return $this->render('signup', ['signup' => $model]);
    }

    public function actionTest()
    {
    	$user = User::findOne(1);
  
    	// Yii::$app->user->login($user);
    	Yii::$app->user->logout();

    	if (Yii::$app->user->isGuest) {
    		echo 'Guest';
    	} else {
    		echo 'Admin';
    		
    	}
    	
    }
}