<?php

namespace app\controllers;

use app\components\EmployeeList;

use app\models\ComponentGroup;
use app\models\ComponentGroupSearch;
use Yii;
use app\models\ComponentPayroll;
use app\models\ComponentPayrollSearch;
use app\models\ModelFormComponentGroup;
use app\models\PayrollGroup;
use app\models\PeriodSearch;
use yii\db\Connection;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

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
                    //'removegroup'=>['POST'],
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

    public function getEmployeeNotInGroup($id_group){
        $groups=[];
        foreach (ComponentGroup::find()->where(['id_component_payroll'=>$id_group])->all() as $group){
            array_push($groups, $group->id_employee);
        }
        $emp_list = [];
        
        foreach (EmployeeList::getEmployeeActive() as $key=>$value){
            if ($key != $groups){
                array_push($emp_list, ['id'=>$key, 'name'=>$value]);                
            }
        }       
        $x = ArrayHelper::map($emp_list, 'id', 'name');
        return $x;

    }

    public function actionComponentgroup($id_group){
        //$group = New ComponentGroup();
        $group = New ModelFormComponentGroup();
        
        /*$groups=[];
        foreach (ComponentGroup::find()->where(['id_component_payroll'=>$id_group])->all() as $group){
            array_push($groups, $group->id_employee);
        }*/

        $emp = $this->getEmployeeNotInGroup($id_group);
        //$emp = EmployeeList::getEmployeeActive();

        
        $group->id_component_payroll= $id_group;
        if ($group->load(Yii::$app->request->post())){

            foreach ($group->id_employee as $id_emp){
                if (ComponentGroup::find()->where(['id_employee'=>$id_emp])->exists()){
                    $ComponentGroup = ComponentGroup::findOne(['id_employee'=>$id_emp]);
                    //$ComponentGroup->id = $group->getLastId();
                    /*$ComponentGroup->start_date = $group->start_date;
                    $ComponentGroup->end_date = $group->end_date;
                    $ComponentGroup->id_component_payroll = $id_group;
                    $ComponentGroup->id_employee = $id_emp;
                    */
                }else {
                    $ComponentGroup = New ComponentGroup;
                    $ComponentGroup->id = $ComponentGroup->getLastId();                  
                    $ComponentGroup->start_date = $group->start_date;
                    $ComponentGroup->end_date = $group->end_date;
                    $ComponentGroup->id_component_payroll = $id_group;
                    $ComponentGroup->id_employee = $id_emp;
                    $ComponentGroup->save();
                }
            }
            //if ($group->save()){
            $this->redirect(['view','id'=>$group->id_component_payroll]);
            //}
        }
        return $this->render('_groupadd', [
            'model'=>$group,
            'emp'=>$emp,
            //'group'=>$groups,

        ]);
    }

    public function actionDeletegroup($id){
        $model = ComponentGroup::findOne($id);
        $id_componen_payroll = $model->id_component_payroll;
        $model->delete();
        return $this->redirect(['view', 'id'=>$id_componen_payroll]);
    }

    public function actionUpdateselect() {
      
        $data = Yii::$app->request->post();
        //var_dump($data);
        //$id_payroll_group = $data['id'];
        //$id_groups = $data['id_group'];
       foreach ($data['id_group'] as $id_groups) {
           

            $x = PayrollGroup::find()->where(['id'=>$id_groups])->one();
            $x->end_date = '2020-01-1';
            $x->save();
            
        }
        return $this->redirect(['componentpayroll/view', 'id'=>$data['id']]);
    }

    public function actionDeleteselect(){
        $data = Yii::$app->request->post();
        
        $id =$data['id'];
        $item = $data['item'];
        foreach ($item as $items){
            $ws = ComponentGroup::findOne($items);                        
            $ws->delete();
        }
        return $this->redirect(['view','id'=>$id]);
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
