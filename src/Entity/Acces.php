<?php

namespace App\Entity;

use App\Repository\AccesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AccesRepository::class)
 */
class Acces
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Utilisateur::class, inversedBy="acces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $UtilisateurdID;

    /**
     * @ORM\ManyToOne(targetEntity=Document::class, inversedBy="acces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $DocumentID;

    /**
     * @ORM\ManyToOne(targetEntity=Autorisation::class, inversedBy="acces")
     * @ORM\JoinColumn(nullable=false)
     */
    private $AutorisationID;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUtilisateurdID(): ?Utilisateur
    {
        return $this->UtilisateurdID;
    }

    public function setUtilisateurdID(?Utilisateur $UtilisateurdID): self
    {
        $this->UtilisateurdID = $UtilisateurdID;

        return $this;
    }

    public function getDocumentID(): ?Document
    {
        return $this->DocumentID;
    }

    public function setDocumentID(?Document $DocumentID): self
    {
        $this->DocumentID = $DocumentID;

        return $this;
    }

    public function getAutorisationID(): ?Autorisation
    {
        return $this->AutorisationID;
    }

    public function setAutorisationID(?Autorisation $AutorisationID): self
    {
        $this->AutorisationID = $AutorisationID;

        return $this;
    }
}
