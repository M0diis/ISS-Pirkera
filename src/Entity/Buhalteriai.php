<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Buhalteriai
 *
 * @ORM\Table(name="buhalteriai", indexes={@ORM\Index(name="Buhalteris_Ofisas", columns={"fk_Ofisasid_Ofisas"})})
 * @ORM\Entity
 */
class Buhalteriai
{
    /**
     * @var string
     *
     * @ORM\Column(name="el_pastas", type="string", length=255, nullable=false)
     */
    private $elPastas;

    /**
     * @var string
     *
     * @ORM\Column(name="telefono_numeris", type="string", length=255, nullable=false)
     */
    private $telefonoNumeris;

    /**
     * @var int
     *
     * @ORM\Column(name="kompiuterio_numeris", type="integer", nullable=false)
     */
    private $kompiuterioNumeris;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Naudotojas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idNaudotojas;

    /**
     * @var string
     *
     * @ORM\Column(name="vardas", type="string", length=255, nullable=false)
     */
    private $vardas;

    /**
     * @var string
     *
     * @ORM\Column(name="pavarde", type="string", length=255, nullable=false)
     */
    private $pavarde;

    /**
     * @var string
     *
     * @ORM\Column(name="vartotojo_vardas", type="string", length=255, nullable=false)
     */
    private $vartotojoVardas;

    /**
     * @var string
     *
     * @ORM\Column(name="banko_saskaita", type="string", length=255, nullable=false)
     */
    private $bankoSaskaita;

    /**
     * @var string
     *
     * @ORM\Column(name="darbo_laikas", type="string", length=255, nullable=false)
     */
    private $darboLaikas;

    /**
     * @var int
     *
     * @ORM\Column(name="virsvalandziu_skaicius", type="integer", nullable=false)
     */
    private $virsvalandziuSkaicius;

    /**
     * @var int
     *
     * @ORM\Column(name="atlyginimas", type="integer", nullable=false)
     */
    private $atlyginimas;

    /**
     * @var \Ofisai
     *
     * @ORM\ManyToOne(targetEntity="Ofisai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Ofisasid_Ofisas", referencedColumnName="id_Ofisas")
     * })
     */
    private $fkOfisasidOfisas;

    public function getElPastas(): ?string
    {
        return $this->elPastas;
    }

    public function setElPastas(string $elPastas): self
    {
        $this->elPastas = $elPastas;

        return $this;
    }

    public function getTelefonoNumeris(): ?string
    {
        return $this->telefonoNumeris;
    }

    public function setTelefonoNumeris(string $telefonoNumeris): self
    {
        $this->telefonoNumeris = $telefonoNumeris;

        return $this;
    }

    public function getKompiuterioNumeris(): ?int
    {
        return $this->kompiuterioNumeris;
    }

    public function setKompiuterioNumeris(int $kompiuterioNumeris): self
    {
        $this->kompiuterioNumeris = $kompiuterioNumeris;

        return $this;
    }

    public function getIdNaudotojas(): ?int
    {
        return $this->idNaudotojas;
    }

    public function getVardas(): ?string
    {
        return $this->vardas;
    }

    public function setVardas(string $vardas): self
    {
        $this->vardas = $vardas;

        return $this;
    }

    public function getPavarde(): ?string
    {
        return $this->pavarde;
    }

    public function setPavarde(string $pavarde): self
    {
        $this->pavarde = $pavarde;

        return $this;
    }

    public function getVartotojoVardas(): ?string
    {
        return $this->vartotojoVardas;
    }

    public function setVartotojoVardas(string $vartotojoVardas): self
    {
        $this->vartotojoVardas = $vartotojoVardas;

        return $this;
    }

    public function getBankoSaskaita(): ?string
    {
        return $this->bankoSaskaita;
    }

    public function setBankoSaskaita(string $bankoSaskaita): self
    {
        $this->bankoSaskaita = $bankoSaskaita;

        return $this;
    }

    public function getDarboLaikas(): ?string
    {
        return $this->darboLaikas;
    }

    public function setDarboLaikas(string $darboLaikas): self
    {
        $this->darboLaikas = $darboLaikas;

        return $this;
    }

    public function getVirsvalandziuSkaicius(): ?int
    {
        return $this->virsvalandziuSkaicius;
    }

    public function setVirsvalandziuSkaicius(int $virsvalandziuSkaicius): self
    {
        $this->virsvalandziuSkaicius = $virsvalandziuSkaicius;

        return $this;
    }

    public function getAtlyginimas(): ?int
    {
        return $this->atlyginimas;
    }

    public function setAtlyginimas(int $atlyginimas): self
    {
        $this->atlyginimas = $atlyginimas;

        return $this;
    }

    public function getFkOfisasidOfisas(): ?Ofisai
    {
        return $this->fkOfisasidOfisas;
    }

    public function setFkOfisasidOfisas(?Ofisai $fkOfisasidOfisas): self
    {
        $this->fkOfisasidOfisas = $fkOfisasidOfisas;

        return $this;
    }


}
