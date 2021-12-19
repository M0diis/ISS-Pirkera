<?php

class Sandelis {
    public int $id;
    public string $kontaktinis_telefonas;
    public int $bendras_prekiu_kiekis;
    public int $darbuotoju_skaicius;
    public int $dydis;
    public array $sandelio_uzsakymai;
    public array $prekes;
    public Sandelininkas $sandelininkas;
    public Adresas $adresas;
}

?>