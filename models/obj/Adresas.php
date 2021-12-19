<?php

class Adresas {
    public int $id;
    public string $pasto_kodas;
    public string $salis;
    public string $gatve;
    public string $pastato_nr;
    public string $miestas;
    public Sandelis $sandelis;
    public Ofisas $ofisas;
    public Vadovas $vadovas;
    public Klientas|null $klientas;
}

?>