<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "configuracion".
 *
 * @property int $id
 * @property int $id_tema
 * @property bool $notificacion
 * @property int $id_menu
 *
 * @property Menu $menu
 * @property Tema $tema
 * @property Usuario $usuario
 */
class Configuracion extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'configuracion';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_tema', 'id_menu'], 'default', 'value' => null],
            [['id_tema', 'id_menu'], 'integer'],
            [['id_tema'], 'required', 'message' => 'Debe escoger un tema.'],
            [['id_menu'], 'required', 'message' => 'Debe escoger un menú.'], 
            [['notificacion'], 'boolean'],
            [['id_menu'], 'exist', 'skipOnError' => true, 'targetClass' => Menu::className(), 'targetAttribute' => ['id_menu' => 'id']],
            [['id_tema'], 'exist', 'skipOnError' => true, 'targetClass' => Tema::className(), 'targetAttribute' => ['id_tema' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_tema' => 'Id Tema',
            'notificacion' => 'Notificacion',
            'id_menu' => 'Id Menu',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(Menu::className(), ['id' => 'id_menu']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTema()
    {
        return $this->hasOne(Tema::className(), ['id' => 'id_tema']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsuario()
    {
        return $this->hasOne(Usuario::className(), ['id_configuracion' => 'id']);
    }
}
