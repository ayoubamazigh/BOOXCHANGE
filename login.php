<?php

    session_start();
    if(isset($_SESSION['username']) && isset($_SESSION['password'])){
        header('Location: home.php');
    }else if(isset($_COOKIE['username']) && isset($_COOKIE['password'])){
        $localhost = 'localhost';
        $user = 'root';
        $pass = '';
        $database = 'BOOXCHANGE';
        $connection = mysqli_connect($localhost,$user, $pass);
        $username = $_COOKIE['username'];
        $password = $_COOKIE['password'];
        
        if($connection){
            $db = mysqli_select_db($connection, $database);
                 
            if($db){
                $query = "SELECT * FROM accounts WHERE username='$username' AND password='$password' LIMIT 1;";
                $result = mysqli_query($connection, $query);
                $row = mysqli_fetch_array($result);
                try{
                    if($row['username'] == $username && $row['password'] == $password){
                        $_SESSION['username'] = $username;
                        $_SESSION['password'] = $password;
                        header('Location: home.php');
                    }
                }catch(Exception $ex){
                        //echo $ex;
                    }
                 }
             }
        
    }else if(isset($_POST['username']) && isset($_POST['password'])){
         $username = $_POST['username'];
         $password = $_POST['password'];

         if(!empty($username) && !empty($password)){
             $localhost = 'localhost';
             $user = 'root';
             $pass = '';
             $database = 'BOOXCHANGE';
             $connection = mysqli_connect($localhost,$user, $pass);

             if($connection){
                 $db = mysqli_select_db($connection, $database);

                 if($db){
                    $query = "SELECT * FROM accounts WHERE username='$username' AND password='$password' LIMIT 1;";
                    $result = mysqli_query($connection, $query);
                    $row = mysqli_fetch_array($result);
                    try{
                        if($row['username'] == $username && $row['password'] == $password){
                            if(isset($_POST['rememberme']) && !empty($_POST['rememberme'])){
                            $time = 60 * 60 * 24 * 7;
                            setcookie('username', "$username", time() + $time);
                            setcookie('password', "$password", time() + $time);
                            }
                            $_SESSION['username'] = $username;
                            $_SESSION['password'] = $password;
                            header('Location: home.php');
                        }else{
                            header('location: login.php');
                        }
                    }catch(Exception $ex){
                        header('location: login.php');
                    }
                 }
             }
         }

     }else{
        $html = <<<HTML
        <!DOCTYPE HTML>

<html lang='fr'>
    <head>
        <title>Booxchange.com</title>
        <meta charset='utf-8' />
    </head>
    
        <link rel='icon' href='assest/img/favicon.png'>
        <link href="assest/css/bootstrap.css" rel="stylesheet" >
        <link href='assest/css/login-style.css' rel='stylesheet'>
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link rel="preconnect" href="https://fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;700&display=swap" rel="stylesheet">  
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;500&display=swap" rel="stylesheet">        
    <body>
        <form action="#" method="POST">
            <h2 class='my-title'>Login Page</h2>
        <div class='container my-login-container'>
            <div class='row'>
                <div class='col-md-12 col-sm-6 col-lg-6 col-xs-12 p-0'>
                    <div class='my-login-image' ></div>
                </div>
                <div class='col-md-12 col-sm-6 col-lg-6 col-xs-12 my-login-side-container'>
                    <div class='my-connexion'>Connexion</div>
                    <div class='my-input-explainer' >Username:</div>
                    <div >
                        <input class='my-input' type="text" name='username' placeholder='Entrez votre Username'>
                    </div>
                    <div class='my-input-explainer' >Mot de pass:</div>
                    <div >
                        <input class='my-input' type="text" name='password' placeholder='Entrez votre mot de pass'>
                    </div>
                    <div>
                    <button type="submit" class="my-btn" >
                        Connexion    
                    </button>
                    <div class='my-checkbox'>               
                        <input type="checkbox" name='rememberme' value='true' id='chbox'><label for='chbox' >&nbsp;souviens-toi de moi</label>
                    </div>
                    <div class='my-input-link'>               
                        <a class='my-link' href="#" >j'ai oublié le mot de pass.</a>
                    </div>
                    <div class='my-input-link mt-5 mb-3'>
                        <a class='my-link' href="#" ><center>Vous n'êtes pas membre?</center></a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
      </form>
    </body>
</html>
HTML;
        echo $html;
    }
             
             
             
             
             
             
             
            


     
     
     
?>