<?php

namespace App\Entity;

use App\Repository\CourseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseRepository::class)]
class Course
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $last_updated = null;

    #[ORM\Column(length: 255)]
    private ?string $language = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_hours = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_videos = null;

    #[ORM\Column(nullable: true)]
    private ?int $total_articles = null;

    #[ORM\Column(nullable: true)]
    private ?int $downloadable_resources = null;

    #[ORM\Column(nullable: true)]
    private ?bool $multi_platform_access = null;

    #[ORM\Column]
    private ?bool $has_certificate = null;

    #[ORM\Column]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    private ?int $percentage_discount_for_price = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $video_thumbnail = null;

    #[ORM\ManyToOne(inversedBy: 'courses')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    /**
     * @var Collection<int, CourseSection>
     */
    #[ORM\OneToMany(targetEntity: CourseSection::class, mappedBy: 'course_id', orphanRemoval: true)]
    private Collection $courseSections;

    #[ORM\Column]
    private ?int $total_students = null;

    #[ORM\Column(nullable: true)]
    private ?array $tags = null;

    /**
     * @var Collection<int, CategoryCourse>
     */
    #[ORM\OneToMany(targetEntity: CategoryCourse::class, mappedBy: 'course_id')]
    private Collection $categoryCourses;

    #[ORM\Column(nullable: true)]
    private ?int $level = null;

    /**
     * @var Collection<int, FavoriteCourse>
     */
    #[ORM\OneToMany(targetEntity: FavoriteCourse::class, mappedBy: 'course_id', orphanRemoval: true)]
    private Collection $favoriteCourses;

    /**
     * @var Collection<int, CoursePlaylist>
     */
    #[ORM\OneToMany(targetEntity: CoursePlaylist::class, mappedBy: 'course_id')]
    private Collection $coursePlaylists;

    /**
     * @var Collection<int, Coupon>
     */
    #[ORM\OneToMany(targetEntity: Coupon::class, mappedBy: 'course_id', orphanRemoval: true)]
    private Collection $coupons;

    /**
     * @var Collection<int, Feedback>
     */
    #[ORM\OneToMany(targetEntity: Feedback::class, mappedBy: 'course_id')]
    private Collection $feedbacks;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated_at = null;

    #[ORM\Column]
    private ?bool $is_published = null;

    public function __construct()
    {
        $this->courseSections = new ArrayCollection();
        $this->categoryCourses = new ArrayCollection();
        $this->favoriteCourses = new ArrayCollection();
        $this->coursePlaylists = new ArrayCollection();
        $this->coupons = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getLastUpdated(): ?\DateTimeInterface
    {
        return $this->last_updated;
    }

    public function setLastUpdated(\DateTimeInterface $last_updated): static
    {
        $this->last_updated = $last_updated;

        return $this;
    }

    public function getLanguage(): ?string
    {
        return $this->language;
    }

    public function setLanguage(string $language): static
    {
        $this->language = $language;

        return $this;
    }

    public function getTotalHours(): ?int
    {
        return $this->total_hours;
    }

    public function setTotalHours(?int $total_hours): static
    {
        $this->total_hours = $total_hours;

        return $this;
    }

    public function getTotalVideos(): ?int
    {
        return $this->total_videos;
    }

    public function setTotalVideos(?int $total_videos): static
    {
        $this->total_videos = $total_videos;

        return $this;
    }

    public function getTotalArticles(): ?int
    {
        return $this->total_articles;
    }

    public function setTotalArticles(?int $total_articles): static
    {
        $this->total_articles = $total_articles;

        return $this;
    }

    public function getDownloadableResources(): ?int
    {
        return $this->downloadable_resources;
    }

    public function setDownloadableResources(?int $downloadable_resources): static
    {
        $this->downloadable_resources = $downloadable_resources;

        return $this;
    }

    public function isMultiPlatformAccess(): ?bool
    {
        return $this->multi_platform_access;
    }

    public function setMultiPlatformAccess(?bool $multi_platform_access): static
    {
        $this->multi_platform_access = $multi_platform_access;

        return $this;
    }

    public function hasCertificate(): ?bool
    {
        return $this->has_certificate;
    }

    public function setHasCertificate(bool $has_certificate): static
    {
        $this->has_certificate = $has_certificate;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;

        return $this;
    }

    public function getPercentageDiscountForPrice(): ?int
    {
        return $this->percentage_discount_for_price;
    }

    public function setPercentageDiscountForPrice(?int $percentage_discount_for_price): static
    {
        $this->percentage_discount_for_price = $percentage_discount_for_price;

        return $this;
    }

    public function getVideoThumbnail(): ?string
    {
        return $this->video_thumbnail;
    }

    public function setVideoThumbnail(?string $video_thumbnail): static
    {
        $this->video_thumbnail = $video_thumbnail;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, CourseSection>
     */
    public function getCourseSections(): Collection
    {
        return $this->courseSections;
    }

    public function addCourseSection(CourseSection $courseSection): static
    {
        if (!$this->courseSections->contains($courseSection)) {
            $this->courseSections->add($courseSection);
            $courseSection->setCourse($this);
        }

        return $this;
    }

    public function removeCourseSection(CourseSection $courseSection): static
    {
        if ($this->courseSections->removeElement($courseSection)) {
            // set the owning side to null (unless already changed)
            if ($courseSection->getCourse() === $this) {
                $courseSection->setCourse(null);
            }
        }

        return $this;
    }

    public function getTotalStudents(): ?int
    {
        return $this->total_students;
    }

    public function setTotalStudents(int $total_students): static
    {
        $this->total_students = $total_students;

        return $this;
    }

    public function getTags(): ?array
    {
        return $this->tags;
    }

    public function setTags(?array $tags): static
    {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return Collection<int, CategoryCourse>
     */
    public function getCategoryCourses(): Collection
    {
        return $this->categoryCourses;
    }

    public function addCategoryCourse(CategoryCourse $categoryCourse): static
    {
        if (!$this->categoryCourses->contains($categoryCourse)) {
            $this->categoryCourses->add($categoryCourse);
            $categoryCourse->setCourse($this);
        }

        return $this;
    }

    public function removeCategoryCourse(CategoryCourse $categoryCourse): static
    {
        if ($this->categoryCourses->removeElement($categoryCourse)) {
            // set the owning side to null (unless already changed)
            if ($categoryCourse->getCourse() === $this) {
                $categoryCourse->setCourse(null);
            }
        }

        return $this;
    }

    public function getLevel(): ?int
    {
        return $this->level;
    }

    public function setLevel(?int $level): static
    {
        $this->level = $level;

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
            $favoriteCourse->setCourse($this);
        }

        return $this;
    }

    public function removeFavoriteCourse(FavoriteCourse $favoriteCourse): static
    {
        if ($this->favoriteCourses->removeElement($favoriteCourse)) {
            // set the owning side to null (unless already changed)
            if ($favoriteCourse->getCourse() === $this) {
                $favoriteCourse->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, CoursePlaylist>
     */
    public function getCoursePlaylists(): Collection
    {
        return $this->coursePlaylists;
    }

    public function addCoursePlaylist(CoursePlaylist $coursePlaylist): static
    {
        if (!$this->coursePlaylists->contains($coursePlaylist)) {
            $this->coursePlaylists->add($coursePlaylist);
            $coursePlaylist->setCourse($this);
        }

        return $this;
    }

    public function removeCoursePlaylist(CoursePlaylist $coursePlaylist): static
    {
        if ($this->coursePlaylists->removeElement($coursePlaylist)) {
            // set the owning side to null (unless already changed)
            if ($coursePlaylist->getCourse() === $this) {
                $coursePlaylist->setCourse(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Coupon>
     */
    public function getCoupons(): Collection
    {
        return $this->coupons;
    }

    public function addCoupon(Coupon $coupon): static
    {
        if (!$this->coupons->contains($coupon)) {
            $this->coupons->add($coupon);
            $coupon->setCourse($this);
        }

        return $this;
    }

    public function removeCoupon(Coupon $coupon): static
    {
        if ($this->coupons->removeElement($coupon)) {
            // set the owning side to null (unless already changed)
            if ($coupon->getCourse() === $this) {
                $coupon->setCourse(null);
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
            $feedback->setCourse($this);
        }

        return $this;
    }

    public function removeFeedback(Feedback $feedback): static
    {
        if ($this->feedbacks->removeElement($feedback)) {
            // set the owning side to null (unless already changed)
            if ($feedback->getCourse() === $this) {
                $feedback->setCourse(null);
            }
        }

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(?\DateTimeInterface $updated_at): static
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function isPublished(): ?bool
    {
        return $this->is_published;
    }

    public function setPublished(bool $is_published): static
    {
        $this->is_published = $is_published;

        return $this;
    }
}