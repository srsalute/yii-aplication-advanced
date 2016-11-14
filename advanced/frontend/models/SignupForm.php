<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $nome;
    public $sobrenome;
    public $nome_de_usuario;
    public $email;
    public $senha;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['nome', 'required', 'message' => 'Campo não pode ficar em branco.'],
            ['sobrenome', 'required', 'message' => 'Campo não pode ficar em branco.'],
            
            ['nome_de_usuario', 'trim'],
            ['nome_de_usuario', 'required', 'message' => 'Necessário um nome de usuario válido.'],
            ['nome_de_usuario', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este nome de usuario já está sendo usado.'],
            ['nome_de_usuario', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Necessário um email válido.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Este email já está sendo usado.'],

            ['senha', 'required', 'message' => 'Necessário uma senha de no mínimo 6 caracteres.'],
            ['senha', 'string', 'min' => 6],
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->first_name = $this->first_name;
        $user->last_name = $this->last_name;
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
