<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modulo".
* @property Permiso[] $permisos
 * @property int $id
 * @property string $nombre
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Modulo extends \yii\db\ActiveRecord
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
        return 'modulo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['nombre'], 'required'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre'], 'unique'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'id',
            'nombre' => 'Nombre',
        ];
    }

    public function attributeView()
    {
        return [
      // 'id',
      // 'nombre',
      // 'regla',
      // 'obs',
      'id',
      'nombre',

        ];
    }

    public function attributeColumns()
    {
        return [
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'id',
          ],
          [
            'class'=>'\kartik\grid\DataColumn',
            'attribute'=>'nombre',
          ]
        ];
    }

    public function beforeSave($insert){
    //DE FORMA INDIVIDUAL
     if ($insert) {
      $this->nombre = strtolower($this->nombre);
    }
      return parent::beforeSave($insert);
    }

    /**
  		    * @return \yii\db\ActiveQuery
  		    */
  		 public function getPermisos()
  		 {
         return $this->hasMany(Permiso::className(), ['id_modulo' => 'id']);
       }



}
