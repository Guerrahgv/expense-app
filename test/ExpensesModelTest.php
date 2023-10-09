<?php


use PHPUnit\Framework\TestCase;
require_once 'models/expensesmodel.php';
require_once 'config/config.php'; 


class ExpensesModelTest extends TestCase
{
    public function testSaveOk()
    {
       
        $expense = new ExpensesModel();
        $expense->setTitle('Gasto test add');
        $expense->setAmount(100);
        $expense->setCategoryId(1);
        $expense->setDate('2023-10-05');
        $expense->setUserId(5); 


        $result = $expense->save();

        $this->assertTrue($result);
    }
    public function testSaveError()
{
    $expense = new ExpensesModel();
    $expense->setTitle('Gasto'); // No cumple las validaciones, no debe guardar.
    $expense->setAmount(100);
    $expense->setCategoryId(1);
    $expense->setDate('2023-10-05');
    $expense->setUserId(5); 

    
    $result = $expense->save();

   
    $this->assertNotEquals('Operación exitosa', $result);
}


}
