<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "permiso".
 *
 * @property int $id
 * @property int $id_rol
 * @property int $id_modulo
 * @property int $id_accion
 *
 * @property Accion $accion
 * @property Modulo $modulo
 * @property Rol $rol
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Permiso extends \yii\db\ActiveRecord
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
        return 'permiso';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_rol', 'id_modulo', 'id_accion'], 'default', 'value' => null],
            [['id_rol', 'id_modulo', 'id_accion'], 'integer'],
            [['id_accion'], 'exist', 'skipOnError' => true, 'targetClass' => Accion::className(), 'targetAttribute' => ['id_accion' => 'id']],
            [['id_modulo'], 'exist', 'skipOnError' => true, 'targetClass' => Modulo::className(), 'targetAttribute' => ['id_modulo' => 'id']],
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
            'id_rol' => 'Id_rol',
            'id_modulo' => 'Id_modulo',
            'id_accion' => 'Id_accion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAccion()
    {
        return $this->hasOne(Accion::className(), ['id' => 'id_accion']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModulo()
    {
        return $this->hasOne(Modulo::className(), ['id' => 'id_modulo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'id_rol']);
    }
}
