<?php

namespace App\Entity;
class DestinationSearch{

    /**
     * @var int/null
     */
    private $nbrPart;

    /**
     * @var int/null
     */
    private $nbrEvent;

    /**
     * @return int
     */
    public function getNbrPart(): int
    {
        return $this->nbrPart;
    }

    /**
     * @param int $nbrPart
     */
    public function setNbrPart(int $nbrPart): void
    {
        $this->nbrPart = $nbrPart;
    }

    /**
     * @return int
     */
    public function getNbrEvent(): int
    {
        return $this->nbrEvent;
    }

    /**
     * @param int $nbrEvent
     */
    public function setNbrEvent(int $nbrEvent): void
    {
        $this->nbrEvent = $nbrEvent;
    }



}
