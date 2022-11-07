<?php

namespace App\Entity;

class Album
{

    public function __construct(
        public string $id,

        public string $name,


        public string $releaseDate,

        public int  $totalTracks,

        public string $link,

        public string $picture,

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

    public function setTotaltracks(int $totaltracks): self
    {
        $this->totalTracks = $totaltracks;
        return $this;
    }

    public function getTotaltracks(): int
    {
        return $this->totalTracks;

    }

    public function getReleaseDate(): string
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(string $date): self
    {
        $this->link = $date;
        return $this;
    }

    public function getLink(): string
    {
        return $this->link;
    }

    public function setLink(string $link): self
    {
        $this->link = $link;
        return $this;
    }


    public function getPicture(): string
    {
        return $this->picture;
    }

    public function setPicture(string $picture): self
    {
        $this->picture = $picture;
        return $this;
    }


}