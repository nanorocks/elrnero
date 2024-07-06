<?php

namespace App\Entity;

use App\Repository\CouponRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CouponRepository::class)]
class Coupon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $code = null;

    #[ORM\Column]
    private ?bool $is_valid = null;

    #[ORM\Column]
    private ?int $absolute_discount = null;

    #[ORM\ManyToOne(inversedBy: 'coupons')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(): static
    {
        $this->code = $this->generateUniqueCode();

        return $this;
    }

    // Method to generate a unique coupon code
    public function generateUniqueCode(): string
    {
        // Generate a random string
        $randomString = bin2hex(random_bytes(4)); // Generates an 8-character string

        // Get the current timestamp
        $timestamp = time();

        // Combine the random string and timestamp to create a unique code
        $uniqueCode = strtoupper($randomString . $timestamp);

        return $uniqueCode;
    }

    public function isValid(): ?bool
    {
        return $this->is_valid;
    }

    public function setValid(bool $is_valid): static
    {
        $this->is_valid = $is_valid;

        return $this;
    }

    public function getAbsoluteDiscount(): ?int
    {
        return $this->absolute_discount;
    }

    public function setAbsoluteDiscount(int $absolute_discount): static
    {
        $this->absolute_discount = $absolute_discount;

        return $this;
    }

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }
}