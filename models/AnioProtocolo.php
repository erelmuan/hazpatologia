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

    public function anioprotocoloActivo(){
      $anioProtocolo = AnioProtocolo::find()->andWhere(['and' ,"activo=true" ])->one();
      return $anioProtocolo ;
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
          if (!isset($this->id))
              return false;
          $id= $this->id;
          $estudios = Solicitud::find()
           ->innerJoinWith('anioProtocolo', 'anio_protocolo.id = solicitud.id_anio_protocolo')
           //Estado 2 pap
           ->where(['and', "anio_protocolo.id=".$id])
           ->count('*');
         if ($estudios >0)
             return true;

        return false;
      }


}
