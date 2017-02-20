<?php

// MODE DEV
error_reporting(E_ALL);

// CHARGER LE CODE DE MES FONCTIONS
require_once("private/functions-model.php");
require_once("private/functions-view.php");
require_once("private/functions-controller.php");

// JE RECUPERE idForm POUR SAVOIR QUEL EST LE FORMULAIRE A TRAITER
$idForm = verifierSaisie("idForm");
if ($idForm != "")
{
    
    $cheminFichierTraitement = "private/controller/traitement-$idForm.php";
    // http://php.net/manual/fr/function.is-file.php
    if (is_file($cheminFichierTraitement))
    {
        // ALORS ON CHARGE LE CODE DE TRAITEMENT
        require_once($cheminFichierTraitement);
    }
}