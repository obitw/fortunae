<?php
namespace App\Casino\Util;

class GenerateurAleatoire
{
    private $seed;
    private $a;
    private $b;
    private $M;

    public function __construct($seed, $M)
    {
        $this->seed = $seed;
        $this->a = 1024;
        $this->b = 150889;
        $this->M = $M;
    }

    public function genererValeursAleatoires(array $liste): int
    {
        $this->seed = ($this->a * $this->seed + $this->b) % $this->M;
        $indice = $this->seed % count($liste);
        return $liste[$indice];
    }
}



