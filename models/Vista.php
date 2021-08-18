<?php
/* Modelo generado por Model(Q) */
namespace app\models;

use Yii;
//
use app\components\Metodos\Metodos;

/**
 * This is the model class for table "vista".
 *
 * @property int $id
 * @property int $id_usuario
 * @property string $modelo
 * @property string $columna
 */
class Vista extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vista';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_usuario', 'modelo', 'columna'], 'required'],
            [['id_usuario'], 'integer'],
            [['modelo'], 'string', 'max' => 100],
            [['columna'], 'string', 'max' => 5000],
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
            'modelo' => 'Modelo',
            'columna' => 'Columna',
        ];
    }
    public function attributePrint()
    {
        return [
			'id' => array('vista.id', 20),
			'id_usuario' => array('vista.id_usuario', 20),
			'modelo' => array('vista.modelo', 20),
			'columna' => array('vista.columna', 20),
        ];
    }

    public function attributeView()
    {
        return [
			'id',
			'id_usuario',
			'modelo',
			'columna',
        ];
    }

    public function attributeColumns()
    {
        return [
			// [
				// 'class'=>'\kartik\grid\DataColumn',
				// 'attribute'=>'id',
				// 'width'=>'30px',
				// ],
			[
				'class'=>'\kartik\grid\DataColumn',
				'attribute'=>'id_usuario',
			],
			[
				'class'=>'\kartik\grid\DataColumn',
				'attribute'=>'modelo',
			],
			[
				'class'=>'\kartik\grid\DataColumn',
				'attribute'=>'columna',
			],
        ];
    }




    public function afterFind(){

        // tareas despues de encontrar el objeto
        parent::afterFind();
    }

    public function beforeSave($insert)
    {
        // tareas antes de encontrar el objeto
        if (parent::beforeSave($insert)) {
            // Place your custom code here
            return true;
        } else {
            return false;
        }
    }
}
