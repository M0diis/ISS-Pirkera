<?php

class Adresas {
    public int $id_Adresas;
    public string $pasto_kodas;
    public string $salis;
    public string $gatve;
    public string $pastato_nr;
    public string $miestas;
    public int $fk_Sandelisid_Sandelis;
    public int $fk_Ofisasid_Ofisas;
    public int $fk_Vadovasid_Naudotojas;
    public int $fk_Klientasid_Naudotojas;
}

?>