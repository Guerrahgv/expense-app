<?php

use PHPUnit\Framework\TestCase;

require_once 'models/expensesModel.php';
require_once 'config/config.php';
require_once 'controllers/expenses.php';
require_once 'models/usermodel.php';

class ExpensesTest extends TestCase
{
    public function testNewExpenseValid()
{
    $user = new UserModel(); 
    $user->setId(5); 

    $controller = new Expenses();


    // Simulo datos POST
    $_POST['title'] = 'Valid Expense';
    $_POST['amount'] = '100';
    $_POST['category'] = '1';
    $_POST['date'] = '2023-10-05';

    $controller->newExpense();

}

}