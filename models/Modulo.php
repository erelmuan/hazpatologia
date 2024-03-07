<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "modulo".
* @property Permiso[] $permisos
 * @property int $id
 * @property string $nombre
 * @property int $id_tipo_acceso
 * @property TipoAcceso $tipoAcceso
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
            [['nombre','id_tipo_acceso'], 'required'],
            [['id_tipo_acceso'], 'default', 'value' => null],
            [['id_tipo_acceso'], 'integer'],
            [['nombre'], 'string', 'max' => 50],
            [['nombre', 'id_tipo_acceso'], 'unique', 'targetAttribute' => ['nombre', 'id_tipo_acceso'], 'message' => 'Esta combinación ya existe.'],
            [['id_tipo_acceso'], 'integer'],
            [['id_tipo_acceso'], 'exist', 'skipOnError' => true, 'targetClass' => TipoAcceso::className(), 'targetAttribute' => ['id_tipo_acceso' => 'id']],
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
            'id_tipo_acceso' => 'Id Tipo Acceso',
        ];
    }

    public function attributeView()
    {
        return [

      'id',
      'nombre',
      'id_tipo_acceso'
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
          ],
          [
            'class'=> '\kartik\grid\DataColumn',
            'label'=> 'Tipo de acceso',
            'attribute'=>'tipo_acceso',
            'value'=>'tipoAcceso.nombre',
          ],
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

       /**
  		    * @return \yii\db\ActiveQuery
  		    */
  	  public function getTipoAcceso()
    {
       return $this->hasOne(TipoAcceso::className(), ['id' => 'id_tipo_acceso']);
       }

}
