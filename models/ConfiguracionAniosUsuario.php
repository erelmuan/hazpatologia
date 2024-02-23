<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuracion_anios_usuario".
 *
 * @property int $id
 * @property int $id_usuario
 * @property int $id_anio_protocolo
 * @property int $id_estudio
 *
 * @property AnioProtocolo $anioProtocolo
 * @property Estudio $estudio
 * @property Usuario $usuario
 */
class ConfiguracionAniosUsuario extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuracion_anios_usuario';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'id_anio_protocolo', 'id_estudio'], 'required'],
            [['id_usuario', 'id_anio_protocolo', 'id_estudio'], 'default', 'value' => null],
            [['id_usuario', 'id_anio_protocolo', 'id_estudio'], 'integer'],
            [['id_anio_protocolo'], 'exist', 'skipOnError' => true, 'targetClass' => AnioProtocolo::className(), 'targetAttribute' => ['id_anio_protocolo' => 'id']],
            [['id_estudio'], 'exist', 'skipOnError' => true, 'targetClass' => Estudio::className(), 'targetAttribute' => ['id_estudio' => 'id']],
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
            'id_usuario' => 'Id Usuario',
            'id_anio_protocolo' => 'Id Anio Protocolo',
            'id_estudio' => 'Id Estudio',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAnioProtocolo()
    {
        return $this->hasOne(AnioProtocolo::className(), ['id' => 'id_anio_protocolo']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getEstudio()
    {
        return $this->hasOne(Estudio::className(), ['id' => 'id_estudio']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id' => 'id_usuario']);
    }

    public static function getSeleccionAnios($id_usuario, $id_estudio)
    {
            return self::find()
            ->select('id_anio_protocolo')
            ->andWhere(['id_usuario' => $id_usuario])
            ->andWhere(['id_estudio' => $id_estudio])
            ->column();
    }
}
