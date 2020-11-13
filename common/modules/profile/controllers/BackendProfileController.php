<?php

namespace common\modules\profile\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use common\modules\profile\models\CreateUser;
use common\modules\profile\models\PlusBalance;
use common\modules\profile\models\UpdateUser;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;
/**
 * BackendProfileController implements the CRUD actions for User model.
 */
class BackendProfileController extends Controller
{   
    public $layout = 'dashboard';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['index','create','update','view','delete','delete-ajax','delete-image','balance'],
                        'allow' => true,
                        'roles' => ['admin','editor'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) 
                {   
                    throw new NotFoundHttpException('У вас нет прав для этого действия');
                }
            ],
        ];
    }

    public function beforeAction($action) 
    { 
        Yii::$app->controller->enableCsrfValidation = false;

        return parent::beforeAction($action); 
    }

    /**
     * Lists all User models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new UserSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $this->view->title = 'Пользователи';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {       
        $model = $this->findModel($id);

        $this->view->title = (!empty($model->username)) ? $model->username : $model->email;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateUser();
        
        if($model->load(Yii::$app->request->post()))
        {
            $image = UploadedFile::getInstance($model,'image');

            if($model->createUser($image))
            {
                return $this->redirect(['/users']);
            }

        }

        $this->view->title = 'Создать пользователя';

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $update = new UpdateUser($model);

        if(Yii::$app->request->isPost)
        {
            if($update->load(Yii::$app->request->post()))
            {
                $image = UploadedFile::getInstance($update,'image');

                if($update->saveUser($image))
                {
                    return $this->redirect(['/user/view/'.$model->id]);
                }
            }
        }

        $this->view->title = 'Изменить пользователя '.$model->getUsername();

        return $this->render('update', [
            'model' => $model,
            'update' => $update
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionDeleteAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        $msg = 'Ошибка ! Пользовтель не удален';

        $result = false;

        if($request->isAjax)
        {   

            $post = $request->post();

            $id = (!empty($post['id'])) ? $post['id'] : 0;

            if($id > 0)
            {   
                $model = $this->findModel($id);
                //Delete data in model
                if($model->delete())
                {
                    $result = true;
                    $msg = 'Пользователь удален';
                }
            }
        }

        return ['result' => $result,'msg' => $msg];
    }

    public function actionBalance()
    {
        $model = new PlusBalance();

        $this->view->title = 'Пополнить баланс';

        if(Yii::$app->request->isPost)
        {
            if($model->load(Yii::$app->request->post()))
            {
                if($model->plusBalance())
                {
                    Yii::$app->session->setFlash('success','Баланс пополнен');

                    return $this->redirect(['/user/view/'.Yii::$app->user->getId()]);
                }
            }
        }

        return $this->render('plus-balance',[
            'model' => $model,
        ]);
    }


    public function actionDeleteImage()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        $msg = 'Ошибка ! Изображение не удалено';

        $result = false;

        if($request->isAjax)
        {   
            $post = $request->post();

            $id = (!empty($post['id'])) ? $post['id'] : 0;

            if($id > 0)
            {   
                $model = $this->findModel($id);
                //Delete data in model
                if($model->photo !== 'default.png')
                {
                    if($model->deleteImage())
                    {   
                        $model->photo = 'default.png';
                        
                        if($model->save())
                        {
                            $result = true;
                            $msg = 'Изображение удалено';
                        }
                        
                    }
                }
                else
                {
                    $result = true;

                    $msg = 'Изображение удалено';
                }
            }
        }

        return ['result' => $result,'msg' => $msg];

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
