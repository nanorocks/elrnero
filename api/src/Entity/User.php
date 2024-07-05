<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    #[ORM\Column]
    private ?bool $is_banned = false;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $short_bio = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $avatar = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $job_title = null;

    #[ORM\Column(nullable: true)]
    private ?array $soc_media = null;

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_USER'];

    /**
     * @var Collection<int, Course>
     */
    #[ORM\OneToMany(targetEntity: Course::class, mappedBy: 'user_id', orphanRemoval: true)]
    private Collection $courses;

    #[ORM\Column(nullable: true)]
    private ?bool $is_business_user = null;

    /**
     * @var Collection<int, FavoriteCourse>
     */
    #[ORM\OneToMany(targetEntity: FavoriteCourse::class, mappedBy: 'user_id', orphanRemoval: true)]
    private Collection $favoriteCourses;

    /**
     * @var Collection<int, feedback>
     */
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'user_id', orphanRemoval: true)]
    private Collection $feedbacks;

    public function __construct()
    {
        $this->courses = new ArrayCollection();
        $this->favoriteCourses = new ArrayCollection();
        $this->feedbacks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function isBanned(): ?bool
    {
        return $this->is_banned;
    }

    public function setBanned(bool $is_banned): static
    {
        $this->is_banned = $is_banned;

        return $this;
    }

    public function getShortBio(): ?string
    {
        return $this->short_bio;
    }

    public function setShortBio(?string $short_bio): static
    {
        $this->short_bio = $short_bio;

        return $this;
    }

    public function getAvatar(): ?string
    {
        if ($this->avatar === null) {
            return null;
        }

        return 'users/' . $this->avatar;
    }

    public function setAvatar(?string $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    public function getJobTitle(): ?string
    {
        return $this->job_title;
    }

    public function setJobTitle(?string $job_title): static
    {
        $this->job_title = $job_title;

        return $this;
    }

    public function getSocMedia(): ?array
    {
        return $this->soc_media;
    }

    public function setSocMedia(?array $soc_media): static
    {
        $this->soc_media = $soc_media;

        return $this;
    }

    /**
     * @return Collection<int, Course>
     */
    public function getCourses(): Collection
    {
        return $this->courses;
    }

    public function addCourse(Course $course): static
    {
        if (!$this->courses->contains($course)) {
            $this->courses->add($course);
            $course->setUser($this);
        }

        return $this;
    }

    public function removeCourse(Course $course): static
    {
        if ($this->courses->removeElement($course)) {
            // set the owning side to null (unless already changed)
            if ($course->getUser() === $this) {
                $course->setUser(null);
            }
        }

        return $this;
    }

    public function isBusinessUser(): ?bool
    {
        return $this->is_business_user;
    }

    public function setBusinessUser(?bool $is_business_user): static
    {
        $this->is_business_user = $is_business_user;

        return $this;
    }

    /**
     * @return Collection<int, FavoriteCourse>
     */
    public function getFavoriteCourses(): Collection
    {
        return $this->favoriteCourses;
    }

    public function addFavoriteCourse(FavoriteCourse $favoriteCourse): static
    {
        if (!$this->favoriteCourses->contains($favoriteCourse)) {
            $this->favoriteCourses->add($favoriteCourse);
            $favoriteCourse->setUser($this);
        }

        return $this;
    }

    public function removeFavoriteCourse(FavoriteCourse $favoriteCourse): static
    {
        if ($this->favoriteCourses->removeElement($favoriteCourse)) {
            // set the owning side to null (unless already changed)
            if ($favoriteCourse->getUser() === $this) {
                $favoriteCourse->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Feedback>
     */
    public function getFeedbacks(): Collection
    {
        return $this->feedbacks;
    }

    public function addFeedback(Feedback $feedback): static
    {
        if (!$this->feedbacks->contains($feedback)) {
            $this->feedbacks->add($feedback);
            $feedback->setUser($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedbacks->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getUser() === $this) {
                $feedback->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getSalt(): ?string
    {
        return 'secret';
    }

    public function eraseCredentials(): void
    {
        
    }

    /**
     * Returns the identifier for this user (e.g. username or email address).
     */
    public function getUserIdentifier(): string
    {
        return $this->email;
    }
}