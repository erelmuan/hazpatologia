<?php

namespace app\models;

use Yii;
use app\components\behaviors\AuditoriaBehaviors;
use app\models\patronState\EstadoBase;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "paciente".
 *
 * @property int $id
 * @property string $num_documento
 * @property string $nombre
 * @property string $num_documento
 * @property string $sexo
 * @property string $afiliado
 * @property int $id_provincia
 * @property int $id_localidad
 * @property string $fecha_nacimiento
 * @property string $apellido
 * @property string $hc
 * @property int $id_nacionalidad
 * @property int $id_tipodoc
 * @property CarnetOs[] $carnetOs
 * @property Localidad $localidad
 * @property Nacionalidad $nacionalidad
 * @property Provincia $provincia
 * @property Tipodoc $tipodoc
 * @property Solicitud[] $solicituds
 * @property Solicitudbiopsia[] $solicitudbiopsias
 * @property Solicitudpap[] $solicitudpaps
 * @property Pacientecheckos[] $pacientecheckos
 * @property int $id_genero
 * @property Genero $genero
 * @property Correo[] $correos
 * @property Domicilio[] $domicilios
 * @property Telefono[] $telefonos
 * @property Contacto[] $contactos
 */

class Paciente extends \yii\db\ActiveRecord
{

  public function behaviors()
 		 {

 		   return [

 		          'AuditoriaBehaviors'=>[
 		                 'class'=>AuditoriaBehaviors::className(),
                   ],
 		     ];
 		}
    public function getActiveRelations()
      {
          $relations = [];
          foreach ($this->getRelatedRecords() as $relationName) {
              $relations[$relationName] = $this->getRelation($relationName);
          }
          return $relations;
      }

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'paciente';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
           [['nombre', 'num_documento', 'sexo', 'apellido','fecha_nacimiento'], 'required'],
            [['sexo', 'hc'], 'string'],
            [['id_provincia', 'id_localidad', 'id_nacionalidad', 'id_tipodoc', 'id_genero' ], 'default', 'value' => null],
            [['id_provincia', 'id_localidad', 'id_nacionalidad', 'id_tipodoc', 'num_documento' ,'id_genero'], 'integer'],
            [['fecha_nacimiento'], 'safe'],
            [['nombre'], 'string', 'max' => 50],
            [[ 'afiliado'], 'string', 'max' => 15],
            [['cp'], 'string', 'max' => 8],
            [['apellido'], 'string', 'max' => 60],
            [['id_tipodoc', 'num_documento', 'sexo'], 'unique', 'targetAttribute' => ['id_tipodoc', 'num_documento', 'sexo']],
            [['id_genero'], 'exist', 'skipOnError' => true, 'targetClass' => Genero::className(), 'targetAttribute' => ['id_genero' => 'id']],
            [['id_localidad'], 'exist', 'skipOnError' => true, 'targetClass' => Localidad::className(), 'targetAttribute' => ['id_localidad' => 'id']],
            [['id_nacionalidad'], 'exist', 'skipOnError' => true, 'targetClass' => Nacionalidad::className(), 'targetAttribute' => ['id_nacionalidad' => 'id']],
            [['id_provincia'], 'exist', 'skipOnError' => true, 'targetClass' => Provincia::className(), 'targetAttribute' => ['id_provincia' => 'id']],
            [['id_tipodoc'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodoc::className(), 'targetAttribute' => ['id_tipodoc' => 'id']],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'num_documento' => 'N° doc.',
            'sexo' => 'Sexo',
            'cp' => 'Cp',
            'afiliado' => 'Afiliado',
            'id_provincia' => 'Id Provincia',
            'id_localidad' => 'Id Localidad',
            'fecha_nacimiento' => 'Fecha de  Nacimiento',
            'apellido' => 'Apellido',
            'hc' => 'Hc',
            'id_nacionalidad' => 'Id Nacionalidad',
            'id_tipodoc' => 'Id Tipodoc',
            'id_genero' => 'Id Genero',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCarnetOs()
    {
        return $this->hasMany(CarnetOs::className(), ['id_paciente' => 'id']);
    }
    public function getCarnets()
    {
      return ArrayHelper::map(CarnetOs::find()->all(), 'id','nroafiliado');
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getLocalidad()
    {
        return $this->hasOne(Localidad::className(), ['id' => 'id_localidad']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNacionalidad()
    {
        return $this->hasOne(Nacionalidad::className(), ['id' => 'id_nacionalidad']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProvincia()
    {
        return $this->hasOne(Provincia::className(), ['id' => 'id_provincia']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodoc()
    {
        return $this->hasOne(Tipodoc::className(), ['id' => 'id_tipodoc']);
    }

      /**
       * @return \yii\db\ActiveQuery
       */
      public function getSolicituds()
      {
          return $this->hasMany(Solicitud::className(), ['id_paciente' => 'id']);
      }

      public function beforeSave($insert){
      //DE FORMA INDIVIDUAL
       if ($insert) {
        $this->nombre = strtoupper($this->nombre);
        $this->apellido = strtoupper($this->apellido);
      }
        return parent::beforeSave($insert);
      }



    /**
	    * @return \yii\db\ActiveQuery
	    */
	   public function getSolicitudbiopsias()
	   {
	       return $this->hasMany(Solicitudbiopsia::className(), ['id_paciente' => 'id']);
	   }

	   /**
	    * @return \yii\db\ActiveQuery
	    */
	   public function getSolicitudpaps()
	   {
	       return $this->hasMany(Solicitudpap::className(), ['id_paciente' => 'id']);
	   }

     public function Estudios()
    {
        if (!isset($this->id))
          return false;
          $estudiosPap = Solicitudpap::find()
        ->innerJoinWith('paciente')
        ->where(['paciente.id' => $this->id])
        ->andWhere([
            'or',['solicitudpap.id_estado' => EstadoBase::LISTO],
            ['solicitudpap.id_estado' => EstadoBase::DERIVADO_LISTO],
        ])->count();
       if ($estudiosPap >0)
           return true;
           $estudiosBiopsia = Solicitudbiopsia::find()
         ->innerJoinWith('paciente')
         ->where(['paciente.id' => $this->id])
         ->andWhere([
             'or', ['solicitudbiopsia.id_estado' => EstadoBase::LISTO],
             ['solicitudbiopsia.id_estado' => EstadoBase::DERIVADO_LISTO],
         ])->count();
      if ($estudiosBiopsia >0)
          return true;

      return false;
    }
        /**
          * @return \yii\db\ActiveQuery
       */
      public function getPacientecheckos()
      {
          return $this->hasMany(Pacientecheckos::className(), ['id_paciente' => 'id']);
      }

      public function getUltimoChequeo()
      {
          return $this->hasOne(Pacientecheckos::class, ['id_paciente' => 'id'])
              ->orderBy(['fechahora' => SORT_DESC]);
      }

	   /**
	    * @return \yii\db\ActiveQuery
	    */
	   public function getCorreos()
	   {
	       return $this->hasMany(Correo::className(), ['id_paciente' => 'id']);
	   }

	   /**
	    * @return \yii\db\ActiveQuery
	    */
	   public function getDomicilios()
	   {
	       return $this->hasMany(Domicilio::className(), ['id_paciente' => 'id']);
	   }

	   /**
	    * @return \yii\db\ActiveQuery
	    */
	   public function getGenero()
	   {
	       return $this->hasOne(Genero::className(), ['id' => 'id_genero']);
	   }

     /**
    * @return \yii\db\ActiveQuery
      */
     public function getTelefonos()
     {
         return $this->hasMany(Telefono::className(), ['id_paciente' => 'id']);
     }

     /**
    * @return \yii\db\ActiveQuery
    */
	   public function getContactos()
	   {
	       return $this->hasMany(Contacto::className(), ['id_paciente' => 'id']);
	   }

       public function registrarChequeo(): bool
     {
         $tieneOs = $this->getCarnetOs()->exists();

         $checkOS = Pacientecheckos::find()
             ->where(['id_paciente' => $this->id])
             ->one();

         if ($checkOS === null) {
             $checkOS = new Pacientecheckos();
             $checkOS->id_paciente = $this->id;
         }

         $checkOS->tiene_os = $tieneOs;
         $checkOS->fechahora = new \yii\db\Expression('NOW()');

         return $checkOS->save(false);
     }
}
