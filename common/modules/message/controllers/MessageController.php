<?php

namespace common\modules\message\controllers;

use Yii;
use common\modules\message\models\Message;
use common\modules\message\models\forms\WriteMessage;
use common\modules\message\models\search\MessageSearch;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;
use yii\helpers\Url;

/**
 * MessageController implements the CRUD actions for Message model.
 */
class MessageController extends Controller
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
                        'actions' => ['index','view','delete-image','delete','update','send-message'],
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

    public function actionIndex()
    {
        $user = Yii::$app->user->identity;

        $inboxQuery = Message::find()->where(['reciver_id' => $user->id]);

        $inboxPagination = new Pagination([
            'totalCount' =>  $inboxQuery->count(),
            'pageSize' => 5,
        ]);

        $inboxMessages = $inboxQuery->offset($inboxPagination->offset)
        ->limit($inboxPagination->limit)
        ->orderBy([
            'created_at' =>  SORT_DESC,
        ])
        ->all();

        $outboxQuery = Message::find()->where(['author_id' => $user->id]);

        $outboxPagination = new Pagination([
            'totalCount' => $outboxQuery->count(),
            'pageSize' => 5,
        ]);

        $outboxMessages = $outboxQuery->offset($outboxPagination->offset)
        ->limit($outboxPagination->limit)
        ->orderBy([
            'created_at' =>  SORT_DESC,
        ])
        ->all();

        $this->view->title = 'Сообщения';

        return $this->render('index',[
            'inboxMessages' => $inboxMessages,
            'inboxPagination' => $inboxPagination,
            'outboxMessages' => $outboxMessages,
            'outboxPagination' => $outboxPagination,
            'user' => $user,
        ]);
    }


    public function actionView($id)
    {   
        $model = $this->findModel($id);

        $author = $model->author;

        $message = new WriteMessage();

        $this->view->title = 'Сообщение для '.$model->reciver->getUsername();

        return $this->render('view', [
            'model' => $model,
            'author' => $author,
            'message' => $message,
        ]);
    }

    public function actionSendMessage()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        
        $request = \Yii::$app->getRequest();

        $result = false;

        $msg = 'Сообщение не было отправлено';

        if($request->isAjax)
        {
            $post = Yii::$app->request->post();
           
            //Get model
            $model = new WriteMessage();
            
            //Validate data
            if($model->load(Yii::$app->request->post()))
            {   
                //Save data in modele
                if($model->sendMessage(Yii::$app->user->getId()))
                {      
                    $result = true;

                    $msg = 'Сообщение отправлено';
                }
            }
        }

        return ['result' => $result, 'msg' => $msg];
        
    }

    public function actionValidate()
    {
        if(Yii::$app->request->isAjax) 
        {
            $model = new WriteMessage();

            if($model->load(Yii::$app->request->post()))
            {   
                Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

                return ActiveForm::validate($model);
            }
        }

        throw new \yii\web\BadRequestHttpException('Bad request!'); 
    }


    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    protected function findModel($id)
    {
        if (($model = Message::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
