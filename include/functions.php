<?php

    //notif mail for inscription
    
function notif_mail($mail,$sujet,$message_html)
{

	$passage_ligne = "\r\n";

	$server = 'ERP Octogone <contact@octogone-erp.com>';

	$header = 'From: '.$server."\r\n"; 
	$header.= 'Reply-To: '.$server."\r\n"; 
	$header.= 'MIME-Version: 1.0'."\r\n"; 
	$header.= 'Content-type: text/html; charset=UTF-8'."\r\n"; 

	$message = $passage_ligne.$message_html.$passage_ligne;

	//=====Envoi de l'e-mail.
	mail($mail,$sujet,$message,$header);
}
    function create($connect,$nom_table,$colonne,$type_champ):bool{


        $taille = count($colonne);
        $i=0;
        $add='';
       
        $query="CREATE TABLE ".$nom_table."( id INT NOT NULL AUTO_INCREMENT,";
            
            for($i=0 ; $i<$taille ; $i++){
                switch ($type_champ[$i]) {
                    case 'VARCHAR':
                        $size = 255;
                        break;

                        case 'Int':
                            $size = 11;
                            break;

                    default:
                        $size = "";
                        break;
                }
                $add = $colonne[$i].' '.$type_champ[$i] . "($size)". ' NOT NULL,';
                $query.=$add;
            }
            $query.="PRIMARY KEY(id)) ENGINE = InnoDB;";

            // echo $query;
            
        $statement =$connect->prepare($query);
        $statement->execute();
        
        $resultat =$statement->fetchAll();

        if($resultat>0){
            return true;
        }
        else{
            return false;
        }
    }

    // Create_table($db,'nagib',$colonne=['nom','prenom','age'],$type_champ=['TEXT','TEXT','INT']);


    // CRUD

    function insert($connect,$nom_table,$colonne,$data) : bool {

        $taille = count($colonne);
        $i=0;
        $add='';
        $add2='';
       
        $query="INSERT INTO ".$nom_table." (";
            
            for($i=0 ; $i<$taille ; $i++){
                if($i<$taille-1){
                    $add = $colonne[$i].',' ;
                    $query.=$add;
                }elseif($i=$taille -1){
                    $add = $colonne[$i] ;
                    $query.=$add;
                }
               
            }
            $query.=")";
            $query.=" VALUES (";
                for($i=0 ; $i<$taille ; $i++){
                    if($i<$taille-1){
                        $add2 = '\''.$data[$i].'\',';
                        $query.=$add2;
                    }elseif($i=$taille -1){
                        $add2 = $data[$i];
                        $query.=$add2;
                    }
                }
            
            $query.=");";

            //  echo $query;
            // var_dump($query);
            // die;
            $statement = $connect->prepare($query);
            $statement->execute();
            $result = $statement->fetchAll();
            if ($result > 0) {
                return true;
            } else {
                return false;
            }

    }


    // insert_crud($db,'nagib',$colonne=['nom','prenom','age'],$data=['popopop','ulrich',22]);

    function select($connect,$table,$cond = null) {

        $query="SELECT * FROM ".$table."";
        
        switch ($cond) {
            case null:
                $cond = '';
                break;
            
            default:
                $cond = ' WHERE '.$cond;
                break;
        }
        $query .= $cond;
        $statement =$connect->prepare($query);
        $statement->execute();
        
        $result =$statement->fetchAll();
        return $result;

    }

    // select_crud($db,'nagib');

    function update_crud($connect,$nom_table,$colonne,$data,$id_condition) {

        //var_dump($colonne);
        $taille = count($colonne);
        var_dump($taille);
        $i=0;
        // $add='';

        $query="UPDATE ".$nom_table." set ";
            
            for($i=0 ; $i<$taille ; $i++){
                if($i<$taille-1){
                    $add = $colonne[$i]." = " ."'".$data[$i]."'". ", ";
                    $query.=$add;
                }elseif($i == $taille -1){
                    $add = $colonne[$i]." = "."'".$data[$i]."'";
                    $query.=$add;
                }
                
            }
            $query.=" WHERE ".$id_condition.";";
    
            
            // $query.=");";

            // echo $query;

            $statement = $connect->prepare($query);
            $statement->execute();
            $resultat =$statement->fetchAll();
            if ($resultat > 0) {
                return true;
            } else {
                return false;
            }

    }

    // update_crud($db,'nagib',$colonne=['nom','prenom','age'],$data=['fuckwellwell','ulrich',21],$id_condition=5);


    function delete_crud($connect,$nom_table,$col_cond,$data_cond) {

        $query="DELETE FROM ".$nom_table." WHERE ".$col_cond." = ".'\''.$data_cond.'\''.";";
        
        // echo $query;
            
        $statement =$connect->prepare($query);
        $statement->execute();
        
        $resultat =$statement->fetchAll();
    }

   //convert date and hours to format fr 
   function datetimeFr($date){
    if (!empty($date)) {
        $date = new DateTime($date);
        $date = $date->format('d-m-Y H:i:s');
    } else {
        $date = "Aucune Action.";
    }
    
    return $date;
   }
      //convert date and hours to format fr 
      function dateFr($date){
        if (!empty($date)) {
            $date = new DateTime($date);
            $date = $date->format('d-m-Y');
        } else {
            $date = "Aucune Action.";
        }
        
        return $date;
       }
   //standard actions uses by user 
   function standAction($id){
    $action = '
    <div class="text-end">
        <a href="#" class="btn btn-sm btn-light btn-active-light-primary "  data-kt-menu-trigger="click" data-kt-menu-placement="bottom-end">Actions
        <!--begin::Svg Icon | path: icons/duotune/arrows/arr072.svg-->
        <span class="svg-icon svg-icon-5 m-0">
            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path d="M11.4343 12.7344L7.25 8.55005C6.83579 8.13583 6.16421 8.13584 5.75 8.55005C5.33579 8.96426 5.33579 9.63583 5.75 10.05L11.2929 15.5929C11.6834 15.9835 12.3166 15.9835 12.7071 15.5929L18.25 10.05C18.6642 9.63584 18.6642 8.96426 18.25 8.55005C17.8358 8.13584 17.1642 8.13584 16.75 8.55005L12.5657 12.7344C12.2533 13.0468 11.7467 13.0468 11.4343 12.7344Z" fill="currentColor" />
            </svg>
        </span>
        <!--end::Svg Icon--></a>
        <!--begin::Menu-->
        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-600 menu-state-bg-light-primary fw-semibold fs-7 w-125px py-4 drop_action" data-kt-menu="true">
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" id="'.$id.'" data-kt-menu-trigger ="click" class="menu-link px-3 view-item">View</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" id="'.$id.'" data-kt-menu-trigger ="click" class="menu-link px-3 edit-item">Edit</a>
            </div>
            <!--end::Menu item-->
            <!--begin::Menu item-->
            <div class="menu-item px-3">
                <a href="#" id="'.$id.'" data-kt-menu-trigger ="click" class="menu-link px-3 del-item" data-kt-ecommerce-category-filter="delete_row">Delete</a>
            </div>
            <!--end::Menu item-->
        </div>
        <!--end::Menu-->
    </div>
    ';
    return $action;
   }

    function strData($data) {
        $output = '';
        foreach ($data as $key => $value) {
            $output .= "$value, ";
        }

        $output = substr($output, 0, -2);

        return $output;
    }
    //get user role 
    function userRole($connect,$role){
        $query = " SELECT name FROM role WHERE id_role = ".$role."" ;
        $statement = $connect ->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        return $result['name'];
    }

    // upload files 
    function uploadFile($fielName,$fileSize,$fileTempName,$nameToDb,$path){

        if($fileSize /1024 > "25600") {
            $message = "La taille du fichier ne doit pas excéder 25 Mo.";
            echo json_encode([
                "error" => true,
            "message" => $message
            ]);
            exit(0);
        }

        if(is_uploaded_file($fileTempName)) {
            $fileNameToSaveDb = strtolower($nameToDb.'-'.$fielName);
            $nom_fichier_path = $path.strtolower($fileNameToSaveDb);

            if(!move_uploaded_file($fileTempName, $nom_fichier_path)) {
                $message = "Un problème se pose avec le fichier. Veuillez le remplacer.";
                echo json_encode([
                    "error" => true,
                    "message" => $message
                ]);
                exit(0);
            }
            return $fileNameToSaveDb;
        } else {
            $message = "Impossible de télécharger le fichier vers le serveur. Veuillez le remplacer.";
            echo json_encode([
                "error" => true,
                "message" => $message
            ]);
            exit(0);

        }
    }
    // actual fonction for status 
    function statusCheck($statut){
        switch ($statut) {
            case 'Actif':
                $class = " badge badge-light-success fw-bold fs-6 px-2 py-1 ms-2 text-center";
                break;
            case 'Indisponible':
                $class = " badge badge-light-warning fw-bold fs-6 px-2 py-1 ms-2 text-center";
                break;
            case 'Inactif':
                $class = " badge badge-light-danger fw-bold fs-6 px-2 py-1 ms-2 text-center";
                break;
                    
            default:
                # code...
                break;
        }
        $stat = '<div class="'.$class.'" id="stat">'.$statut.'</div>';
        return $stat ; 
    }
    // get batiment by ID
    function getBatByID($connect,$id){
        $query = " SELECT nom FROM batiment WHERE id_bat = ".$id."" ;
        $statement = $connect ->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        $bat = '
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column text-center">
                <span class="fw-bold text-center">'.$result['nom'].'</span>
            </div>
        </div>';
        return $bat;
    }
    // get service by ID
    function getServByID($connect,$id){
        $query = " SELECT nom FROM service WHERE id_service = ".$id."" ;
        $statement = $connect ->prepare($query);
        $statement->execute();
        $result = $statement->fetch();
        // var_dump($result);
        $bat = '
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column text-center">
                <span class="fw-bold text-center">'.$result['nom'].'</span>
            </div>
        </div>';
        return $bat;
    }
    // get magasin by ID
    function getMagByID($connect,$id = NULL){
        if ($id == NULL || $id == 0) {
            $nom = "Non Emmagasiné!";
        }else {
            $query = " SELECT nom FROM magasin WHERE id_mag = ".$id."" ;
            $statement = $connect ->prepare($query);
            $statement->execute();
            $result = $statement->fetch();
            switch ($result['nom']) {
                case NULL:
                    $nom = "Non Emmagasiné!";
                    break;
                
                default:
                $nom = $result['nom'];
                    break;
            }
        }
        
        $bat = '
        <div class="d-flex align-items-center">
            <div class="d-flex flex-column text-center">
                <span class="fw-bold text-center">'.$nom.'</span>
            </div>
        </div>';
        return $bat;
    }
