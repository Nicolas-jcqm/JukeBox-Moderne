<?php

namespace Controllers;

use Models\Administrator;


final class AdminController
{
    
    public function __construct(){
    }

    public function Signup($request,$response){
        $erreurArray=array();
        
        if(isset($request)){
            $name = $request->post('name');
            echo $name;
            var_dump($request);
            $firstName = $request->post('firstName');
            $email = $request->post('mail');
            $pass = $request->post('password');
            
            if(empty($firstName)){
                $erreurNom ="Merci d'entrer un nom";
               array_push($erreurArray,$erreurNom);

            }else{

                if($firstName != filter_var($firstName, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)){
                    $erreurFiltre ="Merci d'entrer un prénom valide";
                    array_push($erreurArray,$erreurFiltre);
                }
            }
            if(empty($name)){
                $erreurName ="Merci d'entrer un prénom";
                array_push($erreurArray,$erreurName);
            }else{
                if(!filter_var($name, FILTER_SANITIZE_STRING,FILTER_FLAG_STRIP_HIGH)){
                    $erreurNameFiltre ="Merci d'entrer un nom valide";
                    array_push($erreurArray,$erreurNameFiltre);                }
            }
            if(empty($email)){
                $erreurEmail = "Veuillez entrer un email";
                array_push($erreurArray,$erreurEmail);
            }else {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $erreurMailFiltre = "Merci d'entrer un email valide";
                    array_push($erreurArray,$erreurMailFiltre);
                }
                if(Administrator::where('mail', '=', $email)->exists()){
                    $erreurEmailExist = "L'email existe déja";
                    array_push($erreurArray,$erreurEmailExist);
                }
            }

            if (sizeof($erreurArray) ===0 ){
                $password = password_hash($pass, PASSWORD_DEFAULT, array(
                    'cost' => 12,
                ));

                $Administrator = new Administrator();
                $Administrator->name =$name;
                $Administrator->firstName = $firstName;
                $Administrator->mail = $email;
                $Administrator->password = $password;
                $Administrator->save();
                //return code 200
                return $response->withJson(['Status Inscription' => 'Validé'], 201);

            }

            else{
                //return $response->withJson(['Status Inscription' => 'Erreur','Type' => 'Unprocessable entity', 'Erreurs' => $erreurArray ], 422);
            }

    
        }else{
            return $response->withJson(['Status Inscription' => 'Erreur','Type' => 'Unknow', 'Erreurs' => $erreurArray ], 500);
        }
    }

    public function Signin($request, $response){

        $parsedBody = $request;
        $errorArray=array();
        
        
        if(isset($_POST)){
            if (Administrator::where('mail', '=', $_POST['mail'])->exists()){
                
                $Administrator = Administrator::where('mail', '=', $_POST['mail'])->first();
                $password= $Administrator->password;
                
                if (password_verify($_POST['password'],$password)) {
                    
                    $_SESSION['Admin']= $Administrator->mail;
                    return $response->withJson(['Status connection' => 'Validé'], 200);
                }
                else{
                    
                    $erreurMpdExistPas = "Votre mot de passe est incorrect, veuillez essayer à nouveau  ";
                    array_push($errorArray,$erreurMpdExistPas);
                    
                    return $response->withJson(['Status connection' => 'Erreur','Type' => 'Unprocessable entity', 'Erreurs' => $erreurArray ], 422);

                }

            }else{
                $erreurMailExistPas="L'email n'existe pas";
                array_push($errorArray,$erreurMailExistPas);
                
                return $response->withJson(['Status connection' => 'Erreur','Type' => 'Unprocessable entity', 'Erreurs' => $erreurArray ], 422);

            }
        }else{
            $erreur="Une erreur est survenue";
            array_push($errorArray,$erreur);
            
            return $response->withJson(['Status connection' => 'Erreur', 'Erreurs' => $erreurArray ], 500);

        }
    }

    public function disconnect(Request $request, Response $response, $args){
        
        unset($_SESSION['Admin']);
        
        return $response->withJson(['Status connection' => 'Deconnecté'], 200);
        
    }
}
