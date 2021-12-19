<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sandelininkai
 *
 * @ORM\Table(name="sandelininkai", indexes={@ORM\Index(name="Sandelininkas_Sandelis", columns={"fk_Sandelisid_Sandelis"}), @ORM\Index(name="pareigos", columns={"pareigos"})})
 * @ORM\Entity
 */
class Sandelininkai
{
    /**
     * @var int
     *
     * @ORM\Column(name="atilktu_siuntu_kiekis", type="integer", nullable=false)
     */
    private $atilktuSiuntuKiekis;

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
     * @var \Pareigos
     *
     * @ORM\ManyToOne(targetEntity="Pareigos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="pareigos", referencedColumnName="id_Pareigos")
     * })
     */
    private $pareigos;

    /**
     * @var \Sandeliai
     *
     * @ORM\ManyToOne(targetEntity="Sandeliai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Sandelisid_Sandelis", referencedColumnName="id_Sandelis")
     * })
     */
    private $fkSandelisidSandelis;

    public function getAtilktuSiuntuKiekis(): ?int
    {
        return $this->atilktuSiuntuKiekis;
    }

    public function setAtilktuSiuntuKiekis(int $atilktuSiuntuKiekis): self
    {
        $this->atilktuSiuntuKiekis = $atilktuSiuntuKiekis;

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

    public function getPareigos(): ?Pareigos
    {
        return $this->pareigos;
    }

    public function setPareigos(?Pareigos $pareigos): self
    {
        $this->pareigos = $pareigos;

        return $this;
    }

    public function getFkSandelisidSandelis(): ?Sandeliai
    {
        return $this->fkSandelisidSandelis;
    }

    public function setFkSandelisidSandelis(?Sandeliai $fkSandelisidSandelis): self
    {
        $this->fkSandelisidSandelis = $fkSandelisidSandelis;

        return $this;
    }


}
