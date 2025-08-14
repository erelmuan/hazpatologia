<?php
namespace app\models\patronState;

class EstadoPendiente extends EstadoBase
{
    protected function getDescripcionClave(): string
    {
        return 'PENDIENTE';
    }

    protected function getAllowedTransitions(): array
    {
        return [
            EstadoBase::EN_PROCESO,
            EstadoBase::PENDIENTE,
            EstadoBase::DERIVADO,
            EstadoBase::NO_REALIZADO,
            EstadoBase::LISTO, // Si en tu lógica PENDIENTE también puede ir a LISTO
        ];
    }

    protected function getValidEntityTypes(): array
    {
        return self::ENTITY_ALL; // Todos pueden estar pendientes
    }

    public function canTransitionTo($toStateId, $user, $entity = null): bool
    {
        if (!in_array($toStateId, $this->getAllowedTransitions())) {
            return false;
        }

        // Si la entidad es Solicitudbiopsia o Solicitudpap → no puede ir a EN PROCESO NI LISTO
        if ($entity !== null) {
            $entityClass = get_class($entity);
            if (
                in_array($entityClass, [
                    \app\models\Solicitudbiopsia::class,
                    \app\models\Solicitudpap::class
                ], true)
                && ($toStateId === self::EN_PROCESO || $toStateId === self::LISTO)
            ) {
                return false;
            }
        }
        // Para cualquier otro destino permitido → sí puede
        return true;
    }
    public function isValidForEntityType($entityClass): bool
    {
        if ($entityClass === \app\models\Biopsia::class || $entityClass === \app\models\Pap::class) {
            return false;
        }else {
          return true;
        }
    }

}
