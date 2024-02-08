<?php
namespace app\models;

use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "estado".
 *
 * @property int $id
 * @property string $descripcion
 * @property string $explicacion
 *
 * @property Biopsia[] $biopsias
 * @property Pap[] $paps
 * @property Solicitud[] $solicituds
 */
class Estado extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'estado';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['descripcion', 'explicacion'], 'string'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'descripcion' => 'Descripcion',
            'explicacion' => 'Explicacion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getBiopsias()
    {
        return $this->hasMany(Biopsia::className(), ['id_estado' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaps()
    {
        return $this->hasMany(Pap::className(), ['id_estado' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_estado' => 'id']);
    }

    //ESTO ES PARA LOS FORMULARIOS DE LOS ESTUDIOS
    public function estadosEstudio(){
      if (Usuario::isPatologo()){
        return ArrayHelper::map(Estado::find()->where(['or', "descripcion='EN PROCESO'", "descripcion='LISTO'"])
        ->all(), 'id','descripcion');
        }
      else {
        return ArrayHelper::map(Estado::find()->where(['and', "descripcion='EN PROCESO'"])
                ->all(), 'id','descripcion');
              }
  }
}
