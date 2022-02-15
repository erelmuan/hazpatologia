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
        return [[['index', 'create', 'delete', 'update', 'export', 'listdetalle'], 'boolean'],
         [['index', 'create', 'delete', 'update', 'export', 'listdetalle'], 'unique',
          'targetAttribute' => ['index', 'create', 'delete', 'update', 'export', 'listdetalle']], ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return ['id' => 'id',
        'index' => 'Index/ver',
        'create' => 'Crear',
        'delete' => 'Eliminar',
        'update' => 'Actualizar',
        'export' => 'Exportar',
        'listdetalle' => 'Ver lista detalle', ];
    }
    public function attributeColumns() {
        return [['class' => '\kartik\grid\DataColumn', 'attribute' => 'id', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Index/Ver', 'attribute' => 'index', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Alta', 'attribute' => 'create', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Borrar', 'attribute' => 'delete', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Modificar', 'attribute' => 'update', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Exportar', 'attribute' => 'export', ],
        ['class' => 'kartik\grid\BooleanColumn', 'label' => 'Listar', 'attribute' => 'listdetalle', ]];
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPermisos() {
        return $this->hasMany(Permiso::className() , ['id' => 'id_accion']);
    }
}
