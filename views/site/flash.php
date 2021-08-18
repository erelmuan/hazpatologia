
<?php
use kartik\widgets\Alert;
echo Alert::widget([
    'type' => Alert::TYPE_INFO,
    'title' => 'Heads up!',
      'icon' => 'fas fa-ok-circle',
    'body' => 'This alert needs your attention, but it\'s not super important.',
    'showSeparator' => true,
    'delay' => 1000
]);
 ?>
