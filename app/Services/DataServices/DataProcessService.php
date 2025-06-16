<?php

namespace App\Services\DataServices;

use App\Services\DataServices\Factories\{ImporterFactory, ValidatorFactory};
use App\Repositories\{PositionRepository, RegionRepository};
use League\Csv\Reader;
use League\Csv\Statement;

class DataProcessService {

    private $regionRepo;
    private $positionRepo;
    private $validatorFactory;
    private $importerFactory;

    public function __construct(RegionRepository $regionRepository, PositionRepository $positionRepository, ValidatorFactory $validatorFactory, ImporterFactory $importerFactory) {
        $this->regionRepo = $regionRepository;
        $this->positionRepo = $positionRepository;
        $this->validatorFactory = $validatorFactory;
        $this->importerFactory = $importerFactory;
    }

    public function importation($dataFile, $dataType) {

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');
            $headerFields = $csvReader->fetchOne(0);
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);

            $formattedRows = array_map(function ($row) use ($headerFields) {
                return array_combine($headerFields, $row);}, 
                iterator_to_array($records));

            // $mappingServices = $this->getImporationService($dataType);

            $mappingService = $this->importerFactory->make($dataType);

            return $mappingService->import($headerFields, $formattedRows);

        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }

    }

    public function validation($dataFile, $dataType) {

        $filePath = storage_path('app/public/'.$dataFile);
        if(file_exists($filePath)){
            $csvReader = Reader::createFromPath($filePath,'r');

            $headerFields = $csvReader->fetchOne(0);
            $csvReader->setHeaderOffset(0);
            $records = (new Statement())->process($csvReader);
            $mappingService = $this->validatorFactory->make($dataType);

            return $mappingService->validate($headerFields, $records);
        }
        else{
            echo 'File is not exists.'.PHP_EOL;
        }
    }
}
