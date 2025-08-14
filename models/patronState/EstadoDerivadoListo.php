<?php
namespace app\models\patronState;

class EstadoDerivadoListo extends EstadoBase
{
    protected function getDescripcionClave(): string
    {
        return 'DERIVADO LISTO';
    }

    protected function getAllowedTransitions(): array
    {
        return [
          EstadoBase::DERIVADO,
          EstadoBase::DERIVADO_LISTO,
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
