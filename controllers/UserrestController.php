<?php
namespace app\controllers;
use yii\rest\Controller;

class UserrestController extends Controller
{
  // behaviors heredado

    public $modelClass = 'app\models\Usuario';

    public function actionAuthenticate(){
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Si se envían los datos en formato raw dentro de la petición http, se recogen así:
        $params=json_decode(file_get_contents("php://input"), false);
        @$username=$params->username;
        @$password=$params->password;
        // Si se envían los datos de la forma habitual (form-data), se reciben en $_POST:
        //$username=$_POST['username'];
        //$password=$_POST['password' ];

        if($u=\app\models\Usuario::findOne(['usuario'=>$username]))
            if($u->contrasenia==md5($password)) {//o crypt, según esté en la BD

                return ['token'=>$u->token,'id'=>$u->id,'usuario'=>$u->usuario];
            }

        return ['error'=>'Credenciales incorrectas. '.$username];
      }
    }
    // public function behaviors()
    //     {
    //         return [
    //             'contentNegotiator' => [
    //                 'class' => ContentNegotiator::className(),
    //                 'formats' => [
    //                     'application/json' => Response::FORMAT_JSON,
    //                 ],
    //             ],
    //         ];
    //     }
    //
    //     public function actionLogin()
    //     {
    //         $username = Yii::$app->request->post('username');
    //         $password = Yii::$app->request->post('password');
    //
    //         $user = \app\models\Usuario::findByUsername($username);
    //         if ($user && Yii::$app->security->validatePassword($password, $user->contrasenia)) {
    //             // Generar un token seguro usando Yii2 Security
    //             $token = Yii::$app->security->generateRandomString();
    //             $user->token = $token;
    //             $user->save();
    //
    //             return ['token' => $token];
    //         }
    //
    //         Yii::$app->response->statusCode = 401; // Unauthorized
    //         return ['error' => 'Invalid username or password'];
    //     }
    //
    //     public function actionLogout()
    //     {
    //         // Lógica para cerrar sesión y eliminar el token de acceso del usuario
    //     }


}
  ?>
