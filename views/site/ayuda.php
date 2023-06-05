<?

use yii\helpers\Url;
?>
<div id="w0" class="x_panel">

<div class="col-sm-6 col-sm-8 col-dm-9 form-group">
  <label> Manual de usuario </label>
  <p>
        <iframe src=<?=Url::base().'/uploads/tutorial/'. str_replace("+", "%20",urlencode("MANUAL DE USUARIO PATOLOGIA.pdf")) ?> height="800" width="1000"></iframe>

    </p>
  </div>
</div>
