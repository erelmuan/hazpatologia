<?php

namespace app\modules\estadistica\models;

use yii\base\Model;

class SolicitudesSearch extends Model
{
    public $fechaDesde;
    public $fechaHasta;
    public $procedencia;
    public $tipoEstudio;

    public function rules()
    {
        return [
            [['fechaDesde','fechaHasta'],'safe'],
            [['procedencia','tipoEstudio'],'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'fechaDesde'=>'Fecha desde',
            'fechaHasta'=>'Fecha hasta',
            'procedencia'=>'Procedencia',
            'tipoEstudio'=>'Tipo de estudio',
        ];
    }
}
