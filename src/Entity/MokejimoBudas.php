<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * MokejimoBudas
 *
 * @ORM\Table(name="mokejimo_budas")
 * @ORM\Entity
 */
class MokejimoBudas
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_Mokejimo_budas", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idMokejimoBudas;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=23, nullable=false, options={"fixed"=true})
     */
    private $name;

    public function getIdMokejimoBudas(): ?int
    {
        return $this->idMokejimoBudas;
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
