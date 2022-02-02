<?php

namespace app\models;
use yii\helpers\ArrayHelper;

use Yii;

/**
 * This is the model class for table "estado".
 *
 * @property int $id
 * @property string $descripcion
 * @property bool $solicitud
 * @property bool $biopsia
 * @property bool $pap
 * @property bool $ver_informe_solicitud
 * @property bool $ver_informe_estudio
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
            [['descripcion'], 'string'],
            [['solicitud', 'biopsia', 'pap', 'ver_informe_solicitud', 'ver_informe_estudio'], 'boolean'],
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
            'solicitud' => 'Solicitud',
            'biopsia' => 'Biopsia',
            'pap' => 'Pap',
            'ver_informe_solicitud' => 'Ver Informe Solicitud',
            'ver_informe_estudio' => 'Ver Informe Estudio',
        ];
    }
    public function tipoEstados(){

    }
    //hay que eliminar el patron state osea PENDIENTE RECHAZADO EN_PROCESO LISTO

    //Si elimino los estados, tendria que modificar la consulta tengo que quitar los true y consultar por la descripcion
    public function estadosSolicitud(){
        return ArrayHelper::map(Estado::find()->where(['and', "solicitud=true"])
        ->all(), 'id','descripcion');
    }
    public function estadosEstudio(){
      if (Usuario::isPatologo()){
        return ArrayHelper::map(Estado::find()->where(['and', "biopsia=true","pap=true"])
        ->all(), 'id','descripcion');
        }
      else {
        return ArrayHelper::map(Estado::find()->where(['and', "biopsia=true","pap=true","descripcion='PENDIENTE' or descripcion='EN PROCESO' "])
                ->all(), 'id','descripcion');
              }
  }
    public function estadosEstudioAdminYpat(){
        return ArrayHelper::map(Estado::find()->where(['and', "biopsia=true","pap=true"])
        ->all(), 'id','descripcion');
}
}
