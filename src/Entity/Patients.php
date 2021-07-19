<?php

namespace App\Entity;

use App\Repository\PatientsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;



/**
 * @ORM\Entity(repositoryClass=PatientsRepository::class)
 *   @UniqueEntity(
 *     fields={"lastname","firstname","email","birthDate"},
 *     message=" déjà utilisé."
 * )
 */
class Patients
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     *  @Assert\NotBlank
     */
    private $lastname;

    /**
     * @ORM\Column(type="string", length=50)
     *  @Assert\NotBlank
     */
    private $firstname;

    /**
     * @ORM\Column(type="date")
     *  @Assert\NotBlank
     */
    private $birthDate;

    /**
     * @ORM\Column(type="string", length=100)
     *  @Assert\NotBlank
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=11)
     *  @Assert\NotBlank
     */
    private $vitalcardNumber;

    /**
     * @ORM\OneToMany(targetEntity=Appointments::class, mappedBy="Patients", orphanRemoval=true)
     *  @Assert\NotBlank
     */
    private $appointments;

    public function __construct()
    {
        $this->appointments = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = mb_strtoupper($lastname);

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getBirthDate(): ?\DateTimeInterface
    {
        return $this->birthDate;
    }

    public function setBirthDate(\DateTimeInterface $birthDate): self
    {
        $this->birthDate = $birthDate;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getVitalcardNumber(): ?string
    {
        return $this->vitalcardNumber;
    }

    public function setVitalcardNumber(string $vitalcardNumber): self
    {
        $this->vitalcardNumber = $vitalcardNumber;

        return $this;
    }

    /**
     * @return Collection|Appointments[]
     */
    public function getAppointments(): Collection
    {
        return $this->appointments;
    }

    public function addAppointment(Appointments $appointment): self
    {
        if (!$this->appointments->contains($appointment)) {
            $this->appointments[] = $appointment;
            $appointment->setPatients($this);
        }

        return $this;
    }

    public function removeAppointment(Appointments $appointment): self
    {
        if ($this->appointments->removeElement($appointment)) {
            // set the owning side to null (unless already changed)
            if ($appointment->getPatients() === $this) {
                $appointment->setPatients(null);
            }
        }

        return $this;
    }
}
