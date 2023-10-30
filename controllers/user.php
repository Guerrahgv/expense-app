
<?php

class User extends SessionController{

    private $user;

    function __construct(){
        parent::__construct();

        $this->user = $this->getUserSessionData();
      
    }

    function render(){
        $this->view->render('user/index', [
            "user" => $this->user
        ]);
    }

    function updateBudget(){

        $budgetPattern= '/^(?:[1-9]\d{0,8}|[1-9]?\d{1,8})$/';

        if($this->existPOST('budget')){
            
            $budget = $this->getPost('budget');

            if(empty($budget) || $budget === 0 || $budget < 0){
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEBUDGET_EMPTY]);
                return;
            }

            if (preg_match($budgetPattern, $budget)){
                $this->user->setBudget($budget);
                $this->user->update();
                $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATEBUDGET]);   
            }else{
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEBUDGET_VALIDATION]);
                return;
            }
        }else{
            $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEBUDGET]);
            return;
        }
    }

    function updateName(){
        
        $usernamePattern = '/^[a-zA-Z\s]{5,30}/';

        if($this->existPOST('name')){

            $name= $this->getPost('name');
            
            if ($name == "" ) {
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATENAME_EMPTY]);
              return;
            }

            if (preg_match($usernamePattern, $name)){
                $this->user->setName($name);

                if($this->user->update()){
                $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATENAME]);
                }
               
            }else{
                $this->redirect('user', ['error' => Errors::ERROR_SIGNUP_NEWUSER_INVA_DATE_N]);
                return; 
            }
        }
    }

    function updatePassword(){

        $passwordPattern = '/^(?!\s)(?=\S)(?!.*\s$)[a-zA-Z0-9]{5,30}$/';

        if($this->existPOST(['current_password', 'new_password'])){

            $current = $this->getPost('current_password');
            $new     = $this->getPost('new_password');

            if(empty($current) || empty($new)){
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPASSWORD_EMPTY]);
                return;
            }

            if($current === $new){
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPASSWORD_ISNOTTHESAME]);
                return;
            }

            if (preg_match($passwordPattern, $new)) {
                
                $newHash = $this->model->comparePasswords($current, $this->user->getId());

                if($newHash != NULL){
                    //si lo es actualizar con el nuevo
                    $this->user->setPassword($new, true);
                    
                    if($this->user->update()){
                        $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATEPASSWORD]);
                    }else{
                        $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPASSWORD]);
                    }
                }else{
                    $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPASSWORD]);
                    return;
                }   
            }else{
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPASSWORD__PATTERN]);
                return;
            }

        }else{
            $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPASSWORD__UPD]);
            return;
        }

    }

    function updatePhoto(){
        if(!isset($_FILES['photo'])){
            $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPHOTO]);
            return;
        }
        $photo = $_FILES['photo'];

        $target_dir = "public/img/photos/";
        $extarr = explode('.',$photo["name"]);
        $filename = $extarr[sizeof($extarr)-2];
        $ext = $extarr[sizeof($extarr)-1];
        $hash = md5(Date('Ymdgi') . $filename) . '.' . $ext;
        $target_file = $target_dir . $hash;
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
        
        $check = getimagesize($photo["tmp_name"]);
        if($check !== false) {
            //echo "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1;
        } else {
            //echo "File is not an image.";
            $uploadOk = 0;
        }

        if ($uploadOk == 0) {
            //echo "Sorry, your file was not uploaded.";
            $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPHOTO_FORMAT]);
        // if everything is ok, try to upload file
        } else {
            if (move_uploaded_file($photo["tmp_name"], $target_file)) {
                $this->model->updatePhoto($hash, $this->user->getId());
                $this->redirect('user', ['success' => Success::SUCCESS_USER_UPDATEPHOTO]);
            } else {
                $this->redirect('user', ['error' => Errors::ERROR_USER_UPDATEPHOTO]);
            }
        }
        
    }
}

?>