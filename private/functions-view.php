<?php

function afficherVarGlob ($nomVariable)
{
    if (isset($GLOBALS["$nomVariable"])) 
    {
        echo $GLOBALS["$nomVariable"];
    }
}