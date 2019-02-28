<?php

namespace Rachel;

class Catalog
{
    private $epoch;
    private $entries = [];

    public function __construct($filename)
    {
        // The start of the reckoning of the catalog
        $epoch = strtotime("2001-01-01");

        $data = json_decode(file_get_contents($filename));
        $this->populate($data);
    }

    public function populate($data)
    {
        $this->entries = array_map(function ($entry) {
            return new Entry((array) $entry);
        }, $data);
    }

    public function getByIndex($index)
    {
        $total = count($this->entries) - 1;
        return $this->entries[$index % $total];
    }

    public function getForDate($date = false)
    {
        $day = $this->getDayIndexForDate($date);
        return $this->getByIndex($day);
    }

    public function getDayIndexForDate($date)
    {
        if (false === $date) {
            $time = strtotime('midnight');
        } else {
            $time = strtotime($date);
        }

        // Number of days since the epoch
        return ($time - $this->epoch) / 86400;
    }
}
