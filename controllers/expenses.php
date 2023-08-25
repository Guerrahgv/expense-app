
<?php
require_once 'models/expensesmodel.php';
require_once 'models/categoriesmodel.php';
require_once 'models/joinexpensescategoriesmodel.php';

class Expenses extends SessionController{


    private $user;

    function __construct(){
        parent::__construct();
        //obtengo la informacion del usuario de la sesion actual
        $this->user = $this->getUserSessionData(); 
      
    }

     function render(){
        $this->view->render('expenses/index', ['user' => $this->user,
            'dates' => $this->getDateList(),
            'categories' => $this->getCategoryList()
        ]);
    }
   
    //crea el nuevo expense (gasto)
    function newExpense(){
       
        if(!$this->existPOST(['title', 'amount', 'category', 'date'])){
            $this->redirect('dashboard', ['error' => Errors::ERROR_EXPENSES_NEWEXPENSE_EMPTY]);
            return;
        }

        if($this->user == NULL){
            $this->redirect('dashboard', ['error' => Errors::ERROR_EXPENSES_NEWEXPENSE]);
            return;
        }

        $expense = new ExpensesModel();

        $expense->setTitle($this->getPost('title'));
        $expense->setAmount((float)$this->getPost('amount'));
        $expense->setCategoryId($this->getPost('category'));
        $expense->setDate($this->getPost('date'));
        $expense->setUserId($this->user->getId());

        $expense->save();
        $this->redirect('dashboard', ['success' => Success::SUCCESS_EXPENSES_NEWEXPENSE]);
    }

    // cargo las categorias para mandar los expenses
    function create(){
        $categories = new CategoriesModel();
        $this->view->render('expenses/create', [
            "categories" => $categories->getAll(),
            "user" => $this->user
        ]);
    } 

    function getCategoryIds(){
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $categories = $joinExpensesCategoriesModel->getAll($this->user->getId());

        $res = [];
        foreach ($categories as $cat) {
            array_push($res, $cat->getCategoryId());
        }
        $res = array_values(array_unique($res));
        return $res;
    }



    
    /*
    // crea una lista con los meses donde hay expenses para grafica
    private function getDateList(){
        $months = [];
        $res = [];
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());
        //substr me sustrae los caracteres es este caso ejemplo: 2023-05
        
        $months = array_values(array_unique($months));

        foreach ($expenses as $expense) {
            array_push($months, substr($expense->getDate(),0, 7 ));
        }
        
        //mostrar los últimos 3 meses
        
        if(count($months) >3){
            array_push($res, array_pop($months));
            array_push($res, array_pop($months));
            array_push($res, array_pop($months));
        }
        return $res;
    }
    */

    //muestra los todos los expenses realizados 
    private function getDateList(){
        $months = [];
        $res = [];
        $joinModel = new JoinExpensesCategoriesModel();
        $expenses = $joinModel->getAll($this->user->getId());
        //substr me sustrae los caracteres es este caso ejemplo: 2023-05
        foreach ($expenses as $expense) {
            array_push($months, substr($expense->getDate(),0, 7 ));
        }

        $months = array_values(array_unique($months));
        
        foreach ($months as $month) {
            array_push($res, $month);
        }
        
        return $res;
    }








    // crea una lista con las categorias donde hay expenses (ojo solo donde hay gastos )
    private function getCategoryList(){
        $res = [];
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());

        foreach ($expenses as $expense) {
            array_push($res, $expense->getNameCategory());
        }
        $res = array_values(array_unique($res));

        return $res;
    }

    // crea una lista con los colores dependiendo de las categorias
    private function getCategoryColorList(){
        $res = [];
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategoriesModel->getAll($this->user->getId());

        foreach ($expenses as $expense) {
            array_push($res, $expense->getColor());
        }
        $res = array_unique($res);
        $res = array_values(array_unique($res));

        return $res;
    }

    
    //como si fuera una API solo regresamos un Json 
    // devuelve el JSON para las llamadas AJAX
    function getHistoryJSON(){
        header('Content-Type: application/json');
        $res = [];
        $joinExpensesCategories = new JoinExpensesCategoriesModel();
        $expenses = $joinExpensesCategories->getAll($this->user->getId());

        //insertamos un arreglo dentro de otro arreglo estilo JSON
        foreach ($expenses as $expense) {
            array_push($res, $expense->toArray());
        }
        
        echo json_encode($res);

    }

    
    function getTotalByMonthAndCategory($date, $categoryid){
        $iduser = $this->user->getId();
        $joinExpensesCategoriesModel = new JoinExpensesCategoriesModel();

        $total = $joinExpensesCategoriesModel->getTotalByMonthAndCategory($date, $categoryid, $iduser);
        if($total == NULL) $total = 0;
        return $total;
    }
 
    //paa graficar segun google charts
    function getExpensesJSON(){
        header('Content-Type: application/json');

        $res = [];
        $categoryIds     = $this->getCategoryIds();
        $categoryNames  = $this->getCategoryList();
        $categoryColors = $this->getCategoryColorList();

        //etiquetas:
        //la primera columna representa los meses y la promera fila las categorias
        array_unshift($categoryNames, 'Meses');
        array_unshift($categoryColors, 'Categorias');
         

        $months = $this->getDateList();

        for($i = 0; $i < count($months); $i++){
            $item = array($months[$i]);
            for($j = 0; $j < count($categoryIds); $j++){
                $total = $this->getTotalByMonthAndCategory( $months[$i], $categoryIds[$j]);
                array_push( $item, $total );
            }   
            array_push($res, $item);
        }

        array_unshift($res, $categoryNames);
        array_unshift($res, $categoryColors);
        
        echo json_encode($res);
    }

    function delete($params){

        if($params === NULL) $this->redirect('expenses', ['error' => Errors::ERROR_ADMIN_NEWCATEGORY_EXISTS]);
        $id = $params[0];
      
        $res = $this->model->delete($id);

        if($res){
            $this->redirect('expenses', ['success' => Success::SUCCESS_EXPENSES_DELETE]);
        }else{
            $this->redirect('expenses', ['error' => Errors::ERROR_ADMIN_NEWCATEGORY_EXISTS]);
        }
    }

}

?>