<?php

namespace App\Casino\configuration;

class ConfigurationSite
{
    private int $dureeDexpirationSession = 3600;

    public function getDureeDexpirationSession(): int
    {
        return $this->dureeDexpirationSession;
    }

    public static function getURLAbsolue(): string
    {
        return "https://webinfo.iutmontp.univ-montp2.fr/~georgesa/base-projet/web/controleurFrontal.php";
    }
}