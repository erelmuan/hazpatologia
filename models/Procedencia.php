<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "procedencia".
 *
 * @property int $id
 * @property string $nombre
 * @property string $contacto
 * @property string $direccion
 *
 * @property Solicitud[] $solicituds
 * @property Solicitudbiopsia[] $solicitudbiopsias
 * @property Solicitudpap[] $solicitudpaps
 */
 use app\components\behaviors\AuditoriaBehaviors;

class Procedencia extends \yii\db\ActiveRecord
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
        return 'procedencia';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['direccion'], 'string'],
            [['nombre'], 'string', 'max' => 18],
            [['contacto'], 'string', 'max' => 40],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'nombre' => 'Nombre',
            'contacto' => 'Contacto',
            'direccion' => 'Direccion',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_procedencia' => 'id']);
    }
    /**
   		    * @return \yii\db\ActiveQuery
   		    */
   		   public function getSolicitudbiopsias()
   		   {
   		       return $this->hasMany(Solicitudbiopsia::className(), ['id_procedencia' => 'id']);
   		   }

   		   /**
   		    * @return \yii\db\ActiveQuery
   		    */
   		   public function getSolicitudpaps()
   		   {
   		       return $this->hasMany(Solicitudpap::className(), ['id_procedencia' => 'id']);
   		   }
         public function beforeSave($insert){
         //DE FORMA INDIVIDUAL
          if ($insert) {
           $this->nombre = strtoupper($this->nombre);
         }
           return parent::beforeSave($insert);
         }

    public function Estudios()
   {
       if (!isset($this->id))
           return false;
       $id= $this->id;
       $estudiosPap = Solicitudpap::find()
        ->innerJoinWith('procedencia', 'procedencia.id = solicitudpap.id_procedencia')
        ->innerJoinWith('pap', 'pap.id_solicitudpap = solicitudpap.id')
        //Estado 2 pap
        ->where(['and', "procedencia.id=".$id])
        ->count('*');
      if ($estudiosPap >0)
          return true;
      $estudiosBiopsia = Solicitudbiopsia::find()
       ->innerJoinWith('procedencia', 'procedencia.id = solicitudbiopsia.id_procedencia')
       ->innerJoinWith('biopsia', 'biopsia.id_solicitudbiopsia = solicitudbiopsia.id')
       ->where(['and', "procedencia.id=".$id])
       ->count('*');

     if ($estudiosBiopsia >0)
         return true;

     return false;
   }
}
