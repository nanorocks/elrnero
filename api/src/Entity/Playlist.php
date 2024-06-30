<?php

namespace App\Entity;

use App\Repository\PlaylistRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlaylistRepository::class)]
class Playlist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $created_at = null;

    /**
     * @var Collection<int, CoursePlaylist>
     */
    #[ORM\OneToMany(targetEntity: CoursePlaylist::class, mappedBy: 'playlist_id')]
    private Collection $coursePlaylists;

    public function __construct()
    {
        $this->coursePlaylists = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

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
            $coursePlaylist->setPlaylist($this);
        }

        return $this;
    }

    public function removeCoursePlaylist(CoursePlaylist $coursePlaylist): static
    {
        if ($this->coursePlaylists->removeElement($coursePlaylist)) {
            // set the owning side to null (unless already changed)
            if ($coursePlaylist->getPlaylist() === $this) {
                $coursePlaylist->setPlaylist(null);
            }
        }

        return $this;
    }
}