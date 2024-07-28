<?php

namespace App\Entity;

use App\Enum\LeaveStatus;
use App\Enum\LeaveType;
use App\Repository\LeaveRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LeaveRepository::class)]
#[ORM\Table(name: '`leave`')]
class Leave
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $startDate = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $endDate = null;

    #[ORM\Column(length: 255)]
    private ?LeaveStatus $status = null;

    #[ORM\Column(length: 255)]
    private ?LeaveType $type = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $reason = null;

    #[ORM\ManyToOne(inversedBy: 'leaves')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Emp $emp = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(\DateTimeInterface $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeInterface
    {
        return $this->endDate;
    }

    public function setEndDate(\DateTimeInterface $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    public function __construct()
    {
        $this->status = LeaveStatus::Pending;
    }

    public function getStatus(): ?LeaveStatus
    {
        return $this->status;
    }

    public function setStatus(LeaveStatus $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function getType(): ?LeaveType
    {
        return $this->type;
    }

    public function setType(LeaveType $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getReason(): ?string
    {
        return $this->reason;
    }

    public function setReason(?string $reason): static
    {
        $this->reason = $reason;

        return $this;
    }

    public function getEmp(): ?Emp
    {
        return $this->emp;
    }

    public function setEmp(?Emp $emp): static
    {
        $this->emp = $emp;

        return $this;
    }

    private string $startDateFormatted;
    private string $endDateFormatted;

    #[ORM\Column(nullable: true)]
    private ?bool $managerResponse = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $denyReason = null;

    // Getters and setters
    public function getStartDateFormatted(): string
    {
        return $this->startDateFormatted;
    }

    public function setStartDateFormatted(string $startDateFormatted): self
    {
        $this->startDateFormatted = $startDateFormatted;
        return $this;
    }

    public function getEndDateFormatted(): string
    {
        return $this->endDateFormatted;
    }

    public function setEndDateFormatted(string $endDateFormatted): self
    {
        $this->endDateFormatted = $endDateFormatted;
        return $this;
    }

    public function isManagerResponse(): ?bool
    {
        return $this->managerResponse;
    }

    public function setManagerResponse(?bool $managerResponse): static
    {
        $this->managerResponse = $managerResponse;

        return $this;
    }

    public function getDenyReason(): ?string
    {
        return $this->denyReason;
    }

    public function setDenyReason(?string $denyReason): static
    {
        $this->denyReason = $denyReason;

        return $this;
    }
}
