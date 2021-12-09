<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "rol".
 *
 * @property string $nombre
 		* @property string $descripcion
 	* @property int $id
 		* @property Modulo[] $modulos
 		* @property Permiso[] $permisos
 		* @property Usuariorol[] $usuariorols
 */
 use app\components\behaviors\AuditoriaBehaviors;


class Rol extends \yii\db\ActiveRecord
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
        return 'rol';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 50],
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
            'descripcion' => 'Descripcion',
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

        ];
    }
    public function getUsuariorols()
     {

         return $this->hasMany(Usuariorol::className(), ['id_rol' => 'id']);
     }

    /**
      * @return \yii\db\ActiveQuery
      */
     public function getPermisos()
     {
       return $this->hasMany(Permiso::className(), ['id_rol' => 'id']);     }


}
