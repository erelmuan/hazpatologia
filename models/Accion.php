<?php
namespace app\models;
use Yii;
/**
 * This is the model class for table "accion".
 *
 * @property int $id
 * @property bool $index
 * @property bool $create
 * @property bool $delete
 * @property bool $update
 * @property bool $view
 * @property bool $export
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
        return [[['index', 'create', 'delete', 'update', 'export', 'view'], 'boolean'],
         [['index', 'create', 'delete', 'update', 'export', 'view'], 'unique',
          'targetAttribute' => ['index', 'create', 'delete', 'update', 'export', 'view']], ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return ['id' => 'id',
        'index' => 'Index',
        'create' => 'Crear',
        'delete' => 'Eliminar',
        'update' => 'Actualizar',
        'export' => 'Exportar',
        'view' => 'Ver', ];
    }
    public function attributeColumns() {
        return [['class' => '\kartik\grid\DataColumn', 'attribute' => 'id', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Index', 'trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'index', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Alta','trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'create', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Borrar','trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'delete', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Modificar','trueLabel' => 'Sí','falseLabel' => 'No', 'attribute' => 'update', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Exportar', 'trueLabel' => 'Sí','falseLabel' => 'No','attribute' => 'export', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Ver', 'trueLabel' => 'Sí','falseLabel' => 'No','attribute' => 'view', ]];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisos() {
        return $this->hasMany(Permiso::className() , ['id' => 'id_accion']);
    }
}
