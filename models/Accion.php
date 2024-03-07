<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "accion".
 *
 * @property int $id
 * @property bool $create
 * @property bool $delete
 * @property bool $update
 * @property bool $view
 *
 * @property Permiso[] $permisos
 */
use app\components\behaviors\AuditoriaBehaviors;
class Accion extends \yii\db\ActiveRecord {

    public function behaviors() {
        return array(
            'AuditoriaBehaviors' => array(
                'class' => AuditoriaBehaviors::className() ,
            ) ,
        );
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'accion';
    }
    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [[['create', 'delete', 'update', 'view'], 'boolean'],
         [[ 'create', 'delete', 'update',  'view'], 'unique',
          'targetAttribute' => [ 'create', 'delete', 'update', 'view']], ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return ['id' => 'id',
        'create' => 'Crear',
        'delete' => 'Eliminar',
        'update' => 'Actualizar',
        'view' => 'Ver', ];
    }
    public function attributeColumns() {
        return [['class' => '\kartik\grid\DataColumn', 'attribute' => 'id', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Alta','trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'create', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Borrar','trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'delete', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Modificar','trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'update', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Ver', 'trueLabel' => 'Sí','falseLabel' => 'No','attribute' => 'view', ]];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisos() {
        return $this->hasMany(Permiso::className() , ['id' => 'id_accion']);
    }
}
