<?php
namespace app\models\patronState;

abstract class EstadoBase implements State
{
  // Constantes para IDs de estados
     public const EN_PROCESO = 1;
     public const LISTO = 2; // Estado final para cuando el patólogo termina
     public const DERIVADO = 3;
     public const NO_REALIZADO = 4;
     public const PENDIENTE = 5;
     public const ANULADO = 6;
     public const DERIVADO_LISTO = 7;
     public const DERIVADO_NO_REALIZADO = 8;

    protected $modelo;

    public function __construct($modelo)
    {
        $this->modelo = $modelo;
    }

    public function getName(): string
    {
        return $this->modelo->descripcion;
    }

    abstract protected function getDescripcionClave(): string;

    abstract protected function getAllowedTransitions(): array;

    public function canTransitionTo($toStateId, $user, $entity = null): bool
    {
        return in_array($toStateId, $this->getAllowedTransitions(), true);
    }

    public function isValidForEntityType($entityClass): bool
    {
        // Por defecto todos los estados son válidos para todas las entidades
        return true;
    }

    public function onEnter($entity): void {}
    public function onExit($entity): void {}
}
