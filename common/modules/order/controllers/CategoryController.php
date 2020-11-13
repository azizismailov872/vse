<?php

namespace common\modules\order\controllers;

use Yii;
use common\modules\order\models\Category;
use common\modules\order\models\search\CategorySearch;
use common\modules\order\models\forms\CreateCategory;
use common\modules\order\models\forms\UpdateCategory;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\UploadedFile;

/**
 * CategoryController implements the CRUD actions for Category model.
 */
class CategoryController extends Controller
{       
    public $layout = 'dashboard';
    /**
     * {@inheritdoc}
     */
   /* public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }*/

    public function beforeAction($action) 
    { 
        Yii::$app->controller->enableCsrfValidation = false;
         
        return parent::beforeAction($action); 
    }

    /**
     * Lists all Category models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CategorySearch();
        
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        
        $this->view->title = 'Категории';
        
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Category model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {   
        $model = $this->findModel($id);

        $this->view->title = $model->title;

        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CreateCategory();

        if($model->load(Yii::$app->request->post())) 
        {   
            $image = UploadedFile::getInstance($model,'image');

            if($model->createCategory($image))
            {
                return $this->redirect(['/categories']);
            }
        }

        $this->view->title = 'Создать категорию';

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Category model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $update = new UpdateCategory($model);

        if($update->load(Yii::$app->request->post())) 
        {
            $image = UploadedFile::getInstance($update,'image');

            if($update->saveCategory($image))
            {
                return $this->redirect(['/category/view/'.$model->id]);
            }
        }
        $this->view->title = 'Изменить '.$model->title;

        return $this->render('update', [
            'model' => $model,
            'update' => $update,
        ]);
    }

    /**
     * Deletes an existing Category model.
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

        $msg = 'Ошибка ! категория не удалена';

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
                    $msg = 'Категория удалена';
                }
            }
        }

        return ['result' => $result,'msg' => $msg];
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
                if($model->background !== 'main-bg.jpg')
                {
                    if($model->deleteImage())
                    {   
                        $model->background = 'main-bg.jpg';
                        
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
     * Finds the Category model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
