<?php

namespace app\controllers;

use app\components\EmployeeList;
use app\models\ComponentGroup;
use app\models\ComponentGroupSearch;
use Yii;
use app\models\ComponentPayroll;
use app\models\ComponentPayrollSearch;
use app\models\PeriodSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ComponentpayrollController implements the CRUD actions for ComponentPayroll model.
 */
class ComponentpayrollController extends Controller
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
     * Lists all ComponentPayroll models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ComponentPayrollSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ComponentPayroll model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        $groupSearch = New ComponentGroupSearch();
        $groupProvider = $groupSearch->search(Yii::$app->request->queryParams);
        return $this->render('view', [
            'model' => $this->findModel($id),
            'groupProvider'=>$groupProvider,
            'groupSearch'=>$groupSearch,
        ]);
    }

    /**
     * Creates a new ComponentPayroll model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ComponentPayroll();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ComponentPayroll model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ComponentPayroll model.
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

    public function actionComponentgroup($id_group){
        $group = New ComponentGroup();
        $emp = EmployeeList::getEmployeeActive();
        $group->id = $group->getLastId();
        $group->id_component_payroll= $id_group;
        if ($group->load(Yii::$app->request->post())){
            if ($group->save()){
                $this->redirect(['view','id'=>$group->id_component_payroll]);
            }
        }
        return $this->render('_groupadd', [
            'model'=>$group,
            'emp'=>$emp,

        ]);
    }

    public function actionDeletegroup($id){
        $model = ComponentGroup::findOne($id);
        $id_componen_payroll = $model->id_component_payroll;
        $model->delete();
        return $this->redirect(['view', 'id'=>$id_componen_payroll]);
    }

    /**
     * Finds the ComponentPayroll model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ComponentPayroll the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ComponentPayroll::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
