<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "obrasocial".
 *
 * @property int $id
 * @property string $sigla
 * @property string $denominacion
 * @property string $direccion
 * @property string $telefono
 * @property string $paginaweb
 * @property string $observaciones
 * @property string $correoelectronico
 * @property string $codigo
 * @property CarnetOs[] $carnetOs
 * @property CarnetOs[] $carnetOs
 		* @property Provincia $provincia
 		* @property Paciente[] $pacientes
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Obrasocial extends \yii\db\ActiveRecord
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
    public static function tableName()
    {
        return 'obrasocial';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['telefono'], 'default', 'value' => null],
            [['telefono'], 'integer'],
            [['observaciones', 'correoelectronico', 'codigo'], 'string'],
            [['sigla'], 'string', 'max' => 15],
            [['denominacion'], 'string', 'max' => 80],
            [['direccion'], 'string', 'max' => 70],
            [['paginaweb'], 'string', 'max' => 35],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'sigla' => 'Sigla',
            'denominacion' => 'Denominacion',
            'direccion' => 'Direccion',
            'telefono' => 'Telefono',
            'paginaweb' => 'Pagina web',
            'observaciones' => 'Observaciones',
            'correoelectronico' => 'Correo electronico',
             'codigo' => 'Código',
        ];
    }



    /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getCarnetOs()
		   {
		       return $this->hasMany(CarnetOs::className(), ['id_obrasocial' => 'id']);
		   }

}
