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
 * @property bool $cambioforzadocontrasenia
 */
 use yii\filters\AccessControl;
 use app\components\behaviors\AuditoriaBehaviors;
 use kartik\password\StrengthValidator;

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
          $model->cambioforzadocontrasenia=$usuario->cambioforzadocontrasenia;


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
            [['usuario', 'nombre'], 'required'],
            [['contrasenia'], 'required', 'on' => 'create'],
            [['activo'], 'default', 'value' => null],
            [['activo','cambioforzadocontrasenia'], 'boolean'],
            [['descripcion', 'imagen'], 'string'],
            [['id_pantalla','id_configuracion','id_provincia', 'id_localidad','id_rol'], 'default', 'value' => null],
            [['id_pantalla','id_configuracion','id_provincia', 'id_localidad','id_rol'], 'integer'],
            [['usuario', 'nombre'], 'string', 'max' => 45],
            [['contrasenia'], 'string', 'max' => 100],
            [['email'], 'string', 'max' => 35],
            [['id_configuracion'], 'unique'],
            [['usuario'], 'unique'],
            // Requeridos solo en cambio de contraseña
            [['pass_ctrl', 'pass_new', 'pass_new_check'], 'required', 'on' => 'change_password'],
            // Comparar contraseñas
            [['pass_new_check'], 'compare','compareAttribute' => 'pass_new','message' => 'Las contraseñas no coinciden.',
                'on' => 'change_password'
            ],
            // Validar contraseña actual
            [['pass_ctrl'], 'validatePasswordActual', 'on' => 'change_password'],
            // Validar que no sea igual a la anterior
            [['pass_new'], 'validatePasswordNueva', 'on' => 'change_password'],
            [['pass_new'], StrengthValidator::className(),
                'min' => 8,
                'upper' => 1,
                'lower' => 1,
                'digit' => 1,
                'special' => 1,
                'userAttribute' => 'usuario',
            ],
            [['pass_new_check'], StrengthValidator::className(),
              'min' => 8,
              'upper' => 1,
              'lower' => 1,
              'digit' => 1,
              'special' => 1,
              'userAttribute' => 'usuario',
            ],
            [['pass_new'], 'required', 'on' => 'admin_reset_password'],
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
            'contrasenia' => 'Contraseña',
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
             'cambioforzadocontrasenia' => 'Cambio forzado de contraseña',


        ];
    }
    public function validatePasswordActual($attribute, $params)
    {
        if (!$this->hasErrors()) {
            if (!Yii::$app->security->validatePassword($this->$attribute, $this->contrasenia)) {
                $this->addError($attribute, 'La contraseña ingresada no es correcta.');
            }
        }
    }
    public function validatePasswordNueva($attribute, $params)
    {
        if (!$this->hasErrors()) {

            // Que no sea igual a la actual
            if (Yii::$app->security->validatePassword($this->$attribute, $this->contrasenia)) {
                $this->addError($attribute, 'La nueva contraseña no puede ser igual a la actual.');
            }
        }
    }
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios['change_password'] = ['pass_ctrl', 'pass_new', 'pass_new_check' ,'cambioforzadocontrasenia'];
        $scenarios['admin_reset_password'] = ['pass_new'];
        return $scenarios;
    }


    public function afterFind(){

      // tareas despues de encontrar el objeto
      parent::afterFind();
  }

  public function beforeSave($insert)
  {
      if (!parent::beforeSave($insert)) {
          return false;
      }

      // normalizar
      $this->usuario = strtoupper(trim($this->usuario));
      $this->nombre  = strtoupper(trim($this->nombre));
      $this->email   = strtolower(trim($this->email));

      // 🔥 CONTRASEÑA BIEN MANEJADA
      if (!empty($this->pass_new)) {
          // siempre que haya nueva contraseña → se actualiza
          $this->contrasenia = Yii::$app->security->generatePasswordHash($this->pass_new);
      } else {
          // si no se tocó → mantener la anterior
          $this->contrasenia = $this->getOldAttribute('contrasenia');
      }

      return true;
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

     public function puedeEliminar()
     {
         // No eliminarse a sí mismo
         if ($this->id == Yii::$app->user->id) {
             return 'No puede eliminarse a sí mismo';
         }
         // Solo admin puede eliminar
         if (!User::isUserAdmin()) {
             return 'No puede eliminar usuario si no es administrador';
         }
         // Relaciones
         if (Firma::find()->where(['id_usuario' => $this->id])->exists()) {
             return 'No se puede eliminar el usuario porque está asociado a una firma';
         }
         if (Auditoria::find()->where(['id_usuario' => $this->id])->exists()) {
             return 'No se puede eliminar el usuario porque está asociado a auditorías';
         }

         return true;
     }

     public static function esPatologo() {
       return Usuario::find()
              ->where([
                  'id' => Yii::$app->user->id,
                  'id_rol' => 4 // rol patólogo
              ])
              ->exists();

      }

    public function nuevaContrasenia($contrasenia){



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
