<?php

namespace app\models;

use Yii;
use app\models\patronState\EstadoBase;

/**
 * This is the model class for table "informe_complementario".
 *
 * @property int $id
 * @property int $id_biopsia
 * @property string $descripcion
 * @property string $fecha_listo
 * @property int $id_estado
 * @property Biopsia $biopsia
 * @property int $id_usuario
 * @property Estado $estado
 * @property Usuario $usuario
 */
 use app\components\behaviors\AuditoriaBehaviors;

class InformeComplementario extends \yii\db\ActiveRecord
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
        return 'informe_complementario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_biopsia', 'descripcion', 'id_estado'], 'required'],
            [['id_biopsia', 'id_estado', 'id_usuario'], 'default', 'value' => null],
            [['id_biopsia', 'id_estado', 'id_usuario'], 'integer'],
            [['descripcion'], 'string'],
            [['fecha_listo'], 'safe'],
            [['id_biopsia'], 'unique'],
            [['id_biopsia'], 'exist', 'skipOnError' => true, 'targetClass' => Biopsia::className(), 'targetAttribute' => ['id_biopsia' => 'id']],
            [['id_estado'], 'exist', 'skipOnError' => true, 'targetClass' => Estado::className(), 'targetAttribute' => ['id_estado' => 'id']],
            [['id_usuario'], 'exist', 'skipOnError' => true, 'targetClass' => Usuario::className(), 'targetAttribute' => ['id_usuario' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_biopsia' => 'Id Biopsia',
            'descripcion' => 'Descripcion',
            'fecha_listo' => 'Fecha Listo',
            'id_estado' => 'Estado',
        ];
    }
    public function estaListo(): bool
    {
      //SI O SI,
        return (int)$this->id_estado === EstadoBase::LISTO;
    }
    public function estaEnproceso():bool
    {
      return (int)$this->id_estado === EstadoBase::EN_PROCESO;
    }
    public function estaAnulado(){
      return (int)$this->id_estado === EstadoBase::ANULADO;
    }

    
    public function beforeSave($insert)
  {
      if (!parent::beforeSave($insert)) {
          return false;
      }
      if ($this->estaListo()) {
          $this->fecha_listo = date('Y-m-d H:i:s');
          $this->id_usuario = Yii::$app->user->id;
      }
      if ($this->estaAnulado()) {
          $this->biopsia->id_estado = EstadoBase::ANULADO;

          if (!$this->biopsia->save(false)) {
              return false;
          }
          $this->biopsia->solicitudbiopsia->id_estado = EstadoBase::ANULADO;
          if (!$this->biopsia->solicitudbiopsia->save(false)) {
              return false;
          }
      }
      return true;
  }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstado()
    {
        return $this->hasOne(Estado::className(), ['id' => 'id_estado']);
    }
    /**
       * @return \yii\db\ActiveQuery
       */
      public function getBiopsia()
      {
        return $this->hasOne(Biopsia::className(), ['id' => 'id_biopsia']);
      }

   /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }
}
