<?php
use PHPUnit\Framework\TestCase;
require_once 'config/config.php'; 
require_once 'models/usermodel.php';

class budgetTest extends TestCase
{
    public function testUpdateBudgetOk() {
        $budget = 200000;
        $id = 70; 
        $userModel = new UserModel();
        $result = $userModel->updateBudget($budget, $id);
        $this->assertTrue($result); 
    }
    public function testUpdateBudgetError() {
        $budget = 0;
        $id = 70;
        $userModel = new UserModel();
        $result = $userModel->updateBudget($budget, $id);
        $this->assertFalse($result); 
    }
    
}
