<?php

namespace App\Twig;

use Twig\Extension\AbstractExtension;

class AppExtension extends AbstractExtension
{
    public function daysBetweenTwoDates($arrivalDate) {
        $dateNow = new \Datetime();
        $daysLeft = $dateNow->diff($arrivalDate);
        return $daysLeft;
    }
}