<?php

namespace app\models;

use Yii;
use app\components\behaviors\AuditoriaBehaviors;

/**
 * This is the model class for table "anio_protocolo".
 *
 * @property int $anio
 * @property bool $activo
 * @property int $id
 */
class AnioProtocolo extends \yii\db\ActiveRecord
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
        return 'anio_protocolo';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['anio'], 'required'],
            [['anio'], 'default', 'value' => null],
            [['anio'], 'integer'],
            [['activo'], 'boolean'],
            [['anio'], 'unique'],
            ['anio', 'compare', 'compareValue' => 2017, 'operator' => '>=','message' => 'El numero debe ser mayor a 2017'],
            ['anio', 'compare', 'compareValue' => 2035, 'operator' => '<=','message' => 'El numero debe ser menor a 2035'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'anio' => 'Anio',
            'activo' => 'Activo',
            'id' => 'ID',
        ];
    }


    public function actualizarEstado()  {
        $db = Yii::$app->db;
        $db->createCommand('UPDATE anio_protocolo SET activo = false')->execute();;

    }

    public function getAnioProtocoloActivo($fecha) {
        $fechaEntera = strtotime($fecha);
        $anio = date("Y", $fechaEntera);
        $cantidad= AnioProtocolo::find()->andWhere(['and' ,"anio =" .$anio ." and activo=true" ])->count();
        if ($cantidad == 1){
          return true;
        }else {
          return false;
         }
    }
}
