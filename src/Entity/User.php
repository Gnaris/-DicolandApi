<?php

namespace App\Entity;

class User{

    public ?int $id_membre = null;
    public ?string $login = null;
    public ?string $password = null;
    public ?string $email = null;
    public ?bool $mailinglist = null;
    public ?bool $societe = null;
    public ?string $nomsociete = null;
    public ?string $intracommu = null;
    public ?int $civilite = null;
    public ?string $nom = null;
    public ?string $prenom = null;
    public ?string $adresse1 = null;
    public ?string $adresse2 = null;
    public ?string $adresse3 = null;
    public ?string $ville = null;
    public ?string $etat = null;
    public ?string $cp = null;
    public ?string $pays = null;
    public ?string $indicatif_tel = null;
    public ?string $tel = null;
    public ?string $indicatif_fax = null;
    public ?string $fax = null;
    public ?string $aplan = null;
    public ?string $inscr_date = null;
    public ?string $provenance = null;
    public ?int $totalcmd = null;
    public ?int $ca_ht = null;
    public ?int $enable = null;
    public ?string $comment = null;
}

?>