<?php
namespace app\models\patronState;

class EstadoAnulado extends EstadoBase
{
    protected function getDescripcionClave(): string
    {
        return [
            EstadoBase::ANULADO,
        ];
    }

    protected function getAllowedTransitions(): array
    {
        return []; // Estado final
    }
}

 ?>
