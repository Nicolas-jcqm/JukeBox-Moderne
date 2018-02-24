<?php

namespace Controllers;

use App\Models\Adminnistrator;
use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

final class AdminController
{
    
    public function __construct(){
    }

    public function Signup(Request $request, Response $response, $args){
        
        
        $parsedBody = $request;
        $erreurArray=array();
        
        
        if(isset($parsedBody)){
            $name = $parsedBody->getParsedBodyParam('name');
            $firstName = $parsedBody->getParsedBodyParam('firstName');
            $email = $parsedBody->getParsedBodyParam('mail');
            $pass = $parsedBody->getParsedBodyParam('password');

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
                if(Adminnistrator::where('mail', '=', $email)->exists()){
                    $erreurEmailExist = "L'email existe déja";
                    array_push($erreurArray,$erreurEmailExist);
                }
            }
            
            if (sizeof($erreurArray) ===0 ){
                $password = password_hash($pass, PASSWORD_DEFAULT, array(
                    'cost' => 12,
                ));

                $Adminnistrator = new Adminnistrator();
                $Adminnistrator->name =$name;
                $Adminnistrator->firstName = $firstName;
                $Adminnistrator->mail = $email;
                $Adminnistrator->password = $password;
                $Adminnistrator->save();
                
                
                //return code 200
                return $response->withJson(['Status Inscription' => 'Validé'], 201);

            }

            else{
                return $response->withJson(['Status Inscription' => 'Erreur','Type' => 'Unprocessable entity', 'Erreurs' => $erreurArray ], 422);
            }


        }else{
            return $response->withJson(['Status Inscription' => 'Erreur','Type' => 'Unknow', 'Erreurs' => $erreurArray ], 500);
        }
    }

    public function Signin(Request $request, Response $response, $args){

        $parsedBody = $request;
        $errorArray=array();
        
        
        if(isset($_POST)){
            if (Adminnistrator::where('mail', '=', $_POST['mail'])->exists()){
                
                $Adminnistrator = Adminnistrator::where('mail', '=', $_POST['mail'])->first();
                $password= $Adminnistrator->password;
                
                if (password_verify($_POST['password'],$password)) {
                    
                    $_SESSION['Admin']= $Adminnistrator->mail;
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
