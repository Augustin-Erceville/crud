<?php
$age = new Age();
$resultat = new Age();

echo $age->age();
echo $resultat->verif_age();
class Age {
    private $age;
    private $resultat;
    public function __construct() {
        $age = 16;
        $this->age = $age;
        return $this->age;
    }
//--------------------------------------------------
    public function verif_age() {
        if ($this->age >= 18) {
            $this->resultat = "Vous êtes majeur";
        }if ($this->age < 18) {
            $this->resultat = "Vous êtes mineur";
        }
        return $this->resultat;
    }
//--------------------------------------------------
    public function age(){
    }
}

