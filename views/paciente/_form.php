<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
// use yii\bootstrap\ActiveForm; //used to enable bootstrap layout options
use kartik\date\DatePicker;
use yii\widgets\MaskedInput;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use app\models\Provincia;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\datecontrol\DateControl;
use app\widgets\CustomDynamicFormWidget;
?>
<?php
// ── Alpine.js CDN ─────────────────────────────────────────────────────────────
$this->registerJsFile(
    'https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js',
    ['defer' => true, 'position' => \yii\web\View::POS_HEAD]
);

// ── Datos iniciales para Alpine ───────────────────────────────────────────────
// Obras sociales: repoblar si POST fallido
$obrasSocialesData = [];
if (!empty($estructuraArray['valorObrasocial'])) {
    foreach ($estructuraArray['valorObrasocial'] as $key => $idOs) {
        $obrasSocialesData[] = [
            'id'           => null,
            'id_obrasocial'=> $idOs,
            'nroafiliado'  => $estructuraArray['afiliado'][$idOs] ?? '',
            '_uid'         => uniqid('os_'),
            'errors'       => (object)[],
        ];
    }
}
$obrasSocialesJson = json_encode($obrasSocialesData);
$obrasocialesOptsJson = json_encode($estructuraArray['obrasociales']);
// Si es GET (create) → vacío. Si es POST fallido → repobla con datos + errores del modelo.
$domiciliosData = [];
if (!empty($modelsDomicilios)) {
    foreach ($modelsDomicilios as $m) {
        // Solo incluir si tiene datos cargados (POST fallido) o es registro existente
        if (!$m->isNewRecord || $m->hasErrors() || !empty(array_filter((array)$m->attributes))) {
            $domiciliosData[] = [
                'id'           => $m->id ?? null,
                'tipodom'      => $m->tipodom ?? '',
                'calle'        => $m->calle ?? '',
                'numero'       => $m->numero ?? '',
                'piso'         => $m->piso ?? '',
                'departamento' => $m->departamento ?? '',
                'id_provincia' => $m->id_provincia ?? 22,
                'id_localidad' => $m->id_localidad ?? 2845,
                'codigopostal' => $m->codigopostal ?? '',
                'id_barrio'    => $m->id_barrio ?? null,
                'principal'    => (bool)($m->principal ?? false),
                'fechabaja'    => $m->fechabaja ?? '',
                'localidades'        => [],
                'barrios'            => [],
                'loadingLocalidades' => false,
                'loadingBarrios'     => false,
                '_uid'               => uniqid('dom_'),
                'errors'             => (object)$m->errors,  // errores por campo de Yii2
            ];
        }
    }
}
$domiciliosJson = json_encode($domiciliosData);

$contactosData = [];
if (!empty($modelsContactos)) {
    foreach ($modelsContactos as $m) {
        if (!$m->isNewRecord || $m->hasErrors() || !empty(array_filter((array)$m->attributes))) {
            $contactosData[] = [
                'id'              => $m->id ?? null,
                'id_tipocontacto' => $m->id_tipocontacto ?? '',
                'valor'           => $m->valor ?? '',
                'id_tipouso'      => $m->id_tipouso ?? '',
                'fechabaja'       => $m->fechabaja ?? '',
                '_uid'            => uniqid('con_'),
                'errors'          => (object)$m->errors,  // errores por campo de Yii2
            ];
        }
    }
}
$contactosJson = json_encode($contactosData);

// Arrays de opciones para los selects de domicilio
$tipoDomiciliosJson  = json_encode($estructuraArray['tipoDomicilios']);
$provinciasJson      = json_encode($estructuraArray['provincias']);
$tiposContactoJson   = json_encode($estructuraArray['tiposContacto']);
$tiposUsoJson        = json_encode($estructuraArray['tiposUso']);

// Obras sociales: repobla si POST fallido, vacío en GET
$obrasocialesData = [];
if (!empty($modelsCarnetOs)) {
    foreach ($modelsCarnetOs as $m) {
        if (!$m->isNewRecord || $m->hasErrors() || !empty(array_filter((array)$m->attributes))) {
            $obrasocialesData[] = [
                'id'            => $m->id ?? null,
                'id_obrasocial' => $m->id_obrasocial ?? '',
                'nroafiliado'   => $m->nroafiliado ?? '',
                '_uid'          => uniqid('os_'),
                'errors'        => (object)$m->errors,
            ];
        }
    }
}
$obrasocialesJson = json_encode($obrasocialesData);

// Opciones del select de obra social para el dropdown Alpine
$osOpcionesJson = json_encode(
    array_map(function($id, $nombre) {
        return ['id' => $id, 'nombre' => $nombre];
    }, array_keys($estructuraArray['obrasociales']), array_values($estructuraArray['obrasociales']))
);
?>

<?= Html::cssFile('@web/css/paciente.css') ?>

<div class="x_panel">
  <div class="paciente-form">

    <?php if($model->estudios()): ?>
      <div class="note-warning">
        <strong>Advertencia:</strong>
        La modificación del <b>nombre, apellido, dni o historia clínica</b> impactará en todos los estudios anteriores del paciente.
        <span style="font-weight:700"> (NO CAMBIE LA IDENTIDAD DEL MISMO)</span>
      </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'options' => ['accept-charset' => 'UTF-8']
    ]); ?>

    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- SECCIÓN: Datos filiatorios  (sin cambios)                         -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <div class="section-card">
      <div class="card-header">
        <i class="glyphicon glyphicon-user legend-icon"></i> Datos filiatorios
        <span class="section-legend">Identidad</span>
      </div>
      <div class="card-body">
        <div class="panel-body">

          <div class="row field-compact">
            <div class="col-sm-4 pb-3">
              <?php if($model->estudios()): ?>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'readonly' => true]) ?>
              <?php else: ?>
                <?= $form->field($model, 'nombre')->textInput(['maxlength' => true, 'style' => 'width:100%; text-transform:uppercase;']) ?>
              <?php endif; ?>
            </div>
            <div class="col-sm-4 pb-3">
              <?php if($model->estudios()): ?>
                <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'readonly' => true]) ?>
              <?php else: ?>
                <?= $form->field($model, 'apellido')->textInput(['maxlength' => true, 'style' => 'width:100%; text-transform:uppercase;']) ?>
              <?php endif; ?>
            </div>
            <div class="col-sm-4 pb-3">
              <?php if($model->estudios()): ?>
                <?= $form->field($model, 'fecha_nacimiento')->widget(DateControl::classname(), [
                  'options'       => ['placeholder' => 'Debe agregar una fecha', 'value' => $model->fecha_nacimiento ?: ''],
                  'type'          => DateControl::FORMAT_DATE,
                  'displayFormat' => 'php:d/m/Y',
                  'saveFormat'    => 'php:Y-m-d',
                  'readonly'      => true,
                  'widgetOptions' => ['pluginOptions' => ['disabled' => true, 'autoclose' => true, 'todayHighlight' => true, 'keyboardNavigation' => false, 'enableOnReadonly' => false, 'removeButton' => false]],
                ])->label('Fecha de nacimiento') ?>
              <?php else: ?>
                <?= $form->field($model, 'fecha_nacimiento')->widget(DateControl::classname(), [
                  'options'       => ['placeholder' => 'Debe agregar una fecha', 'value' => $model->fecha_nacimiento ?: ''],
                  'type'          => DateControl::FORMAT_DATE,
                  'autoWidget'    => true,
                  'displayFormat' => 'php:d/m/Y',
                  'saveFormat'    => 'php:Y-m-d',
                ])->label('Fecha de nacimiento') ?>
              <?php endif; ?>
            </div>
          </div>

          <div class="row field-compact">
            <div class="col-sm-2 pb-5">
              <?= $form->field($model, 'id_tipodoc')->dropDownList($estructuraArray['tipoDocumentos'])->label('Tipo Doc.') ?>
            </div>
            <div class="col-sm-3 pb-5">
              <label class="control-label d-flex align-items-center" for="paciente-num_documento" style="margin-bottom:2px;">
                N° doc.
                <button type="button" class="btn btn-info btn-xs btn-renaper ml-2" id="btnRenaper"
                        onclick="consultarRenaper()" title="Consultar Renaper"
                        <?= $model->estudios() > 0 ? 'disabled' : '' ?>>R</button>
              </label>
              <?php if($model->estudios()): ?>
                <?= $form->field($model, 'num_documento')->textInput(['maxlength' => true, 'readonly' => true])->label(false) ?>
              <?php else: ?>
                <?= $form->field($model, 'num_documento')->textInput(['maxlength' => true, 'style' => 'width:100%; text-transform:uppercase;'])->label(false) ?>
              <?php endif; ?>
            </div>
            <div class="col-sm-2 pb-5">
              <?= $form->field($model, 'hc')->textInput(['maxlength' => true])->label('Nº HC') ?>
            </div>
            <div class="col-sm-1 pb-5">
              <?= $form->field($model, 'sexo')->dropDownList(['F' => 'F', 'M' => 'M'])->label('Sexo') ?>
            </div>
            <div class="col-sm-2 pb-5">
              <?= $form->field($model, 'genero')->dropDownList($estructuraArray['generos'])->label('Género') ?>
            </div>
            <div class="col-sm-2 pb-4">
              <?= $form->field($model, 'id_nacionalidad')->dropDownList($estructuraArray['nacionalidades'])->label('Nacionalidad') ?>
            </div>
          </div>

        </div>
      </div>
    </div>
    <!-- /Datos filiatorios -->


    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- SECCIÓN: Domicilio  ← ALPINE.JS                                   -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <div class="section-card">
      <div class="card-body">
        <fieldset class="border p-3 mt-3">

          <div x-data="domicilioForm()" x-init="init()">

            <!-- Header -->
            <div class="card-header">
              <i class="glyphicon glyphicon-home legend-icon"></i> Datos de domicilio
              <span class="section-legend">Residencia</span>
              <button type="button"
                      @click="agregar()"
                      :disabled="items.length >= 3"
                      class="btn btn-success btn-xs rounded-circle"
                      style="width:28px;height:28px;">
                <i class="glyphicon glyphicon-plus"></i>
              </button>
              <small x-show="items.length >= 3" class="text-muted ml-2">Máximo 3 domicilios</small>
            </div>

            <!-- Sin items -->
            <div x-show="items.length === 0" class="text-muted text-center p-3">
              <i class="glyphicon glyphicon-home"></i> No hay domicilios. Usá el botón + para agregar.
            </div>

            <!-- Items dinámicos -->
            <template x-for="(item, i) in items" :key="item._uid">
              <div class="item-domicilio panel panel-default mb-3">

                <div class="panel-heading d-flex justify-content-end">
                  <button type="button"
                          @click="eliminar(item._uid)"
                          class="btn btn-danger btn-xs">
                    <i class="glyphicon glyphicon-trash"></i>
                  </button>
                </div>

                <div class="panel-body">

                  <!-- Hidden ID para registros existentes -->
                  <template x-if="item.id">
                    <input type="hidden" :name="`Domicilio[${i}][id]`" :value="item.id">
                  </template>

                  <!-- Fila 1: tipo(2) | calle(3) | numero(2) | piso(1) | depto(1) | provincia(3) -->
                  <div class="row field-compact">
                    <div :class="item.errors?.id_tipodom ? 'col-sm-2 pb-3 has-error' : (item.id_tipodom ? 'col-sm-2 pb-3 has-success' : 'col-sm-2 pb-3')">
                      <label class="control-label">Tipo domicilio</label>
                      <select :name="`Domicilio[${i}][id_tipodom]`"
                              x-model="item.id_tipodom"
                              @change="if(item.errors) delete item.errors.id_tipodom"
                              class="form-control">
                        <option value="">Elegir...</option>
                        <?php foreach ($estructuraArray['tipoDomicilios'] as $k => $v): ?>
                          <option value="<?= $k ?>"><?= Html::encode($v) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <p x-show="item.errors?.id_tipodom" x-text="item.errors?.id_tipodom?.[0]" class="help-block"></p>
                    </div>
                    <div :class="item.errors?.calle ? 'col-sm-3 pb-3 has-error' : (item.calle ? 'col-sm-3 pb-3 has-success' : 'col-sm-3 pb-3')">
                      <label class="control-label">Calle</label>
                      <input type="text"
                             :name="`Domicilio[${i}][calle]`"
                             x-model="item.calle"
                             @input="if(item.errors) delete item.errors.calle"
                             class="form-control"
                             style ="width:100%; text-transform:uppercase;"
                             maxlength="255">
                      <p x-show="item.errors?.calle" x-text="item.errors?.calle?.[0]" class="help-block"></p>
                    </div>
                    <div :class="item.errors?.numero ? 'col-sm-2 pb-3 has-error' : (item.numero ? 'col-sm-2 pb-3 has-success' : 'col-sm-2 pb-3')">
                      <label class="control-label">Número</label>
                      <input type="text"
                             :name="`Domicilio[${i}][numero]`"
                             x-model="item.numero"
                             @input="if(item.errors) delete item.errors.numero"
                             class="form-control"
                             maxlength="20">
                      <p x-show="item.errors?.numero" x-text="item.errors?.numero?.[0]" class="help-block"></p>
                    </div>
                    <div class="col-sm-1 pb-3">
                      <label class="control-label">Piso</label>
                      <input type="text"
                             :name="`Domicilio[${i}][piso]`"
                             x-model="item.piso"
                             @input="if(item.errors) delete item.errors.piso"
                             class="form-control"
                             maxlength="10">
                    </div>
                    <div class="col-sm-1 pb-3">
                      <label class="control-label">Depto.</label>
                      <input type="text"
                             :name="`Domicilio[${i}][departamento]`"
                             x-model="item.departamento"
                             @input="if(item.errors) delete item.errors.departamento"
                             class="form-control"
                             maxlength="10">
                    </div>
                    <div :class="item.errors?.id_provincia ? 'col-sm-3 pb-3 has-error' : (item.id_provincia ? 'col-sm-3 pb-3 has-success' : 'col-sm-3 pb-3')">
                      <label class="control-label">Provincia</label>
                      <select :name="`Domicilio[${i}][id_provincia]`"
                              @change="item.id_provincia = $event.target.value; cargarLocalidades(i); if(item.errors) delete item.errors.id_provincia"
                              class="form-control">
                        <option value="">Por favor elija una</option>
                        <?php foreach ($estructuraArray['provincias'] as $k => $v): ?>
                          <option value="<?= $k ?>"
                                  :selected="String(item.id_provincia) === '<?= $k ?>'"><?= Html::encode($v) ?></option>
                        <?php endforeach; ?>
                      </select>
                      <p x-show="item.errors?.id_provincia" x-text="item.errors?.id_provincia?.[0]" class="help-block"></p>
                    </div>
                  </div>

                  <!-- Fila 2: localidad(3) | CP(1) | barrio(3) | principal(1) | fechabaja(4) -->
                  <div class="row field-compact" style="margin-top:10px;">

                    <!-- localidad(3) -->
                    <div :class="item.errors?.id_localidad ? 'col-sm-3 pb-3 has-error' : (item.id_localidad ? 'col-sm-3 pb-3 has-success' : 'col-sm-3 pb-3')">
                      <label class="control-label">Localidad</label>
                      <select :name="`Domicilio[${i}][id_localidad]`"
                              @change="cambiarLocalidad(i, $event.target.value)"
                              :disabled="item.loadingLocalidades || item.localidades.length === 0"
                              class="form-control">
                        <option value="">Por favor elija una</option>
                        <template x-for="loc in item.localidades" :key="loc.id">
                          <option :value="loc.id"
                                  :selected="String(loc.id) === String(item.id_localidad)"
                                  x-text="loc.nombre"></option>
                        </template>
                      </select>
                      <small x-show="item.loadingLocalidades" class="text-muted">
                        <i class="glyphicon glyphicon-refresh"></i> Cargando...
                      </small>
                      <p x-show="item.errors?.id_localidad" x-text="item.errors?.id_localidad?.[0]" class="help-block"></p>
                    </div>

                    <!-- CP(1) — input angosto para 4 caracteres -->
                    <div :class="item.errors?.codigopostal ? 'col-sm-1 pb-3 has-error' : (item.codigopostal ? 'col-sm-1 pb-3 has-success' : 'col-sm-1 pb-3')">
                      <label class="control-label">CP</label>
                      <input type="text"
                             :name="`Domicilio[${i}][codigopostal]`"
                             x-model="item.codigopostal"
                             @input="if(item.errors) delete item.errors.codigopostal"
                             class="form-control"
                             style="width:75px;"
                             maxlength="10">
                      <p x-show="item.errors?.codigopostal" x-text="item.errors?.codigopostal?.[0]" class="help-block"></p>
                    </div>

                    <!-- Barrio(4) -->
                    <div :class="item.errors?.id_barrio ? 'col-sm-4 pb-3 has-error' : (item.id_barrio ? 'col-sm-4 pb-3 has-success' : 'col-sm-4 pb-3')"
                         style="padding-left:20px;"
                         x-data="{ open: false, search: '' }"
                         @click.outside="open = false">
                      <label class="control-label">Barrio</label>
                      <div class="input-group" style="position:relative">
                        <input type="text"
                               class="form-control"
                               :placeholder="item.loadingBarrios ? 'Cargando...' : 'Buscar barrio...'"
                               :value="item.barrios.find(b => String(b.id) === String(item.id_barrio))?.nombre || ''"
                               @focus="open = true; search = ''"
                               @input="search = $event.target.value; open = true"
                               :disabled="item.loadingBarrios || item.barrios.length === 0"
                               autocomplete="off"
                               readonly>
                        <span class="input-group-btn">
                          <button type="button" class="btn btn-default btn-sm"
                                  @click="open = !open"
                                  :disabled="item.loadingBarrios || item.barrios.length === 0">
                            <span x-show="!item.id_barrio">▼</span>
                            <span x-show="item.id_barrio"
                                  @click.stop="item.id_barrio = null; search = ''; open = false; if(item.errors) delete item.errors.id_barrio">✕</span>
                          </button>
                        </span>
                      </div>
                      <input type="hidden"
                             :name="`Domicilio[${i}][id_barrio]`"
                             :value="item.id_barrio ?? ''">
                      <div x-show="open"
                           style="position:absolute; z-index:9999; background:#fff; border:1px solid #ccc; border-radius:4px; max-height:200px; overflow-y:auto; width:auto; min-width:200px; box-shadow:0 4px 8px rgba(0,0,0,.15)">
                        <div style="padding:4px">
                          <input type="text"
                                 class="form-control input-sm"
                                 placeholder="Buscar..."
                                 x-model="search"
                                 @click.stop
                                 autocomplete="off">
                        </div>
                        <div x-show="item.barrios.filter(b => b.nombre.toLowerCase().includes(search.toLowerCase())).length === 0"
                             class="text-muted text-center" style="padding:8px; font-size:12px">
                          Sin resultados
                        </div>
                        <template x-for="b in item.barrios.filter(b => b.nombre.toLowerCase().includes(search.toLowerCase()))" :key="b.id">
                          <div style="padding:6px 12px; cursor:pointer; font-size:13px"
                               :style="String(b.id) === String(item.id_barrio) ? 'background:#e8f4fd; font-weight:600' : ''"
                               @mouseover="$el.style.background = String(b.id) === String(item.id_barrio) ? '#d0eaf8' : '#f5f5f5'"
                               @mouseleave="$el.style.background = String(b.id) === String(item.id_barrio) ? '#e8f4fd' : ''"
                               @click="item.id_barrio = b.id; open = false; search = ''; if(item.errors) delete item.errors.id_barrio"
                               x-text="b.nombre">
                          </div>
                        </template>
                      </div>
                      <p x-show="item.errors?.id_barrio" x-text="item.errors?.id_barrio?.[0]" class="help-block"></p>
                    </div>

                    <!-- Principal(1) -->
                    <div class="col-sm-1 pb-3">
                      <label class="control-label">Principal</label>
                      <input type="checkbox"
                             :name="`Domicilio[${i}][principal]`"
                             x-model="item.principal"
                             @input="if(item.errors) delete item.errors.principal"
                             value="1"
                             class="form-control"
                             style="width:30px; height:30px; margin-top:4px;">
                    </div>

                    <!-- Fecha baja(3) -->
                    <div class="col-sm-3 pb-3">
                      <label class="control-label">Fecha baja</label>
                      <input type="date"
                             :name="`Domicilio[${i}][fechabaja]`"
                             x-model="item.fechabaja"
                             @input="if(item.errors) delete item.errors.fechabaja"
                             :max="hoy"
                             class="form-control">
                    </div>

                  </div><!-- /fila 2 -->
                </div><!-- /panel-body -->
              </div><!-- /item-domicilio -->
            </template>

          </div><!-- /x-data domicilioForm -->

        </fieldset>
      </div>
    </div>
    <!-- /Domicilio -->


    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- SECCIÓN: Contacto  ← ALPINE.JS (reemplaza DynamicFormWidget)      -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <div class="section-card">
      <div class="card-body">

        <div x-data="contactoForm()">

          <!-- Header — mismo estilo que domicilio -->
          <div class="card-header">
            <i class="glyphicon glyphicon-envelope legend-icon"></i> Datos de contacto
            <span class="section-legend">Comunicación</span>
            <button type="button"
                    @click="agregar()"
                    :disabled="items.length >= 4"
                    class="btn btn-success btn-xs rounded-circle"
                    style="width:28px;height:28px;">
              <i class="glyphicon glyphicon-plus"></i>
            </button>
            <small x-show="items.length >= 4" class="text-muted ml-2">Máximo 4 contactos</small>
          </div>

          <!-- Sin items -->
          <div x-show="items.length === 0" class="text-muted text-center p-3">
            <i class="glyphicon glyphicon-envelope"></i> No hay contactos. Usá el botón + para agregar.
          </div>

          <!-- Items dinámicos -->
          <template x-for="(item, i) in items" :key="item._uid">
            <div class="item-contacto panel panel-default mb-3">

              <div class="panel-heading d-flex justify-content-end">
                <button type="button"
                        @click="eliminar(item._uid)"
                        class="btn btn-danger btn-xs">
                  <i class="glyphicon glyphicon-trash"></i>
                </button>
              </div>

              <div class="panel-body">

                <!-- Hidden ID para registros existentes -->
                <template x-if="item.id">
                  <input type="hidden" :name="`Contacto[${i}][id]`" :value="item.id">
                </template>

                <div class="row field-compact">
                  <div :class="item.errors?.id_tipocontacto ? 'col-sm-2 pb-3 has-error' : (item.id_tipocontacto ? 'col-sm-2 pb-3 has-success' : 'col-sm-2 pb-3')">
                    <label class="control-label">Tipo Contacto</label>
                    <select :name="`Contacto[${i}][id_tipocontacto]`"
                            x-model="item.id_tipocontacto"
                              @change="if(item.errors) delete item.errors.id_tipocontacto"
                            class="form-control">
                      <option value="">Elegir...</option>
                      <?php foreach ($estructuraArray['tiposContacto'] as $k => $v): ?>
                        <option value="<?= $k ?>"><?= Html::encode($v) ?></option>
                      <?php endforeach; ?>
                    </select>
                    <p x-show="item.errors?.id_tipocontacto" x-text="item.errors?.id_tipocontacto?.[0]" class="help-block"></p>
                  </div>
                  <div :class="item.errors?.valor ? 'col-sm-4 pb-3 has-error' : (item.valor ? 'col-sm-4 pb-3 has-success' : 'col-sm-4 pb-3')">
                    <label class="control-label">Valor</label>
                    <input type="text"
                           :name="`Contacto[${i}][valor]`"
                           x-model="item.valor"
                             @input="if(item.errors) delete item.errors.valor"
                           class="form-control"
                           style ="width:100%; text-transform:uppercase;"
                           maxlength="255">
                    <p x-show="item.errors?.valor" x-text="item.errors?.valor?.[0]" class="help-block"></p>
                  </div>
                  <div :class="item.errors?.id_tipouso ? 'col-sm-3 pb-3 has-error' : (item.id_tipouso ? 'col-sm-3 pb-3 has-success' : 'col-sm-3 pb-3')">
                    <label class="control-label">Uso</label>
                    <select :name="`Contacto[${i}][id_tipouso]`"
                            x-model="item.id_tipouso"
                              @change="if(item.errors) delete item.errors.id_tipouso"
                            class="form-control">
                      <option value="">Elegir...</option>
                      <?php foreach ($estructuraArray['tiposUso'] as $k => $v): ?>
                        <option value="<?= $k ?>"><?= Html::encode($v) ?></option>
                      <?php endforeach; ?>
                    </select>
                    <p x-show="item.errors?.id_tipouso" x-text="item.errors?.id_tipouso?.[0]" class="help-block"></p>
                  </div>
                  <div class="col-sm-3 pb-3">
                    <label class="control-label">Fecha baja</label>
                    <input type="date"
                           :name="`Contacto[${i}][fechabaja]`"
                           x-model="item.fechabaja"
                           @input="if(item.errors) delete item.errors.fechabaja"
                           :max="hoy"
                           class="form-control">
                  </div>
                </div>

              </div>
            </div>
          </template>

        </div><!-- /x-data contactoForm -->

      </div>
    </div>
    <!-- /Contacto -->


    <!-- ══════════════════════════════════════════════════════════════════ -->
    <!-- SECCIÓN: Afiliaciones y PUCO  ← ALPINE.JS                        -->
    <!-- ══════════════════════════════════════════════════════════════════ -->
    <div class="section-card">
      <div class="card-body">
        <fieldset class="border p-3 mt-0">
          <div class="panel-body">
            <div class="row gx-3">

              <!-- IZQUIERDA: PUCO — siempre visible -->
              <div class="col-md-5">
                <div class="card-header mb-2">
                  <i class="glyphicon glyphicon-search legend-icon"></i> Consulta PUCO
                  <span class="section-legend">Padrón</span>
                </div>
                <div class="mb-2">
                  <button type="button" class="btn btn-primary btn-sm" onclick="pucoAjax()">
                    <i class="glyphicon glyphicon-search"></i> Consultar al PUCO
                  </button>
                </div>
                <div class="mb-2">
                  <textarea id="resultadoPuco" class="form-control" cols="50" rows="4"
                            style="min-height:100px; resize:both;" placeholder="Resultado PUCO"></textarea>
                </div>
                <?= Html::hiddenInput('obra_social_check', 0) ?>
                <?= Html::checkbox('obra_social_check', false, [
                    'id'    => 'obra_social_check',
                    'value' => 1,
                    'class' => 'form-check-input me-2',
                    'style' => 'transform:scale(1.18);'
                ]) ?>
                <label class="form-check-label mb-0" for="obra_social_check">Obra social chequeada</label>
                <?php if ($model->ultimoChequeo !== null):
                  $dateTime  = new DateTime($model->ultimoChequeo->fechahora);
                  $formatter = new \yii\i18n\Formatter(['locale' => 'es-AR', 'timeZone' => 'America/Argentina/Buenos_Aires']);
                ?>
                  <div class="small-muted">
                    Último chequeo: <strong><?= Html::encode($formatter->asDatetime($dateTime->getTimestamp())) ?></strong>
                    &nbsp;|&nbsp;
                    Resultado: <strong><?= $model->ultimoChequeo->tiene_os ? 'Tiene obra social' : 'Sin obra social' ?></strong>
                  </div>
                <?php else: ?>
                  <div class="small-muted">Aún no se registró ningún chequeo para este paciente.</div>
                <?php endif; ?>
              </div>

              <!-- DERECHA: Obras sociales — Alpine dinámico -->
              <div class="col-md-7" x-data="obrasocialForm()">

                <!-- Header igual que domicilio/contacto -->
                <div class="card-header mb-2">
                  <i class="glyphicon glyphicon-book legend-icon"></i> Afiliaciones / Obra social
                  <span class="section-legend">Cobertura</span>
                  <button type="button"
                          @click="agregar()"
                          :disabled="items.length >= 2"
                          class="btn btn-success btn-xs rounded-circle"
                          style="width:28px;height:28px;">
                    <i class="glyphicon glyphicon-plus"></i>
                  </button>
                  <small x-show="items.length >= 2" class="text-muted ml-2">Máximo 2 obras sociales</small>
                </div>

                <!-- Sin items -->
                <div x-show="items.length === 0" class="text-muted text-center p-3">
                  <i class="glyphicon glyphicon-book"></i> No hay obras sociales. Usá el botón + para agregar.
                </div>

                <!-- Items dinámicos -->
                <template x-for="(item, i) in items" :key="item._uid">
                  <div class="item-obrasocial panel panel-default mb-3">

                    <div class="panel-heading d-flex justify-content-end">
                      <button type="button"
                              @click="eliminar(item._uid)"
                              class="btn btn-danger btn-xs">
                        <i class="glyphicon glyphicon-trash"></i>
                      </button>
                    </div>

                    <div class="panel-body">

                      <template x-if="item.id">
                        <input type="hidden" :name="`CarnetOs[${i}][id]`" :value="item.id">
                      </template>

                      <div class="row field-compact">

                        <!-- Obra social(7) — dropdown Alpine con búsqueda -->
                        <div :class="item.errors?.id_obrasocial ? 'col-sm-7 pb-3 has-error' : (item.id_obrasocial ? 'col-sm-7 pb-3 has-success' : 'col-sm-7 pb-3')"
                             x-data="{ openOs: false, searchOs: '' }"
                             @click.outside="openOs = false">
                          <label class="control-label">Obra social</label>
                          <div class="input-group" style="position:relative">
                            <input type="text"
                                   class="form-control"
                                   placeholder="Buscar obra social..."
                                   :value="osOpciones.find(o => String(o.id) === String(item.id_obrasocial))?.nombre || ''"
                                   @focus="openOs = true; searchOs = ''"
                                   @input="searchOs = $event.target.value; openOs = true"
                                   autocomplete="off"
                                   readonly>
                            <span class="input-group-btn">
                              <button type="button" class="btn btn-default btn-sm"
                                      @click="openOs = !openOs">
                                <span x-show="!item.id_obrasocial">▼</span>
                                <span x-show="item.id_obrasocial"
                                      @click.stop="item.id_obrasocial = null; searchOs = ''; openOs = false; if(item.errors) delete item.errors.id_obrasocial">✕</span>
                              </button>
                            </span>
                          </div>
                          <!-- Input hidden para el submit -->
                          <input type="hidden"
                                 :name="`CarnetOs[${i}][id_obrasocial]`"
                                 :value="item.id_obrasocial ?? ''">
                          <!-- Dropdown -->
                          <div x-show="openOs"
                               style="position:absolute; z-index:9999; background:#fff; border:1px solid #ccc; border-radius:4px; max-height:220px; overflow-y:auto; width:auto; min-width:280px; box-shadow:0 4px 8px rgba(0,0,0,.15)">
                            <div style="padding:4px">
                              <input type="text"
                                     class="form-control input-sm"
                                     placeholder="Buscar..."
                                     x-model="searchOs"
                                     @click.stop
                                     autocomplete="off">
                            </div>
                            <div x-show="osOpciones.filter(o => o.nombre.toLowerCase().includes(searchOs.toLowerCase())).length === 0"
                                 class="text-muted text-center" style="padding:8px; font-size:12px">
                              Sin resultados
                            </div>
                            <template x-for="o in osOpciones.filter(o => o.nombre.toLowerCase().includes(searchOs.toLowerCase()))" :key="o.id">
                              <div style="padding:6px 12px; cursor:pointer; font-size:13px"
                                   :style="String(o.id) === String(item.id_obrasocial) ? 'background:#e8f4fd; font-weight:600' : ''"
                                   @mouseover="$el.style.background = String(o.id) === String(item.id_obrasocial) ? '#d0eaf8' : '#f5f5f5'"
                                   @mouseleave="$el.style.background = String(o.id) === String(item.id_obrasocial) ? '#e8f4fd' : ''"
                                   @click="item.id_obrasocial = o.id; openOs = false; searchOs = ''; if(item.errors) delete item.errors.id_obrasocial"
                                   x-text="o.nombre">
                              </div>
                            </template>
                          </div>
                          <p x-show="item.errors?.id_obrasocial" x-text="item.errors?.id_obrasocial?.[0]" class="help-block"></p>
                        </div>

                        <!-- N° Afiliado(5) -->
                        <div :class="item.errors?.nroafiliado ? 'col-sm-5 pb-3 has-error' : (item.nroafiliado ? 'col-sm-5 pb-3 has-success' : 'col-sm-5 pb-3')">
                          <label class="control-label">N° Afiliado</label>
                          <input type="text"
                                 :name="`CarnetOs[${i}][nroafiliado]`"
                                 x-model="item.nroafiliado"
                                 @input="if(item.errors) delete item.errors.nroafiliado"
                                 class="form-control"
                                 maxlength="50">
                          <p x-show="item.errors?.nroafiliado" x-text="item.errors?.nroafiliado?.[0]" class="help-block"></p>
                        </div>

                      </div>
                    </div>
                  </div>
                </template>

              </div><!-- /x-data obrasocialForm -->

            </div>
          </div>
        </fieldset>
      </div>
    </div>
    <!-- /Afiliaciones -->


    <!-- BOTONES -->
    <?php if (!Yii::$app->request->isAjax): ?>
      <div class="form-actions">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Crear' : 'Actualizar',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
      </div>
    <?php endif; ?>

    <?php ActiveForm::end(); ?>

  </div>
</div>


<?php
// ── URLs para paciente.js ──────────────────────────────────────────────────────
$this->registerJs("
    var PACIENTE_URLS = {
        puco:    " . json_encode(Url::to(['/paciente/puco']))    . ",
        renaper: " . json_encode(Url::to(['/paciente/renaper']))  . "
    };
", \yii\web\View::POS_HEAD);
?>
<?= Html::jsFile('@web/js/paciente.js') ?>


<?php
// ── Alpine.js: lógica de domicilios y contactos ───────────────────────────────
$urlBarrios     = Url::to(['/barrio/arraybarrios-json']);
$urlLocalidades = Url::to(['/localidad/arraylocalidades-json']);
$osOpcionesJson = json_encode(array_map(function($k, $v) {
    return ['id' => $k, 'nombre' => $v];
}, array_keys($estructuraArray['obrasociales']), array_values($estructuraArray['obrasociales'])));

$this->registerJs(<<<JS

/* ── DOMICILIOS ───────────────────────────────────────────────────────────── */
function domicilioForm() {
    return {
        hoy:   new Date().toISOString().split('T')[0],
        items: {$domiciliosJson},   /* [] en create, datos existentes en update */

        /* ── Init: si hay items repoblados (POST fallido), recargar listas ── */
        async init() {
            for (let i = 0; i < this.items.length; i++) {
                const savedLocalidad  = this.items[i].id_localidad;
                const savedCp         = this.items[i].codigopostal;
                if (this.items[i].id_provincia) {
                    await this.cargarLocalidades(i, false);
                    /* Restaurar id_localidad con el tipo correcto del JSON cargado */
                    const match = this.items[i].localidades.find(l => String(l.id) === String(savedLocalidad));
                    if (match) {
                        this.items[i].id_localidad = match.id;
                        /* Autocompletar CP solo si no tenía uno guardado */
                        if (!savedCp && match.codigopostal) this.items[i].codigopostal = match.codigopostal;
                    }
                }
                if (this.items[i].id_localidad) await this.cargarBarrios(i, false);
            }
        },

        /* ── Agregar item vacío ── */
        agregar() {
            if (this.items.length >= 3) return;
            this.items.push({
                id: null, tipodom: '', calle: '', numero: '',
                piso: '', departamento: '', id_provincia: 22,
                id_localidad: 2845, codigopostal: '', id_barrio: null,
                principal: false, fechabaja: '',
                localidades: [], barrios: [],
                loadingLocalidades: false, loadingBarrios: false,
                _uid: 'dom_' + Date.now(),
            });
            /* Cargar localidades y barrios por defecto del nuevo item */
            this.\$nextTick(async () => {
                const idx = this.items.length - 1;
                await this.cargarLocalidades(idx, false);
                /* Forzar el valor 2845 tras cargar la lista, asegurando tipo correcto */
                const localidad2845 = this.items[idx].localidades.find(l => String(l.id) === '2845');
                if (localidad2845) {
                    this.items[idx].id_localidad = localidad2845.id;
                    /* Autocompletar CP desde la localidad por defecto */
                    if (localidad2845.codigopostal) this.items[idx].codigopostal = localidad2845.codigopostal;
                }
                await this.cargarBarrios(idx, false);
            });
        },

        /* ── Eliminar por _uid (evita index stale con x-for) ── */
        eliminar(uid) {
            const idx = this.items.findIndex(it => it._uid === uid);
            if (idx !== -1) this.items.splice(idx, 1);
        },

        /* ── Cascada Provincia → Localidades ── */
        async cargarLocalidades(i, resetear = true) {
            const provId = this.items[i].id_provincia;
            if (!provId) { this.items[i].localidades = []; return; }
            if (resetear) {
                this.items[i].id_localidad = null;
                this.items[i].id_barrio    = null;
                this.items[i].barrios      = [];
            }
            this.items[i].loadingLocalidades = true;
            try {
                const r = await fetch('{$urlLocalidades}?id=' + provId);
                this.items[i].localidades = await r.json();
            } finally {
                this.items[i].loadingLocalidades = false;
            }
        },

        /* ── Cambio de localidad: actualiza CP y carga barrios ── */
        async cambiarLocalidad(i, valor) {
            this.items[i].id_localidad = valor;
            /* Buscar la localidad en el array y autocompletar CP */
            const loc = this.items[i].localidades.find(l => String(l.id) === String(valor));
            if (loc) {
                if (loc.codigopostal) {
                    this.items[i].codigopostal = String(loc.codigopostal);
                }
            }
            if (this.items[i].errors) delete this.items[i].errors.id_localidad;
            await this.cargarBarrios(i);
        },

        /* ── Cascada Localidad → Barrios ── */
        async cargarBarrios(i, resetear = true) {
            const locId = this.items[i].id_localidad;
            if (!locId) { this.items[i].barrios = []; return; }
            if (resetear) this.items[i].id_barrio = null;
            this.items[i].loadingBarrios = true;
            try {
                const r = await fetch('{$urlBarrios}?id=' + locId);
                this.items[i].barrios = await r.json();
                /* Select2 se actualiza automáticamente via x-effect → updateBarrioS2 */
            } finally {
                this.items[i].loadingBarrios = false;
            }
        },


    };
}

/* ── OBRAS SOCIALES ──────────────────────────────────────────────────────── */
function obrasocialForm() {
    return {
        items:     {$obrasocialesJson},
        osOpciones: {$osOpcionesJson},

        agregar() {
            if (this.items.length >= 2) return;
            this.items.push({
                id: null, id_obrasocial: '', nroafiliado: '',
                _uid: Date.now() + Math.random(),
                errors: {},
            });
        },

        eliminar(uid) {
            const idx = this.items.findIndex(it => it._uid === uid);
            if (idx !== -1) this.items.splice(idx, 1);
        },
    };
}

/* ── CONTACTOS ────────────────────────────────────────────────────────────── */
function contactoForm() {
    return {
        hoy:   new Date().toISOString().split('T')[0],
        items: {$contactosJson},

        agregar() {
            if (this.items.length >= 4) return;
            this.items.push({
                id: null, id_tipocontacto: '', valor: '',
                id_tipouso: '', fechabaja: '',
                _uid: Date.now() + Math.random(),
            });
        },

        eliminar(uid) {
            const idx = this.items.findIndex(it => it._uid === uid);
            if (idx !== -1) this.items.splice(idx, 1);
        },
    };
}

JS, \yii\web\View::POS_END);
?>
