<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Sandeliai
 *
 * @ORM\Table(name="sandeliai", indexes={@ORM\Index(name="dydis", columns={"dydis"})})
 * @ORM\Entity
 */
class Sandeliai
{
    /**
     * @var int
     *
     * @ORM\Column(name="bendras_prekiu_kiekis", type="integer", nullable=false)
     */
    private $bendrasPrekiuKiekis;

    /**
     * @var string
     *
     * @ORM\Column(name="kontaktinis_telefonas", type="string", length=255, nullable=false)
     */
    private $kontaktinisTelefonas;

    /**
     * @var int
     *
     * @ORM\Column(name="darbuotoju_skaicius", type="integer", nullable=false)
     */
    private $darbuotojuSkaicius;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Sandelis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idSandelis;

    /**
     * @var \Dydis
     *
     * @ORM\ManyToOne(targetEntity="Dydis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dydis", referencedColumnName="id_Dydis")
     * })
     */
    private $dydis;

    public function getBendrasPrekiuKiekis(): ?int
    {
        return $this->bendrasPrekiuKiekis;
    }

    public function setBendrasPrekiuKiekis(int $bendrasPrekiuKiekis): self
    {
        $this->bendrasPrekiuKiekis = $bendrasPrekiuKiekis;

        return $this;
    }

    public function getKontaktinisTelefonas(): ?string
    {
        return $this->kontaktinisTelefonas;
    }

    public function setKontaktinisTelefonas(string $kontaktinisTelefonas): self
    {
        $this->kontaktinisTelefonas = $kontaktinisTelefonas;

        return $this;
    }

    public function getDarbuotojuSkaicius(): ?int
    {
        return $this->darbuotojuSkaicius;
    }

    public function setDarbuotojuSkaicius(int $darbuotojuSkaicius): self
    {
        $this->darbuotojuSkaicius = $darbuotojuSkaicius;

        return $this;
    }

    public function getIdSandelis(): ?int
    {
        return $this->idSandelis;
    }

    public function getDydis(): ?Dydis
    {
        return $this->dydis;
    }

    public function setDydis(?Dydis $dydis): self
    {
        $this->dydis = $dydis;

        return $this;
    }


}
