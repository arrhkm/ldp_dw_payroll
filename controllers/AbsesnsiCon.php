<?php

namespace app\controllers;

use Yii;
use app\models\Absensi;
use app\models\AbsensiSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * AbsesnsiController implements the CRUD actions for Absensi model.
 */
class AbsesnsiController extends Controller
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
     * Lists all Absensi models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new AbsensiSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Absensi model.
     * @param string $tgl
     * @param string $emp_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($tgl, $emp_id)
    {
        return $this->render('view', [
            'model' => $this->findModel($tgl, $emp_id),
        ]);
    }

    /**
     * Creates a new Absensi model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Absensi();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'tgl' => $model->tgl, 'emp_id' => $model->emp_id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Absensi model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param string $tgl
     * @param string $emp_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($tgl, $emp_id)
    {
        $model = $this->findModel($tgl, $emp_id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'tgl' => $model->tgl, 'emp_id' => $model->emp_id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Absensi model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param string $tgl
     * @param string $emp_id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($tgl, $emp_id)
    {
        $this->findModel($tgl, $emp_id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Absensi model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param string $tgl
     * @param string $emp_id
     * @return Absensi the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($tgl, $emp_id)
    {
        if (($model = Absensi::findOne(['tgl' => $tgl, 'emp_id' => $emp_id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
