<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
//modelos
use app\models\Biopsia;
// use app\models\Pap;
use app\models\Paciente;
use app\models\Solicitud;
use app\models\Solicitudbiopsia;
use app\models\Solicitudpap;

use app\models\Pap;
// use app\models\Trazabilidad;
use app\models\Medico;
use app\models\Procedencia;
use app\models\Provincia;
use app\models\Localidad;

use app\models\Plantilladiagnostico;
use app\models\Plantillamicroscopia;
use app\models\Plantillamacroscopia;
use app\models\Plantillamaterial;
use app\models\Plantillafrase;
use app\models\Plantillaflora;
use app\models\Plantillapavimentosa;
use app\models\Plantillaglandular;
use app\models\Plantillaaspecto;
use app\models\Plantilladiagnosticop;
use app\models\Usuario;
use app\models\Auditoria;
use app\models\Rol;
use app\models\Modulo;
use app\models\Accion;
use app\models\Firma;
use app\models\Tipoprofesional;
use app\models\Obrasocial;
use app\models\Nacionalidad;
use app\models\Tipodoc;
use app\models\Estado;

use app\components\Seguridad\Seguridad;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout','administracion'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],

                    [
                        //El administrador tiene permisos sobre las siguientes acciones
                        'actions' => ['administracion'],
                        'allow' => true,
                        //Usuarios autenticados, el signo ? es para invitados
                        'roles' => ['@'],
                        'matchCallback' => function ($rule, $action) {
                            if (Yii::$app->user->identity->id_pantalla==1 ){
                                return false;
                              }
                              else {
                                return true;
                              }

                        }
                    ],

                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

 public function actionFlash () {
   $session = Yii::$app->session; // establece un mensaje flash llamado "greeting "
   $session->setFlash ( 'saludo ', 'Hola usuarioator! ');
   return $this->render ( 'flash');
 }
    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

       $cantidadBiopsias = Biopsia::find()->count();
       $cantidadSolicitudes =Solicitud::find()->count();
       $cantidadPacientes = Paciente::find()->count();
       $cantidadPaps = Pap::find()->count();
       $cantidadProcedencia =Procedencia::find()->count();
       $cantidadMedicos = Medico::find()->count();

        return $this->render('index',['cantidadBiopsias'=>$cantidadBiopsias,
        'cantidadSolicitudes'=>$cantidadSolicitudes,
        'cantidadBiopsias'=>$cantidadBiopsias,
        'cantidadPacientes'=>$cantidadPacientes,
        'cantidadPaps'=>$cantidadPaps,
        'cantidadProcedencia'=>$cantidadProcedencia,
        'cantidadMedicos'=>$cantidadMedicos,

        ]);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
      $this->layout = 'main2';

        if (!Yii::$app->user->isGuest) {
          /* Al entrar al sistema aparecera la pagina de login (return $this->render('login'),puesto
            que no entra a este if y tampoco al siguiente ( porque no esta logueado
            y por lo tanto  es invitado ni valida el post)*/
          /* Si se loguea entonces, pasa de largo la primera vez el isGuest
            entra al segundo if, se valida return goback hace volver al loguin
            de esa forma ahi si entra al primer if, y se dirige al pagina de inicio home() */
          /*Si vuelve para atras una vez logueado se redigira al primer if */
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
          if (!Yii::$app->user->identity->activo ){
              Yii::$app->user->logout();
            }
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }


    public function actionPlantillas()
    {
      $cantidadPlantillaDiag =Plantilladiagnostico::find()->count();
      $cantidadPlantillaMic = Plantillamicroscopia::find()->count();
      $cantidadPlantillaMac =Plantillamacroscopia::find()->count();
      $cantidadPlantillaMatb = Plantillamaterial::find()->count();
      $cantidadPlantillaFra =Plantillafrase::find()->count();
     return $this->render('plantillas',[
       'cantidadPlantillaDiag'=>$cantidadPlantillaDiag,
       'cantidadPlantillaMic'=>$cantidadPlantillaMic,
       'cantidadPlantillaMac'=>$cantidadPlantillaMac,
       'cantidadPlantillaMatb'=>$cantidadPlantillaMatb,
       'cantidadPlantillaFra'=>$cantidadPlantillaFra,
      ]);
    }
    public function actionExtras()
    {
      $cantidadProcedencia = Procedencia::find()->count();
      $cantidadProvincia =Provincia::find()->count();
      $cantidadLocalidad = Localidad::find()->count();
      $cantidadTipoProfesional = Tipoprofesional::find()->count();
      $cantidadObrasocial = Obrasocial::find()->count();
      $cantidadNacionalidad = Nacionalidad::find()->count();
      $cantidadTipoDoc = Tipodoc::find()->count();
      $cantidadEstado = Estado::find()->count();

     return $this->render('extras',[
       'cantidadProcedencia'=>$cantidadProcedencia,
       'cantidadProvincia'=>$cantidadProvincia,
       'cantidadLocalidad'=>$cantidadLocalidad,
       'cantidadTipoProfesional'=>$cantidadTipoProfesional,
       'cantidadObrasocial'=>$cantidadObrasocial,
       'cantidadNacionalidad'=>$cantidadNacionalidad,
       'cantidadTipoDoc'=>$cantidadTipoDoc,
       'cantidadEstado'=>$cantidadEstado,



          ]);
    }
    public function actionPlantillasbiopsias()
    {
      $cantidadPlantillaDiag = Plantilladiagnostico::find()->count();
      $cantidadPlantillaMic = Plantillamicroscopia::find()->count();
      $cantidadPlantillaMac = Plantillamacroscopia::find()->count();
      $cantidadPlantillaMatb = Plantillamaterial::find()->count();
      $cantidadPlantillaFra = Plantillafrase::find()->count();
     return $this->render('plantillasbiopsias',[
       'cantidadPlantillaDiag'=>$cantidadPlantillaDiag,
       'cantidadPlantillaMic'=>$cantidadPlantillaMic,
       'cantidadPlantillaMac'=>$cantidadPlantillaMac,
       'cantidadPlantillaMatb'=>$cantidadPlantillaMatb,
       'cantidadPlantillaFra'=>$cantidadPlantillaFra,
      ]);
    }
    public function actionPlantillaspaps()
    {
      $cantidadPlantillaDiagP = Plantilladiagnostico::find()->count();
      $cantidadPlantillaflora = plantillaflora::find()->count();
      $cantidadPlantillaPav = Plantillapavimentosa::find()->count();
      $cantidadPlantillaAsp = Plantillaaspecto::find()->count();
      $cantidadPlantillaGla = Plantillaglandular::find()->count();
      $cantidadPlantillaFra = Plantillafrase::find()->count();

     return $this->render('plantillaspaps',[
       'cantidadPlantillaDiagP'=>$cantidadPlantillaDiagP,
       'cantidadPlantillaflora'=>$cantidadPlantillaflora,
       'cantidadPlantillaPav'=>$cantidadPlantillaPav,
       'cantidadPlantillaAsp'=>$cantidadPlantillaAsp,
       'cantidadPlantillaGla'=>$cantidadPlantillaGla,
       'cantidadPlantillaFra'=>$cantidadPlantillaFra,

          ]);
    }
    public function actionAdministracion()
    {
      $cantidadUsuarios = Usuario::find()->count();
      $cantidadAuditorias =Auditoria::find()->count();
      $cantidadFirmas =Firma::find()->count();

        return $this->render('administracion',[
          'cantidadUsuarios'=>$cantidadUsuarios,
          'cantidadAuditorias'=>$cantidadAuditorias,
          'cantidadFirmas'=>$cantidadFirmas
         ]);
    }
    public function actionPermisos()
    {
        $cantidadRoles= Rol::find()->count();
        $cantidadModulos = Modulo::find()->count();
        $cantidadAcciones = Accion::find()->count();

          return $this->render('permisos',[
            'cantidadRoles'=>$cantidadRoles,
            'cantidadModulos'=>$cantidadModulos,
            'cantidadAcciones'=>$cantidadAcciones
           ]);
    }
    public function actionSolicitudes()
    {
      $cantidadSolicitudbiopsia =Solicitudbiopsia::find()->count();
      $cantidadSolicitudpap = Solicitudpap::find()->count();

     return $this->render('solicitudes',[
       'cantidadSolicitudbiopsia'=>$cantidadSolicitudbiopsia,
       'cantidadSolicitudpap'=>$cantidadSolicitudpap,

      ]);
    }

    public function actionConstruccion()
    {
        return $this->render('construccion');
    }
}
