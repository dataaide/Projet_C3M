<?php

// **** TRAITEMENT DES SESSIONS ****//
function demarrerSession ()
{
    if (session_id() == "")
    {
      
        session_save_path(realpath("private/session"));
        // WARNING: 
        // IL FAUT CREER LE DOSSIER private/session
        
        // http://php.net/manual/fr/function.session-start.php
        session_start();
        // => PHP CREE LA VARIABLE $_SESSION POUR NOUS
    }
    
}

// enregistre une info (cle, valeur) dans la session de l'utilisateur
function ecrireSession ($cle, $valeur)
{
    // demarrer une session si aucune session n'est ouverte
    // et retrouve une session deja ouverte dans une autre page
    demarrerSession();
    
    // JE MEMORISE L'INFO DANS LE TABLEAU DE SESSION
    $_SESSION[$cle]     = $valeur;
    
    // A LA FIN DU PROGRAMME PHP
    // PHP VA AUTOMATIQUEMENT SAUVEGARDER LES INFOS DU TABLEAU 
    // DANS UN FICHIER DE SESSIONS
}

// recupere une info (cle, valeur) par sa cle
// ou si la cle n'existe pas 
// alors la fonction renvoie la valeur par défaut fournie en 2è paramètre
function lireSession ($cle, $valeurDefaut)
{
    // demarrer une session si aucune session n'est ouverte
    // et retrouve une session deja ouverte dans une autre page
    demarrerSession();

    $valeur = $valeurDefaut;
    
    // JE RECUPERE L'INFO DANS LE TABLEAU DE SESSION
    if (isset($_SESSION[$cle]))
    {
        $valeur = $_SESSION[$cle];
    }
    
    return $valeur;
}



function envoyerEmail ($email, $sujet, $contenuEmail)
{
    // SI ON UN VRAI HEBERGEMENT
    // http://php.net/manual/fr/function.mail.php
    // ENTETES A MODIFIER POUR VOTRE VRAI SITE
    $headers =  'From: webmaster@example.com' . "\r\n" .
                'Reply-To: webmaster@example.com' . "\r\n" .
                'X-Mailer: PHP/' . phpversion();
     
    mail($email, $sujet, $contenuEmail, $headers);
    
    // POUR DEBUG
    // ON VA ENREGISTRER L'EMAIL DANS UN FICHIER
    // (ON POURRAIT CREER UN SYSTEME D'ARCHIVES 
    // QUI ENREGISTRE TOUS LES EMAILS DANS MYSQL)
    file_put_contents("private/model/mail.txt", $contenuEmail, FILE_APPEND);
    
    ajouterLigneTable("outbox", [ 
                        "destinataire"  => $email, 
                        "sujet"         => $sujet, 
                        "message"       => $contenuEmail, 
                        //"dateCreation"  => date("Y-m-d H:i:s"),
                        ]);
}






function verifierUpload ($nameInput)
{
    $cheminOK = "";
    
    // POUR LE MESSAGE DE RETOUR
    $idForm = verifierSaisie("idForm");
    
    // CONTROLLER
    // VERIFIER SI IL Y A UN FICHIER UPLOADE
    // VERIFIER SI IL N'Y A PAS DE CODE D'ERREUR
    // VERIFIER LE SUFFIXE DU FICHIER 
    // (INTERDIRE .php, .asp, .jsp, etc...)
    // (AUTORISER CERTAINS SUFFIXES .jpeg, .jpg, .gif, .png, .svg, .pdf, .txt, .doc, .docx, .xls, .ppt, .pptx, .odt, .html, .css, .js, .ttf, .otf)
    // (ET NE PAS OUBLIER LES VARIANTES EN MAJUSCULES...)
    // FILTRER LE NOM DU FICHIER POUR ENLEVER LES CARACTERES BIZARRES POUR LES URLS
    // ON VA PRENDRE LA RESPONSABILITE DE SORTIR LE FICHIER DE SA QUARANTAINE
    // (IDEALEMENT IL FAUDRAIT PASSER LE FICHIER A TRAVERS UN ANTIVIRUS POUR DETECTER LES VIRUS :-/)
    // ET ON LE DEPLACE DANS LE DOSSIER assets/uploads/
    // (AVEC LE NOM FILTRE)
    
    // NOTE: 
    // POUR LES IMAGES, ON PEUT UTILISER DES FONCTIONS DE PHP
    // POUR CREER DES MINIATURES
    
    // EST-CE QUE LE TABLEAU $_FILES CONTIENT LA CLE $nameInput
    if (isset($_FILES[$nameInput]))
    {
        // EN HTML
        // <input type="file" name="upload" />
        // EN PHP
        $tabInfoFichierUploade = $_FILES[$nameInput];
        if (!empty($tabInfoFichierUploade))
        {
            $error = $tabInfoFichierUploade["error"];
            if ($error == 0)
            {
                // L'UPLOAD S'EST BIEN DEROULE
                // JE RECUPERE LES AUTRES INFOS
                $name       = $tabInfoFichierUploade["name"];
                $type       = $tabInfoFichierUploade["type"];
                $tmpName    = $tabInfoFichierUploade["tmp_name"];
                $size       = $tabInfoFichierUploade["size"];
                
                if ($size < 10 * 1024 * 1024) // 10 MEGAOCTETS
                {
                    // OK EN DESSOUS DE LA TAILLE LIMITE
                    // ON VERIFIE L'EXTENSION
                    // http://php.net/manual/fr/function.pathinfo.php
                    $extension = pathinfo($name, PATHINFO_EXTENSION);
                    // METTRE L'EXTENSION EN MINUSCULES
                    // http://php.net/manual/fr/function.strtolower.php
                    $extension = strtolower($extension);
                    
                    // IL FAUT VERIFIER SI L'EXTENSION EST AUTORISEE
                    $tabExtensionOK = 
                    [ 
                        "jpeg", "jpg", "gif", "png", "svg", 
                        "pdf", "txt", "doc", "docx", "xls", "ppt", "pptx", "odt", 
                        "html", "css", "js", 
                        "ttf", "otf"
                    ];
                    
                    // http://php.net/manual/fr/function.in-array.php
                    if (in_array($extension, $tabExtensionOK))
                    {
                        // OK EXTENSION AUTORISEE
                        // ON EST PRET A DEPLACER LE FICHIER DANS SON DOSSIER assets/uploads
                        // http://php.net/manual/fr/function.preg-replace.php
                        // TOUS LES CARACTERES QUI NE SONT DES LETTRES ENTRE a et z ou entre A et Z ou entre 0 et 9 ou qui ne sont -, _, .
                        // ALORS IL FAUT REMPLACER PAR LE CARACTERE "" (EN FAIT LES SUPPRIMER)
                        $nameOK     =  preg_replace("/[^a-zA-Z0-9-_\.]/", "", $name);
                        $cheminOK   = "assets/uploads/$nameOK";
                        
                        // TRANSFORMER LE CHEMIN OK EN MINUSCULES
                        $cheminOK = strtolower($cheminOK);
                        
                        // ON SORT LE FICHIER DE SA QUARANTAINE
                        // http://php.net/manual/fr/function.move-uploaded-file.php
                        move_uploaded_file($tmpName, $cheminOK);
                        
                    }
                    else
                    {
                        // KO
                        // EXTENSION NON AUTORISEE
                        $GLOBALS[$idForm . "Retour"] = "EXTENSION NON CONFORME";
                    }
                }
                else 
                {
                    // KO
                    // FICHIER TROP VOLUMINEUX
                    $GLOBALS[$idForm . "Retour"] = "FICHIER TROP VOLUMINEUX";
                }
            }
        }
    }
        
    return $cheminOK;
}


// EN HTML
// <input name="toto" />
// EN PHP
// $toto = verifierSaisie("toto");

function verifierSaisie ($name)
{
    $valeurSaisie = ""; // AU DEBUT ON A LA CHAINE VIDE
    
    // http://php.net/manual/fr/reserved.variables.request.php
    // JE VERIFIE SI L'INFO EST PRESENTE
    if (isset($_REQUEST[$name]))
    {
        // ALORS JE LA STOCKE DANS UNE VARIABLE PHP
        $valeurSaisie = $_REQUEST[$name];
        
        // FILTRER LA VALEUR POUR SE PROTEGER UN PEU
        
        // ENLEVER LES BALISES HTML ET PHP
        // http://php.net/manual/fr/function.strip-tags.php
        $valeurSaisie = strip_tags($valeurSaisie);
        
        // ENLEVER LES ESPACES VIDES AU DEBUT ET A LA FIN
        // http://php.net/manual/fr/function.trim.php
        $valeurSaisie = trim($valeurSaisie);
        
        // http://php.net/manual/fr/function.ctype-alpha.php
        // http://php.net/manual/fr/function.str-replace.php
        // http://php.net/manual/fr/function.preg-replace.php
        
    }
    
    // RENVOIE LA VALEUR DE $valeurSaisie
    return $valeurSaisie;

}

// CONTRAINTES
// AU MOINS 5 LETTRES
// SEULEMENT DES LETTRES ET DES CHIFFRES
function verifierPseudo ($pseudo)
{
    $resultat = false;  // MODE PARANO
    
    /*
    if ($pseudo != "")
    {
        // ON VEUT QUE LE PSEUDO FASSE AU MOINS 5 LETTRES
        // http://php.net/manual/en/function.mb-strlen.php
        if (mb_strlen($pseudo) >= 5)
        {
            // http://php.net/manual/en/function.ctype-alnum.php
            // ON VEUT SEULEMENT DES LETTRES ET DES CHIFFRES
            if (ctype_alnum($pseudo))
            {
                $resultat = true;
            }
        }
    }
    */
    
    if ( (mb_strlen($pseudo) >= 5) && ctype_alnum($pseudo) )
    {
        $resultat = true;
    }

    return $resultat;
}

// CONTRAINTES
// FORMAT D'UN EMAIL (nom@domaine.suffixe)
function verifierEmail ($email)
{
    $resultat = false;
    
    // http://php.net/manual/en/function.filter-var.php
    if ( ($email != "") && (filter_var($email, FILTER_VALIDATE_EMAIL) !== false) )
    {
        $resultat = true;
    }
    
    return $resultat;
}

// AU MOINS 8 LETTRES
function verifierPassword ($password)
{
    $resultat = false;  // MODE PARANO

    if (mb_strlen($password) >= 8)
    {
        $resultat = true;
    }

    return $resultat;    
}


// VERSION PLUS EVOLUEE EN FONCTIONNEL
// POUR POUVOIR VERIFIER LA LISTE DES ENTREES DU FORMULAIRE
// ET AINSI POUVOIR RENVOYER TOUS LES MESSAGES D'ERREUR EN UNE SEULE FOIS

function verifierSaisieListe ($tabNameType)
{
   $tabNameValeur = [];
   $tabNameErreur = [];
   
   // on parcourt chaque element du tableau 
   // et on recupère chaque info du formulaire
   // suivant le type, on vérifie si la valeur saisie est correcte
   foreach($tabNameType as $name => $type)
   {
       switch ($type)
       {
            case "email":
               $valeurSaisie = verifierSaisie($name);
               $erreurSaisie = verifierErreurEmail($valeurSaisie);
               break;
            case "password":
               $valeurSaisie = verifierSaisie($name);
               $erreurSaisie = verifierErreurPassword($valeurSaisie);
               break;
            case "pseudo":
               $valeurSaisie = verifierSaisie($name);
               $erreurSaisie = verifierErreurPseudo($valeurSaisie);
               break;
            case "text1":
               $valeurSaisie = verifierSaisie($name);
               $erreurSaisie = verifierErreurText1($valeurSaisie);
               break;
            default:
               $valeurSaisie = verifierSaisie($name);
               $erreurSaisie = "";
               break;
       }
       // ajouter la valeur dans le tableau
       $tabNameValeur[$name] = $valeurSaisie;
       if ($erreurSaisie != "")
       {
           // ajouter l'erreur dans le tableau
           $tabNameErreur[] = $erreurSaisie;
       }
   }
   // on retourne les 2 tableaux
   return [ $tabNameValeur, $tabNameErreur ];
}

function verifierErreurPseudo ($pseudo)
{
    $resultat = "";  // MODE OPTIMISTE
    
    if ( (mb_strlen($pseudo) < 5) || !ctype_alnum($pseudo) )
    {
        $resultat = "LE PSEUDO EST INCORRECT ($pseudo)";
    }

    return $resultat;
}

function verifierErreurEmail ($email)
{
    $resultat = "";
    
    // http://php.net/manual/en/function.filter-var.php
    if ( ($email == "") || (filter_var($email, FILTER_VALIDATE_EMAIL) === false) )
    {
       $resultat = "L'EMAIL EST INCORRECT ($email)";
    }
    
    return $resultat;
}

function verifierErreurPassword ($password)
{
    $resultat = "";

    if (mb_strlen($password) < 8)
    {
       $resultat = "LE PASSWORD EST INCORRECT ($password)";
    }

    return $resultat;    
}