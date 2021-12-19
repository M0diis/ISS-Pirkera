<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Pareigos
 *
 * @ORM\Table(name="pareigos")
 * @ORM\Entity
 */
class Pareigos
{
    /**
     * @var int
     *
     * @ORM\Column(name="id_Pareigos", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPareigos;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20, nullable=false, options={"fixed"=true})
     */
    private $name;

    public function getIdPareigos(): ?int
    {
        return $this->idPareigos;
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
