<?php

class Uzsakymas {
    public int $uzsakymo_numeris;
    public float $suma;
    public int|null $mokejimo_budas;
    public int $busena;
    public string|null $ivykdymo_data;
    public Pardavejas $pardavejas;
    public Klientas $klientas;
    public Saskaita_faktura|null $saskaita_faktura;
}

?>