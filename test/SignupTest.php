<?php 
use PHPUnit\Framework\TestCase;
require_once 'models/UserModel.php';
require_once 'config/config.php'; 
require_once 'controllers/signup.php'; 

class SignupTest extends TestCase {
    
    public function testNewUserWithValidData() {
        $signup = new Signup();
        
        
        $_POST['username'] = 'testuser';
        $_POST['password'] = 'testpassword';

        ob_start(); 
        $signup->newUser();
        $output = ob_get_clean(); 
        $this->expectOutputString($output);
    }

    public function testNewUserWithEmptyData() {
        $signup = new Signup();

        
        $_POST['username'] = '';
        $_POST['password'] = '';

        ob_start();
        $signup->newUser();
        $output = ob_get_clean();

        $this->assertEmpty($output);
    }
}
