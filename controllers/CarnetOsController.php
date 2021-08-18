<?php

namespace app\controllers;

use Yii;
use app\models\CarnetOs;
use app\models\CarnetOsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * CarnetOsController implements the CRUD actions for CarnetOs model.
 */
class CarnetOsController extends Controller
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
     * Lists all CarnetOs models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new CarnetOsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single CarnetOs model.
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

    /**
     * Creates a new CarnetOs model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new CarnetOs();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        return $this->render('create', [
            'model' => $model,
        ]);
    }

    public function createParametros($id_paciente,$obraSocial ,$nroAfiliado)
    {   $i=1;
        $arrayCarnet=[];
      foreach ($obraSocial as $value1) {
          $arrayCarnet['obrasocial'.$i]=$value1;
          $i=$i+1;
      }
        $j=1;
      foreach ($nroAfiliado as $value2) {
          $arrayCarnet['afiliado'.$j]=$value2;
          $j=$j+1;
      }
      for ($z=1; $z < $i; $z++) {
        if ($modelCarnetOs = new CarnetOs()) {
            $modelCarnetOs->id_obrasocial = $arrayCarnet['obrasocial'.$z];
            $modelCarnetOs->id_paciente = $id_paciente;
            $modelCarnetOs->nroafiliado = $arrayCarnet['afiliado'.$z];
            if (!$modelCarnetOs->save()) {
                $lerror = true;
                break;
            }
        } else {
            $lerror = true;
                break;
            }
       }
    }
    public function updateParametros($id_paciente,$obraSocial ,$nroAfiliado)
    {
      $models=CarnetOsController::findidpacModel($id_paciente);
        if ($models == null && !empty($obraSocial))
            CarnetOsController::createParametros($id_paciente,$obraSocial ,$nroAfiliado);
            //Mejorar porque siempre elimino aun no habiendo modificacion
        elseif ($models!==null){
            foreach ($models as $key => $value) {
                CarnetOsController::findModel($value->id)->delete();
            }
            if (!empty($obraSocial))
              CarnetOsController::createParametros($id_paciente,$obraSocial ,$nroAfiliado);
        }

    }


    /**
     * Updates an existing CarnetOs model.
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
     * Deletes an existing CarnetOs model.
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
     * Finds the CarnetOs model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return CarnetOs the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = CarnetOs::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }

    public function findidpacModel($id_paciente)
    {
        if (($model = CarnetOs::Find()->where(['id_paciente' =>$id_paciente])->all()) !== null) {
            return $model;
        }
        throw new NotFoundHttpException(Yii::t('app', 'The requested page does not exist.'));
    }




}
