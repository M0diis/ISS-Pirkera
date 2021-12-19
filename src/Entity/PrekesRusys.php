<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PrekesRusys
 *
 * @ORM\Table(name="prekes_rusys", indexes={@ORM\Index(name="Prekes_rusis_Preke", columns={"fk_Prekebarkodas"})})
 * @ORM\Entity
 */
class PrekesRusys
{
    /**
     * @var string
     *
     * @ORM\Column(name="pavadinimas", type="string", length=255, nullable=false)
     */
    private $pavadinimas;

    /**
     * @var int
     *
     * @ORM\Column(name="id_Prekes_rusis", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $idPrekesRusis;

    /**
     * @var \Prekes
     *
     * @ORM\ManyToOne(targetEntity="Prekes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="fk_Prekebarkodas", referencedColumnName="barkodas")
     * })
     */
    private $fkPrekebarkodas;

    public function getPavadinimas(): ?string
    {
        return $this->pavadinimas;
    }

    public function setPavadinimas(string $pavadinimas): self
    {
        $this->pavadinimas = $pavadinimas;

        return $this;
    }

    public function getIdPrekesRusis(): ?int
    {
        return $this->idPrekesRusis;
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
