<?php
use yii\helpers\Url;
use yii\widgets\DetailView;
use yii\helpers\Html;

 ?>
<div class="row">
  <div class="col-sm-5">
    <div class="form-group highlight-addon">
      <label class="control-label has-star" for="paciente">PACIENTE</label>
        <input class="form-control"   value=" <? echo ($solicitud->paciente->apellido.", ".$solicitud->paciente->nombre);?>"
 readOnly/>
        </input>
        <p class="help-block help-block-error"></p>
    </div>
  </div>
  <div class="col-sm-3">
    <div class="form-group highlight-addon field-solicitudb-dni">
    <label class="control-label has-star" for="solicitudb-dni">Modificar Paciente</label>
    <center>
    <?=Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['paciente/update', 'id'=>$solicitud->paciente->id],
     ['title'=> 'Modificación','class'=>'btn btn-primary btn-xs', 'target'=>'_blank' ]);?>
   </center>
         <p class="help-block help-block-error"></p>
    </div>
	</div>

</div>
<div class="row">
<div class="col-sm-4">
  <div class="form-group highlight-addon field-solicitudb-dni">
    <label class="control-label has-star" for="dni">DNI</label>
      <input class="form-control" size="" id="documento"  value=<?=$solicitud->paciente->num_documento ?> readOnly/>
      <p class="help-block help-block-error"></p>
  </div>
</div>
</div>
<div class="row">
  <div class="form-row mt-8">
      <div class="col-lg-9 pb-5">
        <div class="nav navbar-left panel_toolbox">
              <button type="button" class="btn btn-primary btn-xs" onclick="pucoAjax()" ><i
                      class="glyphicon glyphicon-plus"></i>Consultar al PUCO</button>
        </div>
        <textarea id="resultadoPuco"  class="form-control" name="resultado"  cols="50" rows="4" style="resize: both;" placeholder="Resultado puco"></textarea>
      </div>

    </div>
</div>
<div class="row">
  <div class="form-row mt-8">
      <div class="col-lg-9 pb-5">
        <div class="nav navbar-left panel_toolbox">
          <b>  OBRAS SOCIALES </b>
          <p class="help-block help-block-error"></p>
        </div>
      </div>

    </div>
</div>
<div class="table-responsive">
<table class="table table-striped jambo_table bulk_action">
<thead>
<tr class="headings">
<th class="column-title">Obra social </th>
<th class="column-title">Nª de afiliado </th>
<th class="column-title no-link last"><span class="nobr">Acción</span>
</th>
<th class="bulk-actions" colspan="7">
<a class="antoo" style="color:#fff; font-weight:500;">Bulk Actions ( <span class="action-cnt"> </span> ) <i class="fa fa-chevron-down"></i></a>
</th>
</tr>
</thead>
<tbody>
 <tr class="even pointer">
   <? foreach ($solicitud->paciente->carnetOs as $carnet) {
       echo "<tr>";
        echo "<td>";
           echo $carnet->obrasocial->denominacion ;
        echo "</td>";
        echo "<td>";
           echo $carnet->nroafiliado;
        echo "</td>";
        echo "<td>";
        if($solicitud->estado->descripcion!=="LISTO"){
          echo "Debe estar LISTO el estudio";
        }else {
          echo  Html::a('<i class="fa fa-file-pdf-o"> Planilla FOS</i>', ['solicitud/fos','tipoSolicitud'=>$tipoSolicitud, 'id'=>$solicitud->id, 'id_carnet' => $carnet->id],
           ['title'=> 'Generar pdf','class'=>'btn btn-danger btn-xs', 'target'=>'_blank' ]);
        }

        echo "</td>";
       echo "</tr>";
 }
   ?>

</tr>
</tbody>
</table>

</div>
<script>
  function pucoAjax() {
      var dni_paciente = document.getElementById('documento').value;
      document.getElementById("resultadoPuco").value ="";
      document.getElementById("resultadoPuco").placeholder ="Espere, buscando en el puco";
      $.ajax({
        url: '<?php echo Url::to(['/paciente/puco']) ?>',
          type: 'post',
          data: {
              dni: dni_paciente
          },
          success: function(data) {
              document.getElementById("resultadoPuco").value="";
              var content = JSON.parse(data);
                  document.getElementById("resultadoPuco").value = content[0];

          }

      });
  }

</script>
