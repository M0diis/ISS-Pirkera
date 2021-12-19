<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Prekes
 *
 * @ORM\Table(name="prekes", indexes={@ORM\Index(name="Preke_Buhalteris", columns={"fk_Buhalterisid_Naudotojas"}), @ORM\Index(name="Preke_Sandelis", columns={"fk_Sandelisid_Sandelis"})})
 * @ORM\Entity
 */
class Prekes
{
    /**
     * @var int
     *
     * @ORM\Column(name="barkodas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $barkodas;

    /**
     * @var int
     *
     * @ORM\Column(name="kiekis", type="integer", nullable=false)
     */
    private $kiekis;

    /**
     * @var float
     *
     * @ORM\Column(name="kaina", type="float", precision=10, scale=0, nullable=false)
     */
    private $kaina;

    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=255, nullable=false)
     */
    private $pavadinimas;

    /**
     * @var \Sandeliai
     *
     * @ORM\ManyToOne(targetEntity="Sandeliai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Sandelisid_Sandelis", referencedColumnName="id_Sandelis")
     * })
     */
    private $fkSandelisidSandelis;

    /**
     * @var \Buhalteriai
     *
     * @ORM\ManyToOne(targetEntity="Buhalteriai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Buhalterisid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkBuhalterisidNaudotojas;

    public function getBarkodas(): ?int
    {
        return $this->barkodas;
    }

    public function getKiekis(): ?int
    {
        return $this->kiekis;
    }

    public function setKiekis(int $kiekis): self
    {
        $this->kiekis = $kiekis;

        return $this;
    }

    public function getKaina(): ?float
    {
        return $this->kaina;
    }

    public function setKaina(float $kaina): self
    {
        $this->kaina = $kaina;

        return $this;
    }

    public function getPavadinimas(): ?string
    {
        return $this->pavadinimas;
    }

    public function setPavadinimas(string $pavadinimas): self
    {
        $this->pavadinimas = $pavadinimas;

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

    public function getFkBuhalterisidNaudotojas(): ?Buhalteriai
    {
        return $this->fkBuhalterisidNaudotojas;
    }

    public function setFkBuhalterisidNaudotojas(?Buhalteriai $fkBuhalterisidNaudotojas): self
    {
        $this->fkBuhalterisidNaudotojas = $fkBuhalterisidNaudotojas;

        return $this;
    }


}
