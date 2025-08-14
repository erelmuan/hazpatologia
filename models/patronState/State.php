<?php
namespace app\models\patronState;

interface State
{
   public function getName(): string;
   public function canTransitionTo(int $to, User $user ,$entity): bool;
}
?>
