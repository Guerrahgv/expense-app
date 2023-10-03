<?php 
class Signup extends SessionController {
    function __construct(){
        parent::__construct();
    }

    function render(){
        $this->view->errorMessage = '';
        $this->view->render('login/signup');
    }

    function newUser(){
        // Patrones de validación
        $usernamePattern = '/^[a-zA-Z0-9]{5,30}$/';
        $passwordPattern = '/^(?!\s)(?=\S)(?!.*\s$)[a-zA-Z0-9]{5,30}$/';

        // Me regresa true exist POST si hay un envío POST
        if($this->existPOST(['username', 'password'])){
            
            $username = $this->getPost('username');
            $password = $this->getPost('password');
           
            // Verificar datos vacíos
            if ($username == "" || $password =="") {
                // Error al validar datos     
                $this->redirect('signup', ['error' => Errors::ERROR_SIGNUP_NEWUSER_EMPTY]);
              return;
            }
            
            // Validar datos en el servidor
            if (!preg_match($usernamePattern, $username) || !preg_match($passwordPattern, $password)) {
                // Error en la validación de datos
                $this->redirect('signup', ['error' => Errors::ERROR_SIGNUP_NEWUSER_INVA_DATE]);
                return;
            }
         
            $user = new UserModel();
            $user->setUsername($username);
            $user->setPassword($password);
            $user->setRole("user");

            if($user->exists($username)){
                // Error al registrar el usuario. Elige un nombre de usuario diferente porque ya existe
                $this->redirect('signup', ['error' => Errors::ERROR_SIGNUP_NEWUSER_EXISTS]);
                return;
            } else if($user->save()){
                // Redirigir con éxito
                $this->redirect('', ['success' => Success::SUCCESS_SIGNUP_NEWUSER]);
                return;
            } else {
                // Error al registrar el usuario. Inténtalo más tarde
                $this->redirect('signup', ['error' => Errors::ERROR_SIGNUP_NEWUSER]);
                return;
            }
        } else {
            // Error, cargar vista con errores
            $this->redirect('signup', ['error' => Errors::ERROR_SIGNUP_NEWUSER_INVA_DATE]);
            return;
        }
    }
}
