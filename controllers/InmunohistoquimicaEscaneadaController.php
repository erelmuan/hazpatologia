<?php
namespace app\controllers;
use Yii;
use app\models\InmunohistoquimicaEscaneada;
use app\models\InmunohistoquimicaEscaneadaSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use \yii\web\Response;
use yii\helpers\Html;
use app\models\Solicitud;
use yii\web\UploadedFile;
/**
 * InmunohistoquimicaEscaneadaController implements the CRUD actions for InmunohistoquimicaEscaneada model.
 */
class InmunohistoquimicaEscaneadaController extends Controller {
    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ['verbs' => ['class' => VerbFilter::className() , 'actions' => ['delete' => ['post'], 'bulk-delete' => ['post'], ], ], ];
    }
    /**
     * Lists all InmunohistoquimicaEscaneada models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new InmunohistoquimicaEscaneadaSearch();
        $dataProvider = $searchModel->search(Yii::$app
            ->request
            ->queryParams);
        return $this->render('index', ['searchModel' => $searchModel, 'dataProvider' => $dataProvider, ]);
    }
    /**
     * Displays a single InmunohistoquimicaEscaneada model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        $request = Yii::$app->request;
        if ($request->isAjax) {
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            return ['title' => "InmunohistoquimicaEscaneada #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    /**
     * Creates a new InmunohistoquimicaEscaneada model.
     * For ajax request will return json object
     * and for non-ajax request if creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($id_biopsia) {
        $request = Yii::$app->request;
        $model = new InmunohistoquimicaEscaneada();
        $model->id_biopsia = $id_biopsia;
        if ($request->isAjax) {
            /*
             *   Process for ajax request
            */
            Yii::$app
                ->response->format = Response::FORMAT_JSON;
            if ($request->isGet) {
                return ['title' => "Create new InmunohistoquimicaEscaneada", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
            else if ($model->load($request->post()) && $model->save()) {
                return ['forceReload' => '#crud-datatable-pjax', 'title' => "Create new InmunohistoquimicaEscaneada", 'content' => '<span class="text-success">Create InmunohistoquimicaEscaneada success</span>', 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Create More', ['create'], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
            }
            else {
                return ['title' => "Create new InmunohistoquimicaEscaneada", 'content' => $this->renderAjax('create', ['model' => $model, ]) , 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::button('Save', ['class' => 'btn btn-primary', 'type' => "submit"]) ];
            }
        }
        else {
            /*
             *   Process for non-ajax request
            */
            if ($model->load(Yii::$app
                ->request
                ->post())) {
                // $image = UploadedFile::getInstances($model, 'imagen')[0];
                // unset($post['Firma']['imagen']);
                $file = UploadedFile::getInstances($model, 'documento') [0];;
                // store the source file name
                $ext = (explode(".", $file->name));
                $ext = end($ext);
                // $ext = end((explode(".", $file->name)));
                Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/inmunohistoquimicas/';
                $nombreEncriptadoImagen = Yii::$app
                    ->security
                    ->generateRandomString() . ".{$ext}";
                $path = Yii::$app->params['uploadPath'] . '/' . $nombreEncriptadoImagen;
                $model->documento = $nombreEncriptadoImagen;
                $file->saveAs($path);
                if ($model->save()) {
                    return $this->redirect(['biopsia/view', 'id' => $model->id_biopsia]);
                }
                else {
                    return $this->render('create', ['model' => $model, 'edadDelPaciente' => Solicitud::calcular_edad($model
                        ->biopsia
                        ->id_solicitudbiopsia) ]);
                }
            }
            else {
                return $this->render('create', ['model' => $model, 'edadDelPaciente' => Solicitud::calcular_edad($model
                    ->biopsia
                    ->id_solicitudbiopsia) ]);
            }
        }
    }
    /**
     * Updates an existing InmunohistoquimicaEscaneada model.
     * For ajax request will return json object
     * and for non-ajax request if update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id) {
        $request = Yii::$app->request;
        $model = $this->findModel($id);
        if ($this
            ->request
            ->isPost) {
            $post = $request->post();
            //verificar porque hay que agregar el indice [0] a diferencia cuando se sube una imagen de perfil
            $file = UploadedFile::getInstance($model, 'documento');
            if (empty($file)) {
                unset($post['InmunohistoquimicaEscaneada']['documento']);
            }
            if ($model->load($post)) {
                if (!is_null($file) && !empty($file) && $file->name != "") {
                    // $file = UploadedFile::getInstances($model, 'documento')[0];
                    // store the source file name
                    $ext = (explode(".", $file->name));
                    $ext = end($ext);
                    // $ext = end((explode(".", $file->name)));
                    Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/web/uploads/inmunohistoquimicas/';
                    $nombreEncriptadoImagen = Yii::$app
                        ->security
                        ->generateRandomString() . ".{$ext}";
                    $path = Yii::$app->params['uploadPath'] . '/' . $nombreEncriptadoImagen;
                    $model->documento = $nombreEncriptadoImagen;
                    $file->saveAs($path);
                }
                if ($model->save()) {
                    return $this->redirect(['biopsia/view', 'id' => $model->id_biopsia]);
                }
                else {
                    return $this->render('update', ['model' => $model, 'edadDelPaciente' => Solicitud::calcular_edad($model
                        ->biopsia
                        ->id_solicitudbiopsia) ]);
                }
            }
        }
        else {
            return $this->render('update', ['model' => $model, 'edadDelPaciente' => Solicitud::calcular_edad($model
                ->biopsia
                ->id_solicitudbiopsia) ]);
        }
    }
    public function actionInforme($id) {
        $model = $this->findModel($id);
        return $this->redirect('@web/uploads/inmunohistoquimicas/' . $model->documento);
    }
    /**
     * Finds the InmunohistoquimicaEscaneada model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return InmunohistoquimicaEscaneada the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = InmunohistoquimicaEscaneada::findOne($id)) !== null) {
            return $model;
        }
        else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
