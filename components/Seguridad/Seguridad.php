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
   @return <boolean>
*/

    public static function tienePermiso($accion=''){

        if ( User::isUserAdmin() ){
          return true;
        }

       if(Yii::$app->user->isGuest)
          return false;


       if (empty($accion)){
           $accion=$_GET['r'];
       }


       // var_dump($_GET['r']);
       $array = explode("/",$accion);
       if (count($array)==1) {
               $controller = $accion;
               $accion = 'index';
       }else {
               $controller = $array[0];
               $accion = $array[1];
       }


       $id_usuario=Yii::$app->user->identity->getId();
       $rolesusuario = \app\models\Usuariorol::findall(['id_usuario' => $id_usuario]);

      if ($rolesusuario==null)
        //no tiene rol el usuario
        return false;
      foreach($rolesusuario as $roluser) {
            $permisos=\app\models\Permiso::find()->where(['id_rol'=>$roluser->id_rol ])->all();
            // return false;
            if ($accion =="informe" || $accion =="documento" || $accion=="perfil" ||  $accion=="search" ||  $accion=="subcat" ||  $accion=="buscaregistro")
               return true;
            foreach($permisos as $permiso) {
              $modulo=\app\models\Modulo::findOne(['id'=>$permiso->id_modulo]);

              if ($controller == $modulo->nombre  ){
                //Si no es usuario administrador no puede acceder a los siguientes modulos
                if ($controller == "usuario"|| $controller == "rol" || $controller == "modulo" || $controller =="accion" || $controller == "auditoria" || $controller =="usuario")
                    return false;
                //  $accionbd=\app\modesdals\Accion::findOne(['idaccion'=>$permiso->idaccion]);


                if ($permiso->id_accion !== null ){

              $accionbd=\app\models\Accion::find()->where(['id'=>$permiso->id_accion])->one();
              //supongo que si le das permiso para ver la grilla tambien le das permiso para ver la vista completa
              if ($accionbd->index == false)
                  return false;
              if ($accion =="view" || $accion =="select" || $accion =="createdetalle" || $accion =="listdetalle" || $accion == "seleccionar")
                 return true;
                //si algun modulo tiene activado en verdadero la accion
                //prevalece la accion verdadero por sobre el falso y el null
              if ($accionbd->$accion == true)
                  return true;
                }

              }
              //el rol no incluye el permisos

            }

       }
       return false;


    }

}
?>
