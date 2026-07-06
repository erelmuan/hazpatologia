<?php
namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\models\Biopsia;
use app\models\InformeComplementario;
use app\models\patronState\EstadoBase;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;

class InformeComplementarioController extends AppController {


  public function actionCreate($id_biopsia){

      $request = Yii::$app->request;
      $biopsia= Biopsia::findOne($id_biopsia);
      if (!$biopsia) {
      throw new NotFoundHttpException('Biopsia no encontrada.');
      }

      if (!$biopsia->estaListo()) {
          throw new ForbiddenHttpException(
              'La biopsia debe estar en estado LISTO.'
          );
      }
      if (!Yii::$app->user->identity->esPatologo()) {
          throw new ForbiddenHttpException(
              'Solo los patólogos pueden acceder al informe complementario.'
          );
      }
      if ($biopsia->informeComplementario !== null) {
          return $this->redirect([
              'update',
              'id' => $biopsia->informeComplementario->id,
          ]);
      }
      $solicitud= $biopsia->solicitudbiopsia;
      $model = new InformeComplementario();
      $model->id_biopsia = $id_biopsia;
      $stateOptions = \app\models\patronState\EstadoFactory::getAvailableTransitions(
          $model->id_estado,
          Yii::$app->user->identity,
          $model
      );
       $post = $request->post();
      if($model->load($post) ){
        // Asociación segura desde el servidor
        $model->id_biopsia = $biopsia->id;
        // Si quiere quedar LISTO, validamos contraseña
        if (!$this->comprobarEstado($model, $post)) {
          return $this->render('form', ['biopsia'=>  $biopsia, 'solicitud'=> $solicitud, 'model'=>$model, 'stateOptions' =>  $stateOptions ]);
        }

        $model->save();
        return $this->redirect(['biopsia/view','id'=>$id_biopsia]);
      }


    return $this->render('form', ['biopsia'=>  $biopsia, 'solicitud'=> $solicitud, 'model'=>$model, 'stateOptions' =>  $stateOptions ]);

  }


  private function comprobarEstado(InformeComplementario $model, array $post): bool
  {
    if (!$model->estaListo() && !$model->estaAnulado()) {
        return true;
    }

      $contrasenia = trim((string)($post['contrasenia'] ?? ''));
      if ($contrasenia === '') {
          $this->setearMensajeError('EN ESTADO LISTO O ANULADO, DEBE ESCRIBIR LA CONTRASEÑA');
          return false;
      }
      $usuario = Yii::$app->user->identity;
      if (!$usuario->validarContrasenia($contrasenia)) {
          $this->setearMensajeError('CONTRASEÑA INCORRECTA');
          return false;
      }

      return true;
  }

  public function actionUpdate($id){
      $model= InformeComplementario::findOne($id);
      $biopsia= $model->biopsia;
      $solicitud= $biopsia->solicitudbiopsia;
      $request = Yii::$app->request;
      $stateOptions = \app\models\patronState\EstadoFactory::getAvailableTransitions(
          $model->id_estado,
          Yii::$app->user->identity,
          $model
      );
      if (!Yii::$app->user->identity->esPatologo()) {
          throw new ForbiddenHttpException(
              'Solo los patólogos pueden acceder al informe complementario.'
          );
      }
      $post = $request->post();
     if($model->load($post) ){
       // Si quiere quedar LISTO, validamos contraseña
       if (!$this->comprobarEstado($model, $post)) {
         return $this->render('form', ['biopsia'=>  $biopsia, 'solicitud'=> $solicitud, 'model'=>$model, 'stateOptions' =>  $stateOptions ]);
       }

       $model->save();
       return $this->redirect(['biopsia/view','id'=>$biopsia->id]);
     }

    return $this->render('form' ,['biopsia'=>$biopsia ,  'solicitud'=> $solicitud,'model'=>$model,'stateOptions' =>  $stateOptions]);

  }

  public function actionDocumentoPdf($id){
    $model=  $this->findModel($id);
    $biopsia=  Biopsia::findOne($model->id_biopsia)   ;
    return $this->render('documento_pdf',['biopsia'=>$biopsia ,'model'=> $model]);
  }

  /**
   * Finds the InformeComplementario model based on its primary key value.
   * If the model is not found, a 404 HTTP exception will be thrown.
   * @param integer $id
   * @return InformeComplementario the loaded model
   * @throws NotFoundHttpException if the model cannot be found
   */
  protected function findModel($id) {
      if (($model = InformeComplementario::findOne($id)) !== null) {
          return $model;
      }
      else {
          throw new NotFoundHttpException('The requested page does not exist.');
        }

  }


  public function actionDelete($id)
  {
      $model = $this->findModel($id);

      $idBiopsia = $model->id_biopsia;

      if (!$model->delete()) {
          $this->setearMensajeError('o se pudo eliminar el informe.');
      }
      $this->setearMensajeExito('El registro se eliminó correctamente');
      return $this->redirect([
          '/biopsia/update',
          'id' => $idBiopsia,
      ]);
  }


}

 ?>
