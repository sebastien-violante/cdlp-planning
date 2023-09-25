<?php

namespace App\Twig\Runtime;

use Datetime;
use Twig\Extension\RuntimeExtensionInterface;

class AppExtensionRuntime implements RuntimeExtensionInterface
{
    public function __construct()
    {
        // Inject dependencies if needed
    }

    public function daysBetweenTwoDates($arrivalDate)
    {
        $dateNow = new Datetime;
        if($arrivalDate > $dateNow) {
           return $dateNow->diff($arrivalDate)->format('%a');
        }        
    }
}
