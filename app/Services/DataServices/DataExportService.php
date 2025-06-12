<?php

namespace App\Services\DataServices;

use App\Services\DataServices\Factories\ExporterFactory;

class DataExportService {

    private $exporterFactory;

    public function __construct(ExporterFactory $exporterFactory) {
        $this->exporterFactory = $exporterFactory;
    }

    /**
     * @param string $type
     * @param array $parameters
     */
    public function export(string $type, array $parameters) {
        return $this->exporterFactory->make($type)->setParameters($parameters)->export();
    }
}
