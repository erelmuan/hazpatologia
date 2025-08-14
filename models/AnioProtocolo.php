<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "anio_protocolo".
 *
 * @property Solicitud[] $solicituds
 * @property int $anio
 * @property bool $activo
 * @property int $id
 */
 use app\components\behaviors\AuditoriaBehaviors;

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

    public static function getAnioProtocoloActivo($fecha) {
        $anio = date("Y", strtotime($fecha));
        return AnioProtocolo::find()
        ->where(["anio" =>$anio ,
         "activo"=>true ])->exists();

    }

    public static function anioprotocoloActivo(){
      return AnioProtocolo::find()->where(["activo"=> true ])->one();
    }
    /**
		    * @return \yii\db\ActiveQuery
		    */
		   public function getSolicituds()
		   {
		       return $this->hasMany(Solicitud::className(), ['id_anio_protocolo' => 'id']);
		   }

       public function Estudios()
      {
          if (!isset($this->id)){
            return false;
          }
         return Solicitud::find()
                  ->innerJoinWith('anioProtocolo') // Relación definida en el modelo
                  ->where(['anio_protocolo.id' => $this->id])
                  ->exists();
      }

      public static function aniosDisponibles()
      {
        $anios =[];
          $registros = AnioProtocolo::find()
              ->orderBy('anio DESC')
              ->select(['id', 'anio'])
              ->asArray()
              ->all();
          foreach ($registros as $registro) {
          $anios[$registro['id']] = $registro['anio'];
      }
      return $anios;
    }
}
