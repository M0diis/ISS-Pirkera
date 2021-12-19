<?php

class Uzsakymas {
    public int $uzsakymo_numeris;
    public float $suma;
    public int|null $mokejimo_budas;
    public int $busena;
    public string|null $ivykdymo_data;
    public int $fk_Pardavejasid_Naudotojas;
    public int $fk_Klientasid_Naudotojas;
    public int|null $fk_Saskaita_fakturanumeris;
}

?>