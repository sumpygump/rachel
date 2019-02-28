<?php

namespace Rachel;

class Entry
{
    private $name;
    private $url;

    public function __construct($entry)
    {
        $this->name = $entry['name'] ?? '';
        $this->url = $entry['url'] ?? '';
    }

    public function __toString()
    {
        return sprintf("%s [%s]", $this->name, $this->url);
    }
}
