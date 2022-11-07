<?php

namespace App\Entity;

class Track
{
    public function __construct(
        public string $id,

        public string $name,

        public int  $duration,

        public int  $trackNumber,

        public string $link,


    )
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDuration(int $duration): self
    {
        $this->duration = $duration;
        return $this;
    }

    public function getDuration(): int
    {
        return $this->duration;

    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function setTrackNumber(int $tracknumber): self
    {
        $this->trackNumber = $tracknumber;
        return $this;
    }

    public function getTrackNumber(): int
    {
        return $this->trackNumber;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }



}