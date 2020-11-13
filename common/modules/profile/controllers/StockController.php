<?php 

namespace common\modules\profile\controllers;

use Yii;
use common\modules\profile\models\Stock;
use common\modules\profile\models\search\StockSearch;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;


class StockController extends Controller
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
                        'actions' => ['index','delete','create','update'],
                        'allow' => true,
                        'roles' => ['admin','editor'],
                    ],
                   
                ],
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
    	$searchModel = new StockSearch();

    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    	$this->view->title = 'Акции';

    	return $this->render('index',[
    		'searchModel' => $searchModel,
    		'dataProvider' => $dataProvider,
    	]);
    }

    public function actionCreate()
    {
        $model = new Stock();

        if(Yii::$app->request->isPost)
        {
            if($model->load(Yii::$app->request->post()))
            {
                if($model->save())
                {   
                    return $this->redirect(['/stocks']);
                }
            }
        }

        $this->view->title = 'Создать Акцию';

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $this->view->title = 'Изменить акцию'.$model->title;

        if(Yii::$app->request->isPost)
        {
            if($model->load(Yii::$app->request->post()))
            {
                if($model->save())
                {
                    return $this->redirect(['/stocks']);
                }
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionDelete()
    {   
        \Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

        $request = Yii::$app->getRequest();

        $msg = 'Запись не удалена';

        $result = false;

        if($request->isAjax)
        {
            $post = Yii::$app->request->post();
            
            $id = (!empty($post['id'])) ? $post['id'] : 0;

            if($id > 0)
            {   
                $model = $this->findModel($id);
               
                //Delete data in model
                if($model->delete())
                {
                    $result = true;
                    $msg = 'Запись удалена';
                }
            }
        }
        return ['result' => $result,'msg' => $msg];
    }

    protected function findModel($id)
    {
        if (($model = Stock::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('form', 'The requested page does not exist.'));
    }
}
