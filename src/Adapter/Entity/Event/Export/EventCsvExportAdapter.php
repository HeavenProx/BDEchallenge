<?php

namespace App\Adapter\Entity\Event\Export;

class EventCsvExportAdapter implements EventExportInterface
{
    public function export(array $events): string
    {
        $output = "eventNumber,name,category,eventDate,location,description\n";
        foreach ($events as $event) {
            $output .= implode(',', $event) . "\n";
        }
        return $output;
    }
}
