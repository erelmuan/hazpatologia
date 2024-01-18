<?php
    namespace app\controllers;
    use yii\rest\ActiveController;
    use Yii;
    use app\models\Biopsia;
    use yii\web\NotFoundHttpException;
    use yii\filters\auth\HttpBearerAuth;

  class BiopsiarestController extends  \yii\rest\ActiveController
    {
      // behaviors heredado
public $modelClass='app\models\BiopsiaSearch';



      public function behaviors() {
             $behaviors = parent::behaviors();
             $behaviors['authenticator'] = [
                'class' => HttpBearerAuth::className(),
              // 'except' => ['informe', 'index'], // no necesitan autenticacion
              'except' => ['accion1', 'accion2'], // no necesitan autenticacion (son accion ficticias)
             ];
             return $behaviors;
      }

      public function actionInforme($id)
      {
        $biopsia = $this->findModel($id);
        return $this->render('/biopsia/informePatologia', ['model' => $biopsia ]);
      }
      protected function findModel($id) {
          if (($model = Biopsia::findOne($id)) !== null) {
              return $model;
          }
          else {
              throw new NotFoundHttpException('The requested page does not exist.');
          }
      }
     // public function actions()
     // {
     //     $actions = parent::actions();
     //     $actions['index']['dataFilter'] = [
     //         'class' => \yii\data\ActiveDataFilter::class,
     //         'searchModel' => $this->modelClass,
     //     ];
     //     return $actions;
     // }


}
