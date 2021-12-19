<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Uzsakymai
 *
 * @ORM\Table(name="uzsakymai", uniqueConstraints={@ORM\UniqueConstraint(name="fk_Saskaita_fakturanumeris", columns={"fk_Saskaita_fakturanumeris"})}, indexes={@ORM\Index(name="Uzsakymas_Klientas", columns={"fk_Klientasid_Naudotojas"}), @ORM\Index(name="mokejimo_budas", columns={"mokejimo_budas"}), @ORM\Index(name="busena", columns={"busena"}), @ORM\Index(name="Uzsakymas_Pardavejas", columns={"fk_Pardavejasid_Naudotojas"})})
 * @ORM\Entity
 */
class Uzsakymai
{
    /**
     * @var int
     *
     * @ORM\Column(name="uzsakymo_numeris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $uzsakymoNumeris;

    /**
     * @var float
     *
     * @ORM\Column(name="suma", type="float", precision=10, scale=0, nullable=false)
     */
    private $suma;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="ivykdymo_data", type="date", nullable=true, options={"default"="NULL"})
     */
    private $ivykdymoData = 'NULL';

    /**
     * @var \SaskaitosFakturos
     *
     * @ORM\ManyToOne(targetEntity="SaskaitosFakturos")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Saskaita_fakturanumeris", referencedColumnName="numeris")
     * })
     */
    private $fkSaskaitaFakturanumeris;

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
     * @var \Pardavejai
     *
     * @ORM\ManyToOne(targetEntity="Pardavejai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Pardavejasid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkPardavejasidNaudotojas;

    /**
     * @var \MokejimoBudas
     *
     * @ORM\ManyToOne(targetEntity="MokejimoBudas")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="mokejimo_budas", referencedColumnName="id_Mokejimo_budas")
     * })
     */
    private $mokejimoBudas;

    /**
     * @var \Klientai
     *
     * @ORM\ManyToOne(targetEntity="Klientai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Klientasid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkKlientasidNaudotojas;

    public function getUzsakymoNumeris(): ?int
    {
        return $this->uzsakymoNumeris;
    }

    public function getSuma(): ?float
    {
        return $this->suma;
    }

    public function setSuma(float $suma): self
    {
        $this->suma = $suma;

        return $this;
    }

    public function getIvykdymoData(): ?\DateTimeInterface
    {
        return $this->ivykdymoData;
    }

    public function setIvykdymoData(?\DateTimeInterface $ivykdymoData): self
    {
        $this->ivykdymoData = $ivykdymoData;

        return $this;
    }

    public function getFkSaskaitaFakturanumeris(): ?SaskaitosFakturos
    {
        return $this->fkSaskaitaFakturanumeris;
    }

    public function setFkSaskaitaFakturanumeris(?SaskaitosFakturos $fkSaskaitaFakturanumeris): self
    {
        $this->fkSaskaitaFakturanumeris = $fkSaskaitaFakturanumeris;

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

    public function getFkPardavejasidNaudotojas(): ?Pardavejai
    {
        return $this->fkPardavejasidNaudotojas;
    }

    public function setFkPardavejasidNaudotojas(?Pardavejai $fkPardavejasidNaudotojas): self
    {
        $this->fkPardavejasidNaudotojas = $fkPardavejasidNaudotojas;

        return $this;
    }

    public function getMokejimoBudas(): ?MokejimoBudas
    {
        return $this->mokejimoBudas;
    }

    public function setMokejimoBudas(?MokejimoBudas $mokejimoBudas): self
    {
        $this->mokejimoBudas = $mokejimoBudas;

        return $this;
    }

    public function getFkKlientasidNaudotojas(): ?Klientai
    {
        return $this->fkKlientasidNaudotojas;
    }

    public function setFkKlientasidNaudotojas(?Klientai $fkKlientasidNaudotojas): self
    {
        $this->fkKlientasidNaudotojas = $fkKlientasidNaudotojas;

        return $this;
    }


}
