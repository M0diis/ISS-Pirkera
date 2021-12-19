<?php

class Dovanu_cekis {
    public int $id_Dovanu_cekis;
    public string $kodas;
    public string $galiojimo_data;
    public float $verte;
    public int $fk_Pardavejasid_Naudotojas;
    public int $fk_Klientasid_Naudotojas;
    public int|null $fk_Uzsakymasid_Uzsakymas;
}

?>