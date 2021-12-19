<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SandelioUzsakymai
 *
 * @ORM\Table(name="sandelio_uzsakymai", indexes={@ORM\Index(name="Sandelio_uzsakymas_Vadovas", columns={"fk_Vadovasid_Naudotojas"}), @ORM\Index(name="Sandelio_uzsakymas_Sandelis", columns={"fk_Sandelisid_Sandelis"}), @ORM\Index(name="busena", columns={"busena"})})
 * @ORM\Entity
 */
class SandelioUzsakymai
{
    /**
     * @var int
     *
     * @ORM\Column(name="numeris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $numeris;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="uzsakymo_data", type="date", nullable=false)
     */
    private $uzsakymoData;

    /**
     * @var int
     *
     * @ORM\Column(name="apimtis", type="integer", nullable=false)
     */
    private $apimtis;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="terminas", type="date", nullable=false)
     */
    private $terminas;

    /**
     * @var \UzsakymoBusena
     *
     * @ORM\ManyToOne(targetEntity="UzsakymoBusena")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="busena", referencedColumnName="id_Uzsakymo_busena")
     * })
     */
    private $busena;

    /**
     * @var \Vadovai
     *
     * @ORM\ManyToOne(targetEntity="Vadovai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Vadovasid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkVadovasidNaudotojas;

    /**
     * @var \Sandeliai
     *
     * @ORM\ManyToOne(targetEntity="Sandeliai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Sandelisid_Sandelis", referencedColumnName="id_Sandelis")
     * })
     */
    private $fkSandelisidSandelis;

    public function getNumeris(): ?int
    {
        return $this->numeris;
    }

    public function getUzsakymoData(): ?\DateTimeInterface
    {
        return $this->uzsakymoData;
    }

    public function setUzsakymoData(\DateTimeInterface $uzsakymoData): self
    {
        $this->uzsakymoData = $uzsakymoData;

        return $this;
    }

    public function getApimtis(): ?int
    {
        return $this->apimtis;
    }

    public function setApimtis(int $apimtis): self
    {
        $this->apimtis = $apimtis;

        return $this;
    }

    public function getTerminas(): ?\DateTimeInterface
    {
        return $this->terminas;
    }

    public function setTerminas(\DateTimeInterface $terminas): self
    {
        $this->terminas = $terminas;

        return $this;
    }

    public function getBusena(): ?UzsakymoBusena
    {
        return $this->busena;
    }

    public function setBusena(?UzsakymoBusena $busena): self
    {
        $this->busena = $busena;

        return $this;
    }

    public function getFkVadovasidNaudotojas(): ?Vadovai
    {
        return $this->fkVadovasidNaudotojas;
    }

    public function setFkVadovasidNaudotojas(?Vadovai $fkVadovasidNaudotojas): self
    {
        $this->fkVadovasidNaudotojas = $fkVadovasidNaudotojas;

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
