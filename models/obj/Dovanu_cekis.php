<?php

class Dovanu_cekis {
    public int $id;
    public string $kodas;
    public string $galiojimo_data;
    public float $verte;
    public Pardavejas $pardavejas;
    public Klientas $klientas;
    public Uzsakymas|null $uzsakymas;
}

?>