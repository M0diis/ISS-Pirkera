<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Klientai
 *
 * @ORM\Table(name="klientai")
 * @ORM\Entity
 */
class Klientai
{
    /**
     * @var string|null
     *
     * @ORM\Column(name="asmens_kodas", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $asmensKodas = 'NULL';

    /**
     * @var string|null
     *
     * @ORM\Column(name="telefono_numeris", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $telefonoNumeris = 'NULL';

    /**
     * @var string
     *
     * @ORM\Column(name="el_pastas", type="string", length=255, nullable=false)
     */
    private $elPastas;

    /**
     * @var int|null
     *
     * @ORM\Column(name="amzius", type="integer", nullable=true, options={"default"="NULL"})
     */
    private $amzius = NULL;

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

    public function getAsmensKodas(): ?string
    {
        return $this->asmensKodas;
    }

    public function setAsmensKodas(?string $asmensKodas): self
    {
        $this->asmensKodas = $asmensKodas;

        return $this;
    }

    public function getTelefonoNumeris(): ?string
    {
        return $this->telefonoNumeris;
    }

    public function setTelefonoNumeris(?string $telefonoNumeris): self
    {
        $this->telefonoNumeris = $telefonoNumeris;

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

    public function getAmzius(): ?int
    {
        return $this->amzius;
    }

    public function setAmzius(?int $amzius): self
    {
        $this->amzius = $amzius;

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


}
