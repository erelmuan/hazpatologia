<?php

namespace app\modules\estadistica\services;

use app\models\Solicitud;
use app\modules\estadistica\models\SolicitudesSearch;
use yii\db\Expression;

class ReporteSolicitudesService
{
    public function buscar(SolicitudesSearch $search)
    {
        $query = Solicitud::find()
            ->alias('s')
            ->select([
                'procedencia' => 'p.nombre',

                'biopsias' => new Expression("
                    COUNT(
                        CASE
                            WHEN s.id_estudio = 1 THEN 1
                        END
                    )
                "),

                'pap' => new Expression("
                    COUNT(
                        CASE
                            WHEN s.id_estudio = 2 THEN 1
                        END
                    )
                "),

                'total' => new Expression("COUNT(*)"),
            ])
            ->innerJoin('procedencia p', 'p.id = s.id_procedencia');

        if (!empty($search->fechaDesde) && !empty($search->fechaHasta)) {
            $query->andWhere([
                'between',
                's.fechadeingreso',
                $search->fechaDesde,
                $search->fechaHasta,
            ]);
        }

        if (!empty($search->procedencia)) {
            $query->andWhere([
                's.id_procedencia' => $search->procedencia,
            ]);
        }

        $query->groupBy([
            'p.id',
            'p.nombre',
        ]);

        $query->orderBy([
            'p.nombre' => SORT_ASC,
        ]);

        return $query->asArray()->all();
    }
}
