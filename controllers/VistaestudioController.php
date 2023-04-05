<?php
    namespace app\controllers;
    use yii\rest\ActiveController;
    use Yii;
    class VistaestudioController extends ActiveController
    {
      // https://localhost/hazpatologia/web/vistaestudios?filter[id_estudio_modelo]=12851

      public $modelClass='app\models\Viewestudio';

     //  public function actions()
     // {
     //   $actions = parent::actions();
     //   //$actions['index']['prepareDataProvider'] = [$this, 'prepareDataProvider'];
     //   return $actions;
     // }
     public function actions()
     {
         $actions = parent::actions();

         $actions['index']['dataFilter'] = [
             'class' => \yii\data\ActiveDataFilter::class,
             'searchModel' => $this->modelClass,
         ];

         return $actions;
     }

     // $requestParams = \Yii::$app->getRequest()->getBodyParams(); // [1]
     // if (empty($requestParams)) {
     //     $requestParams = \Yii::$app->getRequest()->getQueryParams(); // [2]
     // }

     // $dataFilter = new \yii\data\ActiveDataFilter([
     //     'searchModel' => ViewestudioSearch::class // [3]
     // ]);
     // if ($dataFilter->load($requestParams)) {
     //     $filter = $dataFilter->build(); // [4]
     //     if ($filter === false) { // [5]
     //         return $dataFilter;
     //     }
     // }

     // $query = Viewestudio::find();
     // if (!empty($filter)) {
     //     $query->andWhere($filter); // [6]
     // }

     // return new \yii\data\ActiveDataProvider([
     //     'query' => $query,
     //     'pagination' => [
     //         'params' => $requestParams,
     //     ],
     //     'sort' => [
     //         'params' => $requestParams,
     //     ],
     // ]); // [7]






    }
?>
