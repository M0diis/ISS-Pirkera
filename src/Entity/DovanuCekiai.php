<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DovanuCekiai
 *
 * @ORM\Table(name="dovanu_cekiai", uniqueConstraints={@ORM\UniqueConstraint(name="fk_Uzsakymasid_Uzsakymas", columns={"fk_Uzsakymasid_Uzsakymas"})}, indexes={@ORM\Index(name="Dovanu_cekis_Pardavejas", columns={"fk_Pardavejasid_Naudotojas"}), @ORM\Index(name="Dovanu_cekis_Klientas", columns={"fk_Klientasid_Naudotojas"})})
 * @ORM\Entity
 */
class DovanuCekiai
{
    /**
     * @var float
     *
     * @ORM\Column(name="verte", type="float", precision=10, scale=0, nullable=false)
     */
    private $verte;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="galiojimo_data", type="date", nullable=false)
     */
    private $galiojimoData;

    /**
     * @var string
     *
     * @ORM\Column(name="kodas", type="string", length=255, nullable=false)
     */
    private $kodas;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Dovanu_cekis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDovanuCekis;

    /**
     * @var \Uzsakymai
     *
     * @ORM\ManyToOne(targetEntity="Uzsakymai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Uzsakymasid_Uzsakymas", referencedColumnName="uzsakymo_numeris")
     * })
     */
    private $fkUzsakymasidUzsakymas;

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
     * @var \Klientai
     *
     * @ORM\ManyToOne(targetEntity="Klientai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Klientasid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkKlientasidNaudotojas;

    public function getVerte(): ?float
    {
        return $this->verte;
    }

    public function setVerte(float $verte): self
    {
        $this->verte = $verte;

        return $this;
    }

    public function getGaliojimoData(): ?\DateTimeInterface
    {
        return $this->galiojimoData;
    }

    public function setGaliojimoData(\DateTimeInterface $galiojimoData): self
    {
        $this->galiojimoData = $galiojimoData;

        return $this;
    }

    public function getKodas(): ?string
    {
        return $this->kodas;
    }

    public function setKodas(string $kodas): self
    {
        $this->kodas = $kodas;

        return $this;
    }

    public function getIdDovanuCekis(): ?int
    {
        return $this->idDovanuCekis;
    }

    public function getFkUzsakymasidUzsakymas(): ?Uzsakymai
    {
        return $this->fkUzsakymasidUzsakymas;
    }

    public function setFkUzsakymasidUzsakymas(?Uzsakymai $fkUzsakymasidUzsakymas): self
    {
        $this->fkUzsakymasidUzsakymas = $fkUzsakymasidUzsakymas;

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
