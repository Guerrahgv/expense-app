
<?php
require_once 'models/expensesmodel.php';
require_once 'models/categoriesmodel.php';


class Dashboard extends SessionController{

    private $user;

    function __construct(){
        parent::__construct();

        $this->user = $this->getUserSessionData();
       
    }

    //informacion a la vista de dashboard
     function render(){
       
        $expensesModel          = new ExpensesModel();
        $expenses               = $this->getExpenses(6); //gastos a mostrar en el dashboard
        $totalThisMonth         = $expensesModel->getTotalAmountThisMonth($this->user->getId());
        $maxExpensesThisMonth   = $expensesModel->getMaxExpensesThisMonth($this->user->getId());
        $categories             = $this->getCategories();

        $this->view->render('dashboard/index', [
            'user'                 => $this->user,
            'expenses'             => $expenses,
            'totalAmountThisMonth' => $totalThisMonth,
            'maxExpensesThisMonth' => $maxExpensesThisMonth,
            'categories'           => $categories
        ]);
    }
    
    //limita los expenses y no todos los expenses
    private function getExpenses($n = 0){
        if($n < 0) return NULL;
       
        $expenses = new ExpensesModel();
        return $expenses->getByUserIdAndLimit($this->user->getId(), $n);   
    }

    function getCategories(){
        $res = [];
        $categoriesModel = new CategoriesModel();
        $expensesModel = new ExpensesModel();

        $categories = $categoriesModel->getAll();

        foreach ($categories as $category) {
            $categoryArray = [];
            //obtenemos la suma de amount de expenses por categoria
            $total = $expensesModel->getTotalByCategoryThisMonth($category->getId(), $this->user->getId());
            // obtenemos el número de expenses por categoria por mes
            $numberOfExpenses = $expensesModel->getNumberOfExpensesByCategoryThisMonth($category->getId(), $this->user->getId());
            
            if($numberOfExpenses > 0){
                $categoryArray['total'] = $total;
                $categoryArray['count'] = $numberOfExpenses;
                $categoryArray['category'] = $category;
                array_push($res, $categoryArray);
            }
            
        }
        return $res;
    }
}

?>