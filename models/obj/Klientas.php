<?php

class Klientas extends Naudotojas {
    public string $el_pastas;
    public int|null $amzius;
    public string|null $telefono_numeris;
    public string|null $asmens_kodas;
    public array $dovanu_cekiai;
    public array $uzsakymai;
    public array $saskaitos_fakturos;
    public Adresas $adresas;
}

?>