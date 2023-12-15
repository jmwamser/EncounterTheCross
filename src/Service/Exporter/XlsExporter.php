<?php

namespace App\Service\Exporter;

use App\Entity\EventParticipant;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yectep\PhpSpreadsheetBundle\Factory;

class XlsExporter
{
    public function __construct(
        private Factory $spreadsheetFactory
    ) {
    }

    public function createResponse(array $objectToExport, string $filename = 'export.xlsx'): Response
    {
        $spreadsheet = $this->spreadsheetFactory->createSpreadsheet();

        // List of launch points as we will have each one have its own sheet
        $launchPoints = [];
        $worksheets = [];
        $exportTime = new \DateTime('now', new \DateTimeZone('America/Chicago'));

        /** @var EventParticipant $participent */
        foreach ($objectToExport as $participent) {
            $worksheetName = $participent->getLaunchPoint()->getName();

            // Create all Worksheets we need, will add to these later
            if (!in_array($worksheetName, array_keys($launchPoints))) {
                $launchPoints[$worksheetName] = []; // this will hold the data we will insert
                $launchPoints[$worksheetName][] = ['Launch Point:', $worksheetName, 'Exported At:', $exportTime->format('d/m/y H:i')];
                $launchPoints[$worksheetName][] = []; // blank row

                $launchPoints[$worksheetName][] = array_keys($participent->toArray());
                $worksheets[$worksheetName] = new Worksheet($spreadsheet, $worksheetName);
            }

            $launchPoints[$worksheetName][] = $participent->toArray();
        }

        foreach ($worksheets as $launchPointName => $worksheet) {
            $spreadsheet->addSheet(
                $worksheet->fromArray($launchPoints[$launchPointName])
            );
        }

        // remove the blank worksheet that was made in the beginning
        $sheetIndex = $spreadsheet->getIndex(
            $spreadsheet->getSheetByName('Worksheet')
        );
        $spreadsheet->removeSheetByIndex($sheetIndex);

        $response = new StreamedResponse(function () use ($spreadsheet) {
            //            $config = new ExporterConfig();
            //            $exporter = new Exporter($config);
            //            $exporter->export('php://output', $data);

            $writer = new Xlsx($spreadsheet);
            $writer->save('php://output');
        });
        $dispositionHeader = $response->headers->makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            $filename
        );
        $response->headers->set('Content-Disposition', $dispositionHeader);
        $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');

        return $response;
    }
}
