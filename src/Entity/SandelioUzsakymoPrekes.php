<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SandelioUzsakymoPrekes
 *
 * @ORM\Table(name="sandelio_uzsakymo_prekes", indexes={@ORM\Index(name="IDX_FBD31A4B3AC3EE84", columns={"fk_Prekebarkodas"})})
 * @ORM\Entity
 */
class SandelioUzsakymoPrekes
{
    /**
     * @var int
     *
     * @ORM\Column(name="fk_Sandelio_uzsakymasnumeris", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $fkSandelioUzsakymasnumeris;

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

    public function getFkSandelioUzsakymasnumeris(): ?int
    {
        return $this->fkSandelioUzsakymasnumeris;
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
