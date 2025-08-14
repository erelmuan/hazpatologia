<?php
namespace app\models\patronState;

use Yii;

class EstadoEnProceso extends EstadoBase
{
    protected function getDescripcionClave(): string
    {
        return 'EN PROCESO';
    }

    protected function getAllowedTransitions(): array
    {
        return [
            EstadoBase::LISTO,
            EstadoBase::EN_PROCESO,
            // EstadoBase::PENDIENTE,
        ];
    }

    public function canTransitionTo($toStateId, $user, $entity = null): bool
    {
        // Si el destino no está permitido en este estado, no continuar
        if (!in_array($toStateId, $this->getAllowedTransitions(), true)) {
            return false;
        }

        // 🚫 Si el destino es LISTO y el usuario NO es patólogo, no se permite
        if ($toStateId === self::LISTO && !$user->esPatologo()) {
            return false;
        }

        // 👇 (Opcional) Si la entidad es una solicitud y se intenta ir a LISTO, también no se permite
        if ($entity !== null) {
            $entityClass = get_class($entity);
            if (
                in_array($entityClass, [
                    \app\models\Solicitudbiopsia::class,
                    \app\models\Solicitudpap::class
                ], true)
                && $toStateId === self::LISTO
            ) {
                return false;
            }
        }

        // Si no hay ninguna restricción → sí puede
        return true;
    }

}
