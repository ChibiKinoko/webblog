<?php
include('connectBDD.php');

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$login = "";
$email = "";

/* ------ CONNEXION ------ */

if(isset($_POST['submitCo']))
{
    if(!empty($_POST['login']) && !empty($_POST['password']))
    {
        $login = $_POST['login'];
        $password = $_POST['password'];
        
        if(preg_match("/[a-zA-Z0-9_]{4,}/", $login) && preg_match("/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/", $password))
        {
            $login = htmlspecialchars($_POST['login']);
            $password = htmlspecialchars($_POST['password']);
            $password = md5($password);

            //var_dump($login);
            //var_dump($password);

            $placehold = array($login, $password);

            $sql = 'SELECT `id_user`, `login`, `password` FROM `blogger`';
            $sql = 'SELECT * FROM `blogger` WHERE `login`= ? AND `password`= ?';
            $result = $bdd->prepare($sql);
            $result->execute($placehold);

            $donnees = $result->fetchAll();
            $nbResult = count($donnees);

            if($nbResult == 1) /*Si il y a une correspondance*/
            {       
                foreach ($donnees as $elem) 
                {
                    /*Remplissage des donnees de session*/
                    $_SESSION['user']['id_user'] = $elem['id_user'];
                    $_SESSION['user']['login'] = $elem['login'];
                    $_SESSION['user']['password'] = $elem['password'];
                    $_SESSION['user']['id_status_blogger'] = $elem['id_status'];
                }

            //echo "<script>alert(\"connexion reussie!\")</script>";
                header('Location: index.php');
            }
            else
            {
                echo "<script>alert(\"Identifiants erronnés!\")</script>";
            //header('Location: connexion.php');
            }
        }
    }
}

/* ------ INSCRIPTION ------*/

if(isset($_POST['submitInscrip']))
{
    $email = $_POST['email'];
    $login = $_POST['login'];
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];
    $valid = true;

    if(empty($email) || empty($login) || empty($password) || empty($confirm))
    {
        echo "<script>alert(\"Veuillez remplir toutes les cases.\")</script>";
        $valid = false;
    }

    if(!empty($email))
    {
        if(preg_match("/[a-z0-9._-]+@[a-z0-9._-]{2,}\.[a-z]{2,4}/", $email))
        {
            /*Verification si email deja utilise*/
            $sql = "SELECT `email` FROM `blogger` WHERE `email` = ?";
            $result = $bdd->prepare($sql);
            $result->execute(array($email));

            $donnees = $result->fetchAll();
            $nbResultEmail = count($donnees);

            if($nbResultEmail == 1)
            {
                echo "<script>alert(\"email déjà utilisé\")</script>";
                $valid = false;
            }   
        }
        else
        {
            $valid = false;
        }
        
    }
    if(!empty($login))
    {
        if(preg_match("/[a-zA-Z0-9_]{4,}/", $login))
        {
            /*Verification si login deja utilise*/
            $sql = "SELECT `login` FROM `blogger` WHERE `login` = ?";
            $result = $bdd->prepare($sql);
            $result->execute(array($login));

            $nbResultLogin = $result->rowCount();

            if($nbResultLogin == 1)
            {
                echo "<script>alert(\"login déjà utilisé\")</script>";
                $valid =  false;
            }
        }
        else
        {
            $valid = false; 
        }
    }

    if(!empty($password) && !preg_match("/[a-zA-Z0-9@\.;:!_\-^<>`]{6,}/", $password))
    {
        echo "<script>alert(\"mot de passe incorrect\")</script>";
        $valid = false;
    }
    if(!empty($password) && !empty($confirm) && $password != $confirm)
    {
        echo "<script>alert(\"mots de passe differents\")</script>";
        $valid = false;
    }

    /*si toutes les donnees sont correctes*/
    if($valid == true)
    {
        $password = md5($password);
        $sql = "INSERT INTO `blogger` (`email`, `login`, `password`, `id_status`) VALUES ('$email', '$login', '$password', '3')";
        $bdd->query($sql);

        echo "<script>alert(\"connexion reussie !\")</script>";

        /*recuperation donnees pour connexion direct*/

        $sql = 'SELECT `id_user`, `login`, `password` FROM `blogger`';
        $sql = 'SELECT * FROM `blogger` WHERE `login`= ? AND `password`= ?';
        $result = $bdd->prepare($sql);
        $result->execute(array($login, $password));

        $donnees = $result->fetch();

        /*Remplissage des donnees de session*/
        $_SESSION['user']['id_user'] = $donnees['id_user'];
        $_SESSION['user']['login'] = $donnees['login'];
        $_SESSION['user']['password'] = $donnees['password'];
        $_SESSION['user']['id_status_blogger'] = $donnees['id_status'];

        header('Location: index.php');


    }
}

?>