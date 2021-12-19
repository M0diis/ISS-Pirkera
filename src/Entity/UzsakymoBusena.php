<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UzsakymoBusena
 *
 * @ORM\Table(name="uzsakymo_busena")
 * @ORM\Entity
 */
class UzsakymoBusena
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_Uzsakymo_busena", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idUzsakymoBusena;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=13, nullable=false, options={"fixed"=true})
     */
    private $name;

    public function getIdUzsakymoBusena(): ?int
    {
        return $this->idUzsakymoBusena;
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
