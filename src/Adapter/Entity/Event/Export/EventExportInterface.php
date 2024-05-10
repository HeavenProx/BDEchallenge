<?php

namespace App\Adapter\Entity\Event\Export;

interface EventExportInterface
{
    public function export(array $events): string;
}
