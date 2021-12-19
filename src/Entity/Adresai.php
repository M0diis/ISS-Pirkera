<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adresai
 *
 * @ORM\Table(name="adresai", uniqueConstraints={@ORM\UniqueConstraint(name="fk_Ofisasid_Ofisas", columns={"fk_Ofisasid_Ofisas"}), @ORM\UniqueConstraint(name="fk_Vadovasid_Naudotojas", columns={"fk_Vadovasid_Naudotojas"}), @ORM\UniqueConstraint(name="fk_Klientasid_Naudotojas", columns={"fk_Klientasid_Naudotojas"}), @ORM\UniqueConstraint(name="fk_Sandelisid_Sandelis", columns={"fk_Sandelisid_Sandelis"})})
 * @ORM\Entity
 */
class Adresai
{
    /**
     * @var string
     *
     * @ORM\Column(name="pasto_kodas", type="string", length=255, nullable=false)
     */
    private $pastoKodas;

    /**
     * @var string
     *
     * @ORM\Column(name="salis", type="string", length=255, nullable=false)
     */
    private $salis;

    /**
     * @var string
     *
     * @ORM\Column(name="gatve", type="string", length=255, nullable=false)
     */
    private $gatve;

    /**
     * @var string
     *
     * @ORM\Column(name="pastato_nr", type="string", length=255, nullable=false)
     */
    private $pastatoNr;

    /**
     * @var string
     *
     * @ORM\Column(name="miestas", type="string", length=255, nullable=false)
     */
    private $miestas;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Adresas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idAdresas;

    /**
     * @var int
     *
     * @ORM\Column(name="fk_Ofisasid_Ofisas", type="integer", nullable=false)
     */
    private $fkOfisasidOfisas;

    /**
     * @var int
     *
     * @ORM\Column(name="fk_Vadovasid_Naudotojas", type="integer", nullable=false)
     */
    private $fkVadovasidNaudotojas;

    /**
     * @var int
     *
     * @ORM\Column(name="fk_Klientasid_Naudotojas", type="integer", nullable=false)
     */
    private $fkKlientasidNaudotojas;

    /**
     * @var \Sandeliai
     *
     * @ORM\ManyToOne(targetEntity="Sandeliai")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Sandelisid_Sandelis", referencedColumnName="id_Sandelis")
     * })
     */
    private $fkSandelisidSandelis;

    public function getPastoKodas(): ?string
    {
        return $this->pastoKodas;
    }

    public function setPastoKodas(string $pastoKodas): self
    {
        $this->pastoKodas = $pastoKodas;

        return $this;
    }

    public function getSalis(): ?string
    {
        return $this->salis;
    }

    public function setSalis(string $salis): self
    {
        $this->salis = $salis;

        return $this;
    }

    public function getGatve(): ?string
    {
        return $this->gatve;
    }

    public function setGatve(string $gatve): self
    {
        $this->gatve = $gatve;

        return $this;
    }

    public function getPastatoNr(): ?string
    {
        return $this->pastatoNr;
    }

    public function setPastatoNr(string $pastatoNr): self
    {
        $this->pastatoNr = $pastatoNr;

        return $this;
    }

    public function getMiestas(): ?string
    {
        return $this->miestas;
    }

    public function setMiestas(string $miestas): self
    {
        $this->miestas = $miestas;

        return $this;
    }

    public function getIdAdresas(): ?int
    {
        return $this->idAdresas;
    }

    public function getFkOfisasidOfisas(): ?int
    {
        return $this->fkOfisasidOfisas;
    }

    public function setFkOfisasidOfisas(int $fkOfisasidOfisas): self
    {
        $this->fkOfisasidOfisas = $fkOfisasidOfisas;

        return $this;
    }

    public function getFkVadovasidNaudotojas(): ?int
    {
        return $this->fkVadovasidNaudotojas;
    }

    public function setFkVadovasidNaudotojas(int $fkVadovasidNaudotojas): self
    {
        $this->fkVadovasidNaudotojas = $fkVadovasidNaudotojas;

        return $this;
    }

    public function getFkKlientasidNaudotojas(): ?int
    {
        return $this->fkKlientasidNaudotojas;
    }

    public function setFkKlientasidNaudotojas(int $fkKlientasidNaudotojas): self
    {
        $this->fkKlientasidNaudotojas = $fkKlientasidNaudotojas;

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
