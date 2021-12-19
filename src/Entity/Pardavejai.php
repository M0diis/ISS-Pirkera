<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pardavejai
 *
 * @ORM\Table(name="pardavejai")
 * @ORM\Entity
 */
class Pardavejai
{
    /**
     * @var int
     *
     * @ORM\Column(name="menesine_apyvarta", type="integer", nullable=false)
     */
    private $menesineApyvarta;

    /**
     * @var string
     *
     * @ORM\Column(name="parduotuves_vieta", type="string", length=255, nullable=false)
     */
    private $parduotuvesVieta;

    /**
     * @var int
     *
     * @ORM\Column(name="kasa", type="integer", nullable=false)
     */
    private $kasa;

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

    public function getMenesineApyvarta(): ?int
    {
        return $this->menesineApyvarta;
    }

    public function setMenesineApyvarta(int $menesineApyvarta): self
    {
        $this->menesineApyvarta = $menesineApyvarta;

        return $this;
    }

    public function getParduotuvesVieta(): ?string
    {
        return $this->parduotuvesVieta;
    }

    public function setParduotuvesVieta(string $parduotuvesVieta): self
    {
        $this->parduotuvesVieta = $parduotuvesVieta;

        return $this;
    }

    public function getKasa(): ?int
    {
        return $this->kasa;
    }

    public function setKasa(int $kasa): self
    {
        $this->kasa = $kasa;

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


}
