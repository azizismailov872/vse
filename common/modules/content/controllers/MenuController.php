<?php

namespace common\modules\content\controllers;

use Yii;
use common\modules\content\models\Menu;
use common\modules\content\models\search\MenuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\AccessControl;

/**
 * MenuController implements the CRUD actions for Menu model.
 */
class MenuController extends Controller
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
     * Lists all Menu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MenuSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->pagination->pageSize = 10;

        $categoriesList  = Menu::getCategoriesList();

        $menuList = Menu::getMenuList();

        $this->view->title = 'Меню';

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoriesList' => $categoriesList,
            'menuList' => $menuList,
        ]);
    }

    /**
     * Displays a single Menu model.
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
     * Creates a new Menu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Menu();

        $menuCategoriesList = Menu::getCategoriesList();

        $menusList = Menu::getMenuList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/menu/view/'.$model->id]);
        }

        $this->view->title = 'Cоздать меню';

        return $this->render('create', [
            'model' => $model,
            'menusList' => $menusList,
            'menuCategoriesList' => $menuCategoriesList
        ]);
    }

    /**
     * Updates an existing Menu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $menuCategoriesList = Menu::getCategoriesList();

        $menusList = Menu::getMenuList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        $this->view->title = 'Изменить '.$model->title;
        return $this->render('update', [
            'model' => $model,
            'menusList' => $menusList,
            'menuCategoriesList' => $menuCategoriesList
        ]);
    }

    /**
     * Deletes an existing Menu model.
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

        $msg = 'Ошибка ! Меню не удалено';

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
                    $msg = 'Меню удалено';
                }
            }
        }

        return ['result' => $result,'msg' => $msg];
    }

    /**
     * Finds the Menu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Menu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Menu::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
