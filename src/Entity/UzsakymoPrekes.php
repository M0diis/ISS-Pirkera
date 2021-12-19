<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UzsakymoPrekes
 *
 * @ORM\Table(name="uzsakymo_prekes", indexes={@ORM\Index(name="IDX_7786EE5D3AC3EE84", columns={"fk_Prekebarkodas"})})
 * @ORM\Entity
 */
class UzsakymoPrekes
{
    /**
     * @var int
     *
     * @ORM\Column(name="fk_Uzsakymasuzsakymo_numeris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $fkUzsakymasuzsakymoNumeris;

    /**
     * @var \Prekes
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Prekes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Prekebarkodas", referencedColumnName="barkodas")
     * })
     */
    private $fkPrekebarkodas;

    public function getFkUzsakymasuzsakymoNumeris(): ?int
    {
        return $this->fkUzsakymasuzsakymoNumeris;
    }

    public function getFkPrekebarkodas(): ?Prekes
    {
        return $this->fkPrekebarkodas;
    }

    public function setFkPrekebarkodas(?Prekes $fkPrekebarkodas): self
    {
        $this->fkPrekebarkodas = $fkPrekebarkodas;

        return $this;
    }


}
