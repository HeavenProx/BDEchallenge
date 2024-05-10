<?php

require_once 'src/Adapter/Entity/Event/Export/EventExportInterface.php';
require_once 'src/Adapter/Entity/Event/Export/EventCsvExportAdapter.php';
require_once 'src/Adapter/Entity/Event/Export/EventJsonExportAdapter.php';

use App\Adapter\Entity\Event\Export\EventCsvExportAdapter;
use App\Adapter\Entity\Event\Export\EventJsonExportAdapter;

$events = [
    [
        'eventNumber' => 1,
        'name' => 'Event 1',
        'category' => 'Music',
        'eventDate' => '2024-06-01',
        'location' => 'Paris',
        'description' => 'Music festival'
    ],
    [
        'eventNumber' => 2,
        'name' => 'Event 2',
        'category' => 'Art',
        'eventDate' => '2024-06-05',
        'location' => 'Lyon',
        'description' => 'Art exhibition'
    ]
];

// Tester l'export CSV
$csvExportAdapter = new EventCsvExportAdapter();
echo "CSV Export:\n";
echo $csvExportAdapter->export($events);

// Tester l'export JSON
$jsonExportAdapter = new EventJsonExportAdapter();
echo "\nJSON Export:\n";
echo $jsonExportAdapter->export($events);
