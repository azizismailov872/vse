<?php 

namespace common\modules\auth\controllers;

use Yii;
use common\modules\auth\models\PasswordResetRequestForm;
use common\modules\auth\models\ResetPasswordForm;
use common\modules\auth\models\forms\LoginForm;
use common\modules\auth\models\forms\RegisterForm;
use common\modules\profile\models\User;
use yii\web\Controller;
use yii\widgets\ActiveForm;

class AuthController extends Controller 
{   
    public $layout = '@frontend/themes/vse/views/layouts/login';

	public function actionRegister()
    {	
    	if(!Yii::$app->user->isGuest)
    	{
    		Yii::$app->session->setFlash('error', 'Вы уже зарегестрированы !');
    		return $this->goHome();
    	}
    	
        $model = new RegisterForm();

    	$this->view->title = 'Регистрация';
        
        if(Yii::$app->request->isPost)
        {
            if($model->register(Yii::$app->request))
            {
                return $this->redirect(['/']);
            }
        }

    	return $this->render('register',[
            'model' => $model,
        ]);
    }

    public function actionLogin()
    {   
        $model = new LoginForm();

        if(!Yii::$app->user->isGuest)
        {   
            Yii::$app->session->setFlash('error', 'Вы уже зарегестрированы !');
            return $this->goHome();
        }

        if($model->load(Yii::$app->request->post()) && $model->validate())
        {   
            if($model->login())
            {   
                Yii::$app->session->setFlash('success','Вы успешно авторизованы');
                return $this->goHome();
            }
        }

        $this->view->title = 'Вход';

        return $this->render('login',[
            'model' => $model,
        ]);
    }

    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /*
    * Сброс пароля
    */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Письмо с ссылкой для восстановления пароля отправлено вам на почту!');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Извините но мы не может отправить вам ссылку востановления пароля');
            }
        }
        $this->view->title = 'Восстановление пароля - шаг 1';

        return $this->render('requestPasswordReset', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Пароль успешно изменен !');

            return $this->goHome();
        }
        $this->view->title = 'Восстановление пароля - шаг 2';
        
        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }
}