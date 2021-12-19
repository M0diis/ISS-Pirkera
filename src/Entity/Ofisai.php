<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ofisai
 *
 * @ORM\Table(name="ofisai", indexes={@ORM\Index(name="dydis", columns={"dydis"})})
 * @ORM\Entity
 */
class Ofisai
{
    /**
     * @var string
     *
     * @ORM\Column(name="kontaktinis_telefonas", type="string", length=255, nullable=false)
     */
    private $kontaktinisTelefonas;

    /**
     * @var int
     *
     * @ORM\Column(name="darbo_vietos", type="integer", nullable=false)
     */
    private $darboVietos;

    /**
     * @var string
     *
     * @ORM\Column(name="el_pastas", type="string", length=255, nullable=false)
     */
    private $elPastas;

    /**
     * @var int
     *
     * @ORM\Column(name="darbuotoju_skaicius", type="integer", nullable=false)
     */
    private $darbuotojuSkaicius;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Ofisas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idOfisas;

    /**
     * @var \Dydis
     *
     * @ORM\ManyToOne(targetEntity="Dydis")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="dydis", referencedColumnName="id_Dydis")
     * })
     */
    private $dydis;

    public function getKontaktinisTelefonas(): ?string
    {
        return $this->kontaktinisTelefonas;
    }

    public function setKontaktinisTelefonas(string $kontaktinisTelefonas): self
    {
        $this->kontaktinisTelefonas = $kontaktinisTelefonas;

        return $this;
    }

    public function getDarboVietos(): ?int
    {
        return $this->darboVietos;
    }

    public function setDarboVietos(int $darboVietos): self
    {
        $this->darboVietos = $darboVietos;

        return $this;
    }

    public function getElPastas(): ?string
    {
        return $this->elPastas;
    }

    public function setElPastas(string $elPastas): self
    {
        $this->elPastas = $elPastas;

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

    public function getIdOfisas(): ?int
    {
        return $this->idOfisas;
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
