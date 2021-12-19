<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SaskaitosFakturos
 *
 * @ORM\Table(name="saskaitos_fakturos", uniqueConstraints={@ORM\UniqueConstraint(name="fk_Klientasid_Naudotojas", columns={"fk_Klientasid_Naudotojas"})}, indexes={@ORM\Index(name="Saskaita_faktura_Buhalteris", columns={"fk_Buhalterisid_Naudotojas"})})
 * @ORM\Entity
 */
class SaskaitosFakturos
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
     * @var \Klientai
     *
     * @ORM\ManyToOne(targetEntity="Klientai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Klientasid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkKlientasidNaudotojas;

    /**
     * @var \Buhalteriai
     *
     * @ORM\ManyToOne(targetEntity="Buhalteriai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Buhalterisid_Naudotojas", referencedColumnName="id_Naudotojas")
     * })
     */
    private $fkBuhalterisidNaudotojas;

    public function getNumeris(): ?int
    {
        return $this->numeris;
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
