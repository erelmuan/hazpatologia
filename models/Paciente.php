<?php

namespace app\models;

use Yii;
use app\components\behaviors\AuditoriaBehaviors;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "paciente".
 *
 * @property int $id
 * @property string $nombre
 * @property string $num_documento
 * @property string $sexo
 * @property string $direccion
 * @property string $cp
 * @property string $telefono
 * @property string $email
 * @property string $afiliado
 * @property int $id_provincia
 * @property int $id_localidad
 * @property string $fecha_nacimiento
 * @property string $apellido
 * @property string $hc
 * @property int $id_nacionalidad
 * @property int $id_tipodoc
 *
 * @property CarnetOs[] $carnetOs
 * @property Localidad $localidad
 * @property Nacionalidad $nacionalidad
 * @property Provincia $provincia
 * @property Tipodoc $tipodoc
 * @property Solicitud[] $solicituds
 * @property Solicitudbiopsia[] $solicitudbiopsias
 * @property Solicitudpap[] $solicitudpaps
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
            [['id_provincia', 'id_localidad', 'id_nacionalidad', 'id_tipodoc'], 'default', 'value' => null],
            [['id_provincia', 'id_localidad', 'id_nacionalidad', 'id_tipodoc'], 'integer'],
            [['fecha_nacimiento'], 'safe'],
            [['nombre', 'direccion', 'telefono', 'email'], 'string', 'max' => 50],
            [['num_documento', 'afiliado'], 'string', 'max' => 15],
            [['cp'], 'string', 'max' => 8],
            [['apellido'], 'string', 'max' => 60],
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
            'direccion' => 'Direccion',
            'cp' => 'Cp',
            'telefono' => 'Telefono',
            'email' => 'Email',
            'afiliado' => 'Afiliado',
            'id_provincia' => 'Id Provincia',
            'id_localidad' => 'Id Localidad',
            'fecha_nacimiento' => 'Fecha de  Nacimiento',
            'apellido' => 'Apellido',
            'hc' => 'Hc',
            'id_nacionalidad' => 'Id Nacionalidad',
            'id_tipodoc' => 'Id Tipodoc',
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
    public function getNacionalidades()
    {
        return ArrayHelper::map(Nacionalidad::find()->all(), 'id','gentilicio');
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
    public function getTipodocs() {
            return ArrayHelper::map(Tipodoc::find()->all(), 'id','documento');

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
            $id= $this->id;
            $estudiosPap = Solicitudpap::find()
             ->innerJoinWith('paciente', 'paciente.id = solicitudpap.id_paciente')
             ->innerJoinWith('pap', 'pap.id_solicitudpap = solicitudpap.id')
             //Estado 2 pap
             ->where(['and', "paciente.id=".$id, "pap.id_estado=2"])
             ->count('*');
             if ($estudiosPap >0)
                 return true;
             $estudiosBiopsia = Solicitudbiopsia::find()
              ->innerJoinWith('paciente', 'paciente.id = solicitudbiopsia.id_paciente')
              ->innerJoinWith('biopsia', 'biopsia.id_solicitudbiopsia = solicitudbiopsia.id')
              ->where(['and', "paciente.id=".$id, "biopsia.id_estado=2"])
              ->count('*');

            if ($estudiosBiopsia >0)
                return true;

            return false;
          }


}
