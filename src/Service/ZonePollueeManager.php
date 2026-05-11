<?php

namespace App\Service;

use App\Entity\ZonePolluee;

class ZonePollueeManager
{
    public function validate(ZonePolluee $zone): bool
    {
        // Règle 1 : Niveau entre 1 et 10
        $niveau = $zone->getNiveauPollution();
        if ($niveau < 1 || $niveau > 10) {
            throw new \InvalidArgumentException('Le niveau de pollution doit être compris entre 1 et 10.');
        }

        // Règle 2 : Nom non vide
        if (empty($zone->getNomZone())) {
            throw new \InvalidArgumentException('Le nom de la zone est obligatoire.');
        }

        return true;
    }
}