<?php

namespace app\models;
use app\components\behaviors\AuditoriaBehaviors;
use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "carnet_os".
 *
 * @property int $id
 * @property int $id_paciente
 * @property int $id_obrasocial
 * @property string $nroafiliado
 *
 * @property Obrasocial $obrasocial
 * @property Paciente $paciente
 */
class CarnetOs extends \yii\db\ActiveRecord
{

  public function behaviors()
  {

    return array(
           'AuditoriaBehaviors'=>array(
                  'class'=>AuditoriaBehaviors::className(),
                  ),
      );
 }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'carnet_os';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_paciente', 'id_obrasocial'], 'default', 'value' => null],
            [['id_paciente', 'id_obrasocial'], 'integer'],
            [['nroafiliado','id_obrasocial'],'required'],
            [['nroafiliado'], 'string'],
            [['id_obrasocial'], 'exist', 'skipOnError' => true, 'targetClass' => Obrasocial::className(), 'targetAttribute' => ['id_obrasocial' => 'id']],
            [['id_paciente'], 'exist', 'skipOnError' => true, 'targetClass' => Paciente::className(), 'targetAttribute' => ['id_paciente' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Id',
            'id_paciente' => 'Id_paciente',
            'id_obrasocial' => 'Obra social',
            'nroafiliado' => 'Nro de afiliado',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getObrasocial()
    {
        return $this->hasOne(Obrasocial::className(), ['id' => 'id_obrasocial']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPaciente()
    {
        return $this->hasOne(Paciente::className(), ['id' => 'id_paciente']);
    }
    public static function  getMapIdsByPaciente($id_paciente)
    {
       return ArrayHelper::map(self::find()->where(['id_paciente'=>$id_paciente])->all(),'id_obrasocial','id_obrasocial');
    }
    public static function getMapAfiliadosByPaciente($id_paciente)
    {
      return ArrayHelper::map(self::find()->where(['id_paciente'=>$id_paciente])->all(),'id_paciente','nroafiliado');
    }

    public static function guardarCarnets(int $idPaciente, array $data = []): bool
    {
        $db = \Yii::$app->db;
        $tx = $db->beginTransaction();
        try {
            // Carga existentes indexados por id
            $existentes = self::find()
                ->where(['id_paciente' => $idPaciente])
                ->indexBy('id')
                ->all();
            $idsProcesados = [];
            // Recorremos los items recibidos
            foreach ($data as $item) {
                // Ignorar filas completamente vacías
                $idObra = $item['id_obrasocial'] ?? null;
                $nro    = $item['nroafiliado'] ?? null;
                if (empty($idObra) && empty($nro) && empty($item['id'])) {
                    continue;
                }
                if (!empty($item['id']) && isset($existentes[$item['id']])) {
                    // actualizar existente
                    $model = $existentes[$item['id']];
                } else {
                    // crear nuevo
                    $model = new self();
                    $model->id_paciente = $idPaciente;
                }
                // Asignar atributos (usar null-coalescing para evitar notices)
                $model->id_obrasocial = $idObra !== null ? $idObra : null;
                $model->nroafiliado   = $nro !== null ? $nro : null;
                // Validar (opcional) y guardar
                if (!$model->validate()) {
                    // registrar errores para debugging
                    \Yii::error([
                        'message' => 'Validación fallida en guardarCarnets',
                        'errors' => $model->getErrors(),
                        'item' => $item,
                    ], __METHOD__);
                    throw new \RuntimeException('Validación fallida en CarnetOs');
                }

                if (!$model->save(false)) {
                    \Yii::error([
                        'message' => 'Save(false) falló en guardarCarnets',
                        'item' => $item,
                    ], __METHOD__);
                    throw new \RuntimeException('Error al guardar CarnetOs');
                }

                $idsProcesados[] = $model->id;
            }
            // Eliminar los que existían y ya no están en el form
            foreach ($existentes as $id => $modelExistente) {
                if (!in_array($id, $idsProcesados, true)) {
                    if (!$modelExistente->delete()) {
                        \Yii::error([
                            'message' => 'Eliminación falló en guardarCarnets',
                            'id' => $id,
                        ], __METHOD__);
                        throw new \RuntimeException('Error al eliminar CarnetOs');
                    }
                }
            }
            $tx->commit();
            return true;
        } catch (\Throwable $e) {
            // asegurarse de revertir
            try { $tx->rollBack(); } catch (\Throwable $t) { /* ignore */ }
            // log completo del error
            \Yii::error(['message' => $e->getMessage(),  'trace' => $e->getTraceAsString(),
            ], __METHOD__);
            return false;
        }
    }

}
