<?php
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
namespace app\components\Seguridad;
use Yii;
use app\models\User;

class Seguridad {

/* tienePermiso()
   Esta funcion toma el parametro r del GET que tiene 2 partes: controlador/accion
   y chequea si el usuario actual tiene permiso sobre esa acción. Tambien se le puede pasar la accion por parametro

   Casos especiales
   controlador/* indica que tiene permiso sobre todas las acciones del controlador

   La seguridad se maneja por grupos y permisos. Un grupo tiene varios permisos. Un usuario pertenece a varios grupo

*/

    private function acceso($id_usuario,$moduloAccedido,$accion){
        $acceso = \app\models\Permiso::find()->innerJoinWith("rol")
        ->innerJoin('modulo','modulo.id=permiso.id_modulo')
        ->innerJoin('tipo_acceso','tipo_acceso.id=modulo.id_tipo_acceso')
        ->innerJoin('usuario','usuario.id_rol=rol.id')
        ->andWhere(['usuario.id'=>$id_usuario])
        ->andWhere(['modulo.nombre'=>$moduloAccedido])
        ->andWhere(['tipo_acceso.nombre'=>$accion])
        ->one();
        return $acceso;
    }

    public static function tienePermiso($accion=''){
      if (Yii::$app->user->isGuest) {
          return false;
      }
      if ( User::isUserAdmin() ){
          return true;
        }
       $accion=Yii::$app->controller->action->id;
       $controller=Yii::$app->controller->id;
       $id_usuario=Yii::$app->user->identity->getId();
       $seguridad = new Seguridad(); // Crear una instancia de la clase Seguridad
       if ($accion =="view" ||$accion =="delete"
       ||$accion =="create"||$accion =="update"){
         //si o si tengo que tener acceso al index para evaluar las acciones abm
          $permisoAcceso=$seguridad->acceso($id_usuario,$controller, "index");
           if (!empty($permisoAcceso)){
              $accionbd=\app\models\Accion::find()->where(['id'=>$permisoAcceso->id_accion])->one();
              return ($accionbd)?$accionbd->$accion:false;
           }else {
             return false ;
           }
       }else {
           $permisoAcceso=$seguridad->acceso($id_usuario,$controller,$accion);
           if (!empty($permisoAcceso)){
              return true;
           }else {
             return false ;
           }
       }
       return false;
    }

  }
?>
