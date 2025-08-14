<?php
namespace app\models\patronState;


class EstadoListo extends EstadoBase
{
    protected function getDescripcionClave(): string
    {
        return 'LISTO';
    }

    protected function getAllowedTransitions(): array
    {
      return [
          EstadoBase::ANULADO,
          EstadoBase::LISTO,
      ];
    }
    public function canTransitionTo($toStateId, $user, $entity = null): bool
    {
        if (!in_array($toStateId, $this->getAllowedTransitions())) {
            return false;
        }
        // La entidad es una Solicitudbiopsia o Solicitudpap
        // El estado destino es ANULADO
        // entonces no se permite la transición y devuelve false
        if ($entity !== null) {
            $entityClass = get_class($entity);
            if (in_array($entityClass, [
                    \app\models\Solicitudbiopsia::class,
                    \app\models\Solicitudpap::class
                ], true)
                && $toStateId === self::ANULADO ) {
                return false;
            }
        }

        if($toStateId=== self::ANULADO && !$user->esPatologo()){
          return false;
        }
        // Para cualquier otro destino permitido → sí puede
        return true;
    }

}

 ?>
