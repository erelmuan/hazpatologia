<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "usuario".
 *
 * @property int $id
 * @property string $usuario
 * @property string $contrasenia
 * @property string $nombre
 * @property string $email
 * @property bool $activo
 * @property string $descripcion
 * @property string $imagen
 * @property int $id_pantalla
 * @property Biopsia[] $biopsias
   * @property Firma $firma
   * @property Pap[] $paps
 * @property Auditoria[] $auditorias
 * @property Pantalla $pantalla
 * @property Usuariorol[] $usuariorols
 * @property Vista[] $vistas
 */
 use yii\filters\AccessControl;
 use app\components\behaviors\AuditoriaBehaviors;

class Usuario extends \yii\db\ActiveRecord
{
  public function behaviors()
  {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
 }
    /**
     * {@inheritdoc}
     */
     public $pass_ctrl="";
     public $pass_new="";
     public $pass_new_check="";
     public $pass_reset=false;

    public static function tableName()
    {
        return 'usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['usuario', 'contrasenia', 'nombre'], 'required'],
            [['activo'], 'default', 'value' => null],
            // [['activo'], 'integer'],
            [['descripcion', 'imagen'], 'string'],
            [['id_pantalla'], 'default', 'value' => null],
            [['id_pantalla'], 'integer'],
            [['usuario', 'nombre'], 'string', 'max' => 45],
            [['contrasenia'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 35],
            [['usuario', 'email'], 'unique', 'targetAttribute' => ['usuario', 'email']],
            [['id_pantalla'], 'exist', 'skipOnError' => true, 'targetClass' => Pantalla::className(), 'targetAttribute' => ['id_pantalla' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'usuario' => 'Usuario',
            'contrasenia' => 'Contrasenia',
            'nombre' => 'Nombre',
            'email' => 'Email',
            'activo' => 'Activo',
            'descripcion' => 'Descripcion',
            'imagen' => 'Imagen',
            'pass_ctrl' => 'Ingrese Contraseña Actual',
            'pass_new' => 'Ingrese Nueva Contraseña',
            'pass_new_check' => 'Repita Nueva Contraseña',
            'pass_reset' => 'Resetear Contraseña',
             'id_pantalla' => 'Id Pantalla',

        ];
    }

    public function afterFind(){

      // tareas despues de encontrar el objeto
      parent::afterFind();
  }

  public function beforeSave($insert)
  {
      // tareas antes de encontrar el objeto
      if (parent::beforeSave($insert)) {
          $this->usuario = strtoupper($this->usuario);
          $this->nombre = strtoupper($this->nombre);
          $this->email = strtoupper($this->email);

          if($this->isNewRecord){
              $this->contrasenia=md5($this->contrasenia);
          }else{
              // es un update de usuario , sin cambio de contraseña
          }
          // Place your custom code here
          return true;
      } else {
          return false;
      }
  }

  public function deleteImage($path,$filename) {
             $file =array();
             $file[] = $path.$filename;
             $file[] = $path.'sqr_'.$filename;
             $file[] = $path.'sm_'.$filename;
             foreach ($file as $f) {
               // check if file exists on server
               if (!empty($f) && file_exists($f)) {
                 // delete file
                 unlink($f);
               }
             }
         }
         /**
    		    * @return \yii\db\ActiveQuery
    		    */
    public function getAuditorias()
      {
    		    return $this->hasMany(Auditoria::className(), ['id_usuario' => 'id']);
    	 }
           /**
       * @return \yii\db\ActiveQuery
       */
      public function getUsuariorols()
      {
          return $this->hasMany(Usuariorol::className(), ['id_usuario' => 'id']);
      }
      /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getPantalla()
		   {
		       return $this->hasOne(Pantalla::className(), ['id' => 'id_pantalla']);
		   }
       public function getPantallas() {
           return ArrayHelper::map(Pantalla::find()->all(), 'id','descripcion');

           }
           /**
  * @return \yii\db\ActiveQuery
  */
     public function getBiopsias()
     {
         return $this->hasMany(Biopsia::className(), ['id_usuario' => 'id']);
     }
     /**
      * @return \yii\db\ActiveQuery
      */
     public function getPaps()
     {
         return $this->hasMany(Pap::className(), ['id_usuario' => 'id']);
     }

     
     /**
     * @return \yii\db\ActiveQuery
      */
     public function getFirma()
     {
         return $this->hasOne(Firma::className(), ['id_usuario' => 'id']);
     }
       public function isPatologo() {
         $id= Yii::$app->user->identity->id;
         $rol_patologo = Usuariorol::find()
          //el id_rol 4 es del patologo
          ->where(['and', "usuariorol.id_usuario=".$id ,"usuariorol.id_rol=4"])
          ->count('*');
          if ($rol_patologo >0){
            return true;
          }
          else {
            return false;
          }

         }


}
