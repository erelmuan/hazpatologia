<?php
namespace app\models\patronState;

use app\models\Estado;

class EstadoFactory
{
    private static array $instances = [];

    public static function make($id): State
    {
        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }

        $modelo = Estado::findOne($id);
        if (!$modelo) {
            throw new \Exception("Estado no encontrado con ID: $id");
        }

        return self::makeFromModel($modelo);
    }

    public static function makeFromModel($modelo): State
    {
        $id = $modelo->id;

        if (isset(self::$instances[$id])) {
            return self::$instances[$id];
        }

        $instance = match($modelo->descripcion) {
            'PENDIENTE'     => new EstadoPendiente($modelo),
            'EN PROCESO'    => new EstadoEnProceso($modelo),
            'LISTO'         => new EstadoListo($modelo),
            'ANULADO'       => new EstadoAnulado($modelo),
            'DERIVADO'      => new EstadoDerivado($modelo),
            'NO REALIZADO'  => new EstadoNoRealizado($modelo),
            'DERIVADO LISTO'  => new EstadoDerivadoListo($modelo),
            'DERIVADO NO REALIZADO'  => new EstadoDerivadoNoRealizado($modelo),

            default         => throw new \Exception("Estado no implementado: {$modelo->descripcion} (ID: $id)"),
        };

        self::$instances[$id] = $instance;
        return $instance;
    }

//Array que se envia para el desplegable en las solicitudes y estudios en la vista
public static function getAvailableTransitions($fromStateId, $user, $entity): array
{
    $available = [];
    $entityClass = get_class($entity);

    // Caso de creación (nuevo registro, sin ID)
    if ($entity->isNewRecord) {
        if ($entityClass === \app\models\Solicitudbiopsia::class || $entityClass === \app\models\Solicitudpap::class) {
          $available[EstadoBase::PENDIENTE]  = 'PENDIENTE';
          $available[EstadoBase::DERIVADO]       = 'DERIVADO';
             return $available;
        }

        if ($entityClass === \app\models\Biopsia::class || $entityClass === \app\models\Pap::class) {
            if ($user->esPatologo()) {
                $available[EstadoBase::EN_PROCESO]  = 'EN PROCESO';
                $available[EstadoBase::LISTO]       = 'LISTO';

            } else {
                $available[EstadoBase::EN_PROCESO]  = 'EN PROCESO';

            }


            return $available;
        }
        if ($entityClass === \app\models\InformeComplementario::class || $entityClass === \app\models\InformeComplementario::class) {
            if ($user->esPatologo()) {
                $available[EstadoBase::EN_PROCESO]  = 'EN PROCESO';
                $available[EstadoBase::LISTO]       = 'LISTO';

            } else {
                $available[EstadoBase::EN_PROCESO]  = 'EN PROCESO';

            }

            return $available;
        }
    }

    //Si se actualiza el registro
    else {

      // Si ya existe → calcular transiciones desde estado actual
      $fromState = self::make($fromStateId);

      // Default: permitir transiciones estándar
      $allStates = Estado::find()->all();

      foreach ($allStates as $estadoModel) {
          $toId = $estadoModel->id;
          // if ($fromStateId === $toId) continue;

          try {
            // Obtiene la instancia de la clase concreta de estado (EstadoPendiente, EstadoListo, etc.)
            // a partir del modelo de base de datos actual ($estadoMode
              $toState = self::makeFromModel($estadoModel);
              // Si existe una entidad (ej. Solicitud, Estudio) y el estado de destino no es válido
              // para ese tipo de entidad, entonces se salta al siguiente
              if ($entity && !$toState->isValidForEntityType($entityClass)) {

                  continue; // Estado no aplicable, pasa al siguiente
              }
              // Si desde el estado actual ($fromState) es posible transicionar al estado destino ($toId)
              // teniendo en cuenta las reglas de negocio y los permisos del usuario y la entidad,
              // entonces se agrega al array de opciones válidas.
              if ($fromState->canTransitionTo($toId, $user, $entity)) {
                  // Guarda la transición disponible en el array, con el id como clave y el nombre del estado como valor
                  $available[$toId] = $toState->getName();
              }
          } catch (\Exception $e) {
              continue;
          }
      }

      return $available;

    }

}

    /**
     * Devuelve los estados válidos en general para un tipo de entidad.
     * Este método puede ser usado internamente como filtro auxiliar.
     */
    public static function getValidStatesForEntity($entityType): array
    {
        $validStates = [];

        $allStates = Estado::find()->all();

        foreach ($allStates as $estadoModel) {
            try {
                $state = self::makeFromModel($estadoModel);

                if ($state->isValidForEntityType($entityType)) {
                    $validStates[$estadoModel->id] = $state->getName();
                }

            } catch (\Exception $e) {
                continue;
            }
        }

        return $validStates;
    }
}
