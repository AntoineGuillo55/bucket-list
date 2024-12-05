<?php

namespace App\Form\Model;

class EventSearch
{

    private ?\DateTimeInterface $startDate = null;
    private ?string $city;

    /**
     * @param $startDate
     * @param $city
     */

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeInterface $startDate): void
    {
        $this->startDate = $startDate;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): void
    {
        $this->city = $city;
    }

}