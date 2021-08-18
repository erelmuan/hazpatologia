<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedencia".
 *
 * @property int $id
 * @property string $nombre
 * @property string $contacto
 *  @property string $direccion 
 *
* @property Solicitud[] $solicituds
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Procedencia extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
     public function behaviors()
     {

       return array(
              'AuditoriaBehaviors'=>array(
                     'class'=>AuditoriaBehaviors::className(),
                     ),
         );
  }
    public static function tableName()
    {
        return 'procedencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'default', 'value' => null],
            [['id'], 'integer'],
            [['direccion'], 'string'],
            [['nombre'], 'string', 'max' => 18],
            [['contacto'], 'string', 'max' => 40],
            [['id'], 'unique'],
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
            'contacto' => 'Contacto',
            'direccion' => 'Direccion', 
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()    {
        return $this->hasMany(Solicitud::className(), ['id_procedencia' => 'id']);
        }
}
