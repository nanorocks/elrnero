<?php

namespace App\Entity;

use App\Repository\CourseSectionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CourseSectionRepository::class)]
class CourseSection
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToOne(inversedBy: 'courseSections')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Course $course = null;

    /**
     * @var Collection<int, CourseSectionContent>
     */
    #[ORM\OneToMany(targetEntity: CourseSectionContent::class, mappedBy: 'course_section_id')]
    private Collection $courseSectionContents;

    #[ORM\Column(nullable: true)]
    private ?int $order_num = null;

    public function __construct()
    {
        $this->courseSectionContents = new ArrayCollection();
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

    public function getCourse(): ?Course
    {
        return $this->course;
    }

    public function setCourse(?Course $course): static
    {
        $this->course = $course;

        return $this;
    }

    /**
     * @return Collection<int, CourseSectionContent>
     */
    public function getCourseSectionContents(): Collection
    {
        return $this->courseSectionContents;
    }

    public function addCourseSectionContent(CourseSectionContent $courseSectionContent): static
    {
        if (!$this->courseSectionContents->contains($courseSectionContent)) {
            $this->courseSectionContents->add($courseSectionContent);
            $courseSectionContent->setCourseSection($this);
        }

        return $this;
    }

    public function removeCourseSectionContent(CourseSectionContent $courseSectionContent): static
    {
        if ($this->courseSectionContents->removeElement($courseSectionContent)) {
            // set the owning side to null (unless already changed)
            if ($courseSectionContent->getCourseSection() === $this) {
                $courseSectionContent->setCourseSection(null);
            }
        }

        return $this;
    }

    public function getOrderNum(): ?int
    {
        return $this->order_num;
    }

    public function setOrderNum(?int $order_num): static
    {
        $this->order_num = $order_num;

        return $this;
    }
}
