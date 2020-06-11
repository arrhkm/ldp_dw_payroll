<?php

namespace app\controllers;

use Yii;
use app\models\Kartu;
use app\models\KartuSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * KartuController implements the CRUD actions for Kartu model.
 */
class KartuController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Kartu models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new KartuSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Kartu model.
     * @param integer $no_kartu
     * @param string $emp_number_kartu
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($no_kartu, $emp_number_kartu)
    {
        return $this->render('view', [
            'model' => $this->findModel($no_kartu, $emp_number_kartu),
        ]);
    }

    /**
     * Creates a new Kartu model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Kartu();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'no_kartu' => $model->no_kartu, 'emp_number_kartu' => $model->emp_number_kartu]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Kartu model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $no_kartu
     * @param string $emp_number_kartu
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($no_kartu, $emp_number_kartu)
    {
        $model = $this->findModel($no_kartu, $emp_number_kartu);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'no_kartu' => $model->no_kartu, 'emp_number_kartu' => $model->emp_number_kartu]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Kartu model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $no_kartu
     * @param string $emp_number_kartu
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($no_kartu, $emp_number_kartu)
    {
        $this->findModel($no_kartu, $emp_number_kartu)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Kartu model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $no_kartu
     * @param string $emp_number_kartu
     * @return Kartu the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($no_kartu, $emp_number_kartu)
    {
        if (($model = Kartu::findOne(['no_kartu' => $no_kartu, 'emp_number_kartu' => $emp_number_kartu])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
