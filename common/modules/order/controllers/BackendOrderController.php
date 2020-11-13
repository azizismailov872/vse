<?php

namespace common\modules\order\controllers;

use Yii;
use common\modules\order\models\Order;
use common\modules\order\models\search\OrderSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use common\modules\order\models\Category;
use yii\filters\AccessControl;

/**
 * BackendOrderController implements the CRUD actions for Order model.
 */
class BackendOrderController extends Controller
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
                        'actions' => ['index','create','update','view','delete','delete-ajax'],
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $usersList = Order::getUsersList();

        $categoriesList = Category::getCategoriesList();

        $this->view->title = 'Заказы';
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'usersList' => $usersList,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);

        $this->view->title = 'Заказ №'.$model->id;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Order();

        $categoriesList = Category::getCategoriesList();
        
        $phoneValue = (!empty(Yii::$app->user->identity->phone)) ? Yii::$app->user->identity->phone : '';

        if ($model->load(Yii::$app->request->post()) && $model->save()) 
        {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->view->title = 'Создать заказ';
        
        return $this->render('create', [
            'model' => $model,
            'categoriesList' => $categoriesList,
            'phoneValue' => $phoneValue,
        ]);
    }

    public function actionDeleteAjax()
    {
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->request;

        $msg = 'Ошибка ! Заказ не удален';

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
                    $msg = 'Заказ успешно удален';
                }
            }
        }

        return ['result' => $result,'msg' => $msg];
    }

    /**
     * Updates an existing Order model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $categoriesList = Category::getCategoriesList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/order/view/'.$model->id]);
        }

        $this->view->title = 'Изменить заказ №'.$model->id;

        return $this->render('update', [
            'model' => $model,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * Deletes an existing Order model.
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

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
