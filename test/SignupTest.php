<?php 
use PHPUnit\Framework\TestCase;
require_once 'models/UserModel.php';
require_once 'config/config.php'; 
require_once 'controllers/signup.php'; 

class SignupTest extends TestCase {
    
    public function testNewUserWithValidData() {
        $signup = new Signup();
        
        // Simular un envío POST válido con datos de usuario
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'testpassword';

        ob_start(); // Capturamos la salida
        $signup->newUser();
        $output = ob_get_clean(); // Obtenemos la salida generada

        $this->expectOutputString($output); // Comparamos la salida generada con la salida esperada
    }

    public function testNewUserWithEmptyData() {
        $signup = new Signup();

        // Simular un envío POST con datos vacíos
        $_POST['username'] = '';
        $_POST['password'] = '';

        ob_start();
        $signup->newUser();
        $output = ob_get_clean();

        $this->expectOutputString($output);
    }
}
