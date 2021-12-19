<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Vadovai
 *
 * @ORM\Table(name="vadovai")
 * @ORM\Entity
 */
class Vadovai
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
     * @ORM\Column(name="imones_kodas", type="integer", nullable=false)
     */
    private $imonesKodas;

    /**
     * @var string
     *
     * @ORM\Column(name="imones_svetaine", type="string", length=255, nullable=false)
     */
    private $imonesSvetaine;

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

    public function getKontaktinisTelefonas(): ?string
    {
        return $this->kontaktinisTelefonas;
    }

    public function setKontaktinisTelefonas(string $kontaktinisTelefonas): self
    {
        $this->kontaktinisTelefonas = $kontaktinisTelefonas;

        return $this;
    }

    public function getImonesKodas(): ?int
    {
        return $this->imonesKodas;
    }

    public function setImonesKodas(int $imonesKodas): self
    {
        $this->imonesKodas = $imonesKodas;

        return $this;
    }

    public function getImonesSvetaine(): ?string
    {
        return $this->imonesSvetaine;
    }

    public function setImonesSvetaine(string $imonesSvetaine): self
    {
        $this->imonesSvetaine = $imonesSvetaine;

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
