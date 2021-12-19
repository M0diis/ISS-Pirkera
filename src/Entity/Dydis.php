<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Dydis
 *
 * @ORM\Table(name="dydis")
 * @ORM\Entity
 */
class Dydis
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_Dydis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idDydis;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=9, nullable=false, options={"fixed"=true})
     */
    private $name;

    public function getIdDydis(): ?int
    {
        return $this->idDydis;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }


}
