<?php

namespace app\models;
use app\components\behaviors\AuditoriaBehaviors;
use Yii;
use yii\helpers\ArrayHelper;


/**
 * This is the model class for table "medico".
 *
 * @property string $apellido
 * @property string $nombre
 * @property int $id
 * @property string $num_documento
 * @property string $matricula
 * @property int $id_tipodoc
 * @property int $id_tipoprofesional
 *
 * @property Tipodoc $tipodoc
 * @property Tipoprofesional $tipoprofesional
 * @property Solicitud[] $solicituds
 */
class Medico extends \yii\db\ActiveRecord
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
        return 'medico';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['apellido', 'nombre'], 'required'],
            [['matricula'], 'string'],
            [['id_tipodoc','tipodoc', 'id_tipoprofesional'], 'default', 'value' => null],
            [['id_tipodoc', 'id_tipoprofesional'], 'integer'],
            [['apellido', 'nombre'], 'string', 'max' => 35],
            [['num_documento'], 'string', 'max' => 15],
            [['id_tipodoc'], 'exist', 'skipOnError' => true, 'targetClass' => Tipodoc::className(), 'targetAttribute' => ['id_tipodoc' => 'id']],
            [['id_tipoprofesional'], 'exist', 'skipOnError' => true, 'targetClass' => Tipoprofesional::className(), 'targetAttribute' => ['id_tipoprofesional' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'apellido' => 'Apellido',
            'nombre' => 'Nombre',
            'id' => 'ID',
            'num_documento' => 'N° doc.',
            'matricula' => 'Matricula',
            'id_tipodoc' => 'Tipo de documento',
            'id_tipoprofesional' => 'Profesión',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipodoc()
    {
        return $this->hasOne(Tipodoc::className(), ['id' => 'id_tipodoc']);
    }

    public function getTipodocs() {
            return ArrayHelper::map(Tipodoc::find()->all(), 'id','documento');

        }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTipoprofesional()
    {
        return $this->hasOne(Tipoprofesional::className(), ['id' => 'id_tipoprofesional']);
    }

    public function getTipoprofesionales() {
            return ArrayHelper::map(Tipoprofesional::find()->all(), 'id','profesion');

        }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSolicituds()
    {
        return $this->hasMany(Solicitud::className(), ['id_medico' => 'id']);
    }
    public function Estudios()
   {
       if (!isset($this->id))
         return false;
     $id= $this->id;
     $estudiosPap = Solicitudpap::find()
      ->innerJoinWith('medico', 'medico.id = solicitudpap.id_medico')
      ->innerJoinWith('pap', 'pap.id_solicitudpap = solicitudpap.id')
      //Estado 2 pap
      ->where(['and', "medico.id=".$id, "pap.id_estado=2"])
      ->count('*');
      if ($estudiosPap >0)
          return true;
      $estudiosBiopsia = Solicitudbiopsia::find()
       ->innerJoinWith('medico', 'medico.id = solicitudbiopsia.id_medico')
       ->innerJoinWith('biopsia', 'biopsia.id_solicitudbiopsia = solicitudbiopsia.id')
       ->where(['and', "medico.id=".$id, "biopsia.id_estado=2"])
       ->count('*');

     if ($estudiosBiopsia >0)
         return true;

     return false;
   }
}
