<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "usuariorol".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_rol
 *
 * @property Rol $rol
 * @property Usuario $usuario
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Usuariorol extends \yii\db\ActiveRecord
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
        return 'usuariorol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_rol'], 'default', 'value' => null],
            [['id_usuario', 'id_rol'], 'integer'],
            //esta bien tomar como ejemplo en las relaciones
            [['id_rol'], 'exist', 'skipOnError' => true, 'targetClass' => Rol::className(), 'targetAttribute' => ['id_rol' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'id_usuario' => 'Id usuario',
            'id_rol' => 'Id rol',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRol()
    {
        return $this->hasOne(Rol::className(), ['id' => 'id_rol']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
