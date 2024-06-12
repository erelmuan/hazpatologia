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
  * @property int $id_rol
 * @property Biopsia[] $biopsias
 * @property Firma $firma
 * @property Pap[] $paps
 * @property Auditoria[] $auditorias
 * @property Pantalla $pantalla
 * @property Vista[] $vistas
 * @property int $id_configuracion
 * @property Configuracion $configuracion
 * @property Registrosesion[] $registrosesions
 * @property string $token
 * @property int $id_provincia
 * @property int $id_localidad
 * @property Localidad $localidad
 * @property Provincia $provincia
 * @property Rol $rol

 */
 use yii\filters\AccessControl;
 use app\components\behaviors\AuditoriaBehaviors;

class Usuario extends \yii\db\ActiveRecord  implements \yii\web\IdentityInterface
{
  public $authKey;

  public function findByUsername($username)
  {

      $usuario= Usuario::findOne(['usuario'=>$username]);

      return new static($model);
  }

  public static function findIdentity($id)
  {
      $usuario= Usuario::findOne($id);

      if ($usuario){

          $model=new Usuario();
          $model->id=$usuario->id;
          $model->usuario=$usuario->usuario;
          $model->nombre=$usuario->nombre;
          $model->contrasenia=$usuario->contrasenia;
          $model->activo=$usuario->activo;
          $model->imagen=$usuario->imagen;
          $model->id_pantalla=$usuario->id_pantalla;
          $model->id_configuracion=$usuario->id_configuracion;

        //  $model->administrador=$usuario->administrador;

          return new static($model);
      }
      return null;

  }
  public function behaviors()
    {

      return array(
             'AuditoriaBehaviors'=>array(
                    'class'=>AuditoriaBehaviors::className(),
                    ),
        );
   }
   public static function findIdentityByAccessToken($token, $type = null) {
                   return self::findOne(['token' => $token]);

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
            [['id_pantalla','id_configuracion','id_provincia', 'id_localidad','id_rol'], 'default', 'value' => null],
            [['id_pantalla','id_configuracion','id_provincia', 'id_localidad','id_rol'], 'integer'],
            [['usuario', 'nombre'], 'string', 'max' => 45],
            [['contrasenia'], 'string', 'max' => 50],
            [['email'], 'string', 'max' => 35],
            [['id_configuracion'], 'unique'],
            [['usuario'], 'unique'],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
            [['id_configuracion'], 'exist', 'skipOnError' => true, 'targetClass' => Configuracion::className(), 'targetAttribute' => ['id_configuracion' => 'id']],
            [['usuario', 'email'], 'unique', 'targetAttribute' => ['usuario', 'email']],
            [['id_pantalla'], 'exist', 'skipOnError' => true, 'targetClass' => Pantalla::className(), 'targetAttribute' => ['id_pantalla' => 'id']],
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['id_rol' => 'id']],
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
             'id_provincia' => 'Id Provincia',
             'id_localidad' => 'Id Localidad',
             'id_rol' => 'Id Rol',

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
     public static function isPatologo() {
         $id= Yii::$app->user->identity->id;
         $rol_patologo = Usuario::find()
          //el id_rol 4 es del patologo
          ->where(['and', "id=".$id ,"id_rol=4"])->count('*');
          if ($rol_patologo >0){
            return true;
          }
          else {
            return false;
          }

      }

         /**
          * @inheritdoc
          */
         public function getId()
         {
             return $this->id;
         }
         /**
          * @inheritdoc
          */
         public function getAuthKey()
         {
             return $this->authKey;
         }
         /**
          * @inheritdoc
          */
         public function validateAuthKey($authKey)
         {
             return $this->authKey === $authKey;
         }

        /**
     		   * @return \yii\db\ActiveQuery
     	    */
        public function getConfiguracion()
     	  {
     	      return $this->hasOne(Configuracion::className(), ['id' => 'id_configuracion']);
     	  }
        /**
       * @return \yii\db\ActiveQuery
       */
      public function getProvincia()
      {
          return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
      }
      public function getLocalidad()
     {
         return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
     }
		   /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getRol()
		   {
		       return $this->hasOne(Rol::className(), ['id' => 'id_rol']);
		   }

}
