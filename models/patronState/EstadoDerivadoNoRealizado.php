<?php
namespace app\models\patronState;

class EstadoDerivadoNoRealizado extends EstadoBase
{
    protected function getDescripcionClave(): string
    {
        return 'DERIVADO NO REALIZADO';
    }

    protected function getAllowedTransitions(): array
    {
        return [
          EstadoBase::DERIVADO_NO_REALIZADO,
        ];
    }
    public function isValidForEntityType($entityClass): bool
    {
        // Por defecto todos los estados son válidos para todas las entidades
        if ($entityClass === \app\models\Biopsia::class || $entityClass === \app\models\Pap::class) {
            return false;
        }else {
          return true;
        }
    }

}
 ?>
