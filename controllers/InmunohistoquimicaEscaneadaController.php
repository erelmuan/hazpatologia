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
     * Lists all InmunohistoquimicaEscaneada models.
     * @return mixed
     */
    public function actionIndex() {
        $searchModel = new InmunohistoquimicaEscaneadaSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
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
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ['title' => "InmunohistoquimicaEscaneada #" . $id, 'content' => $this->renderAjax('view', ['model' => $this->findModel($id) , ]) , 'footer' => Html::button('Close', ['class' => 'btn btn-default pull-left', 'data-dismiss' => "modal"]) . Html::a('Edit', ['update', 'id' => $id], ['class' => 'btn btn-primary', 'role' => 'modal-remote']) ];
        }
        else {
            return $this->render('view', ['model' => $this->findModel($id) , ]);
        }
    }
    function subirDocumento($model, $file){
        $directorio = Yii::$app->basePath . '/web/uploads/inmunohistoquimicas/';
        $ext = (explode(".", $file->name));
        $ext = end($ext);
        $nombreDocumento = "ihq-".$model->biopsia->solicitudbiopsia->protocolo."-".
        $model->biopsia->solicitudbiopsia->fechadeingreso."-".$model->biopsia->solicitudbiopsia->paciente->apellido." ".
        $model->biopsia->solicitudbiopsia->paciente->nombre. ".{$ext}";
        $model->documento = $nombreDocumento;
        $model->nombre_archivo = $file->name;

        // Verificar si el archivo ya existe en la carpeta
        if (file_exists($directorio.$nombreDocumento)) {
            $i = 1;
            while (file_exists($directorio.$nombreDocumento."(".$i .")" )) {
                $i++;
            }
            $resguardo =  $nombreDocumento ."(".$i .")" ;
            // Renombrar el archivo, rename (nombre_actual, nombre nuevo)
            rename($directorio. $nombreDocumento,$directorio.$resguardo);
        }

        $file->saveAs($directorio. $nombreDocumento);

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
            if ($model->load(Yii::$app->request->post()) && ! empty(UploadedFile::getInstances($model, 'documento') [0])) {
                $file = UploadedFile::getInstances($model, 'documento') [0];;
                $this->subirDocumento($model, $file);
                $model->baja_logica=false;

                if ($model->save()) {
                    return $this->redirect(['biopsia/view', 'id' => $model->id_biopsia]);
                }
                else {
                    return $this->render('create', ['model' => $model]);
                }
            }
            else {
                return $this->render('create', ['model' => $model ]);
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
        if ($this->request->isPost) {
            $post = $request->post();
            //verificar porque hay que agregar el indice [0] a diferencia cuando se sube un Documento
            $file = UploadedFile::getInstance($model, 'documento');
            if (empty($file)) {
                unset($post['InmunohistoquimicaEscaneada']['documento']);
            }
            if ($model->load($post)) {
                if (!is_null($file) && !empty($file) && $file->name != "") {
                    $this->subirDocumento($model, $file);
                }
                $model->baja_logica=false;
                if ($model->save()) {
                    return $this->redirect(['biopsia/view', 'id' => $model->id_biopsia]);
                }
                else {
                    return $this->render('update', ['model' => $model ]);
                }
            }

        }
        else {
            return $this->render('update', ['model' => $model]);
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
