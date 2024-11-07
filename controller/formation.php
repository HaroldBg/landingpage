<?php
include('../include/dbconnexion.php');
include('../include/functions.php');

// add magasin in his table 
//let's check if all variable is isset 

if ( isset($_POST['name']) && isset($_POST['email'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $formation = "Formation en Administration Sous Oracle 11G";
    //files path 
    // $path = "../../ressources/magasin/";
    //files name in db 
    // $nameToDb = "magasin_".$magasin;
    // user save magasin 
    // $user = $_SESSION['prenom_user'].' '.$_SESSION['user_name'];

    // let's check if this warehouse is not already set in database 
    // $cond = "nom = '".$magasin."'";
    $table = "inscription";
    //get data from bd where magasin_name = name_get
    // $data = select($connect,$table,$cond);
    // if (empty($data)) {
    //     // let insert magasin data 
    //     //upload files 
    //     // $file = uploadFile($files_name,$files_size,$files_tmp_name,$nameToDb,$path);
    //     $col = ['nom','email','user_create','statut'];
    //     $colD = [$magasin,$file,$user,"'$statut'"];
    //     if(insert($connect,$table,$col,$colD))
    //     {
    //         echo json_encode(array(
    //             'error' => false,
    //             'msg' => 'Magasin bien enrégistrer.'
    //         ));
    //     }
    // }else {
    //     echo json_encode(array(
    //         'error' => true,
    //         'msg' => 'Magasin existant.'
    //     ));
    // }
    //insert data for inscription in table 
        $col = ['name','email','formation'];
        $colD = [$name,$email,"'$formation'"];
        // if(insert($connect,$table,$col,$colD))
        // {
            if (insert($connect,$table,$col,$colD)) {
                echo json_encode(array(
                    'error' => false,
                    'msg' => 'Votre inscription à bien été enrégistrer.'
                ));
            } else {
                echo json_encode(array(
                    'error' => true,
                    'msg' => 'Une erreur est survenue.'
                ));
            }
            
        // }
}else {
    echo json_encode(array(
        'error' => true,
        'msg' => 'Une erreur est survenue.'
    ));
}