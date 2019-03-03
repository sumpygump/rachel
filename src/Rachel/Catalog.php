<?php

namespace Rachel;

class Catalog
{
    private $epoch;
    private $entries = [];

    public function __construct($filename = null)
    {
        // The start of the reckoning of the catalog
        $this->epoch = strtotime("2001-01-01");

        if ($filename !== null) {
            if (!file_exists($filename)) {
                throw new \InvalidArgumentException("File '$filename' not found");
            }

            $data = json_decode(file_get_contents($filename));

            if ($data == null || !is_array($data)) {
                throw new \InvalidArgumentException("File '$filename' is not a valid catalog json file");
            }
            $this->populate($data);
        }
    }

    public function populate($data)
    {
        $this->entries = array_filter(
            array_map(
                function ($entry) {
                    if (!isset($entry->name) || !isset($entry->url)) {
                        return null;
                    }
                    return new Entry((array) $entry);
                },
                $data
            ),
            function ($entry) {
                return $entry != null;
            }
        );
    }

    public function getEntries()
    {
        return $this->entries;
    }

    public function getByIndex($index)
    {
        $total = count($this->entries);
        return $this->entries[$index % $total];
    }

    public function getForDate($date = false)
    {
        $day = $this->getDayIndexForDate($date);
        return $this->getByIndex($day);
    }

    public function getDayIndexForDate($date = false)
    {
        if (false === $date) {
            $time = strtotime(date('Y-m-d'));
        } else {
            $time = strtotime($date);
        }

        // Number of days since the epoch
        return floor(($time - $this->epoch) / 86400);
    }
}
