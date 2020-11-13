<?php

namespace common\modules\profile\controllers;

use Yii;
use common\models\User;
use common\models\UserSearch;
use common\modules\order\models\Order;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\data\Pagination;
use common\modules\profile\models\UpdateFrontendUser;
use yii\web\UploadedFile;
use yii\helpers\Url;


/**
 * FrontendProfileController implements the CRUD actions for User model.
 */
class FrontendProfileController extends Controller
{   
    public $layout = 'profile';
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => [],
                'rules' => [
                    [
                        'actions' => ['index','view','delete-image','delete','update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
                'denyCallback' => function ($rule, $action) 
                {   
                    return $this->redirect(Url::home());
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
        $user = Yii::$app->user->identity;

        $query = Order::find()->where(['author_id' => $user->id]);
        
        $pagination = new Pagination([
            'totalCount' => $query->count(),
            'pageSize' => 4,
        ]);

        $orders = $query->offset($pagination->offset)
        ->limit($pagination->limit)
        ->orderBy([
            'created_at' =>  SORT_DESC,
        ])
        ->all();

        $this->view->title = $user->getUsername();

        return $this->render('index',[
            'orders' => $orders,
            'user' => $user,
            'pagination' => $pagination
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
        return $this->render('view', [
            'model' => $this->findModel($id),
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $update = new UpdateFrontendUser($model);

        if(Yii::$app->request->isPost)
        {
            if($update->load(Yii::$app->request->post()))
            {
                $image = UploadedFile::getInstance($update,'image');

                if($update->saveUser($image))
                {   
                    Yii::$app->session->setFlash('success','Профиль успешно обновлён');

                    return $this->redirect(['/profile/my/']);
                }
            }
        }

        $this->view->title = 'Изменить профиль '.$model->getUsername();

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

        return $this->redirect(['/profile/my']);
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
