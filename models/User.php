<?php

namespace app\models;
use Yii;
use app\models\Usuario;

class User extends \yii\base\BaseObject implements \yii\web\IdentityInterface
{
    public $id_user;
    public $username;
    public $nombre;

    public $password;
    public $activo;
    //public $administrador;
    public $authKey;
    public $accessToken;
    public $imagen;
    public $id_pantalla;
    /**
     * @inheritdoc
     */
    public static function findIdentity($id_user)
    {

        $usuario= Usuario::findOne($id_user);

        if ($usuario){

            $model=new User();
            $model->id_user=$usuario->id;
            $model->username=$usuario->usuario;
            $model->nombre=$usuario->nombre;
            $model->password=$usuario->contrasenia;
            $model->activo=$usuario->activo;
            $model->imagen=$usuario->imagen;
            $model->id_pantalla=$usuario->id_pantalla;
          //  $model->administrador=$usuario->administrador;

            return new static($model);
        }
        return null;

    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public function findByUsername($username)
    {

        $usuario= Usuario::findOne(['usuario'=>$username]);

        $model=new User();

        if ($usuario){
            $model->id_user=$usuario->id;
            $model->username=$usuario->usuario;
            $model->password=$usuario->contrasenia;
            $model->activo=$usuario->activo;
          //  $model->administrador=$usuario->administrador;

        }
        return new static($model);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id_user;
    }


    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->authKey;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return ($this->password === md5($password));
    }

    public function attributeLabels()
    {
        return [
            'id_user' => 'ID',
            'username' => 'Usuario',
            'password' => 'Contraseña',
	    // $authKey;
	    // $accessToken;
        ];
    }
public static function isUserAdmin()    {
      $model = Usuario::findOne([
        'id' => Yii::$app->user->identity->id,
        'id_rol' => 1, //id rol admin
      ]);
          if ($model){
            return true;
          } else {
            return false;
          }

    }



}
