<?php

namespace App\Service\Exporter;

use App\Entity\EventParticipant;
use DateTime;
use DateTimeZone;
use PhpOffice\PhpSpreadsheet\Exception;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Symfony\Component\HttpFoundation\HeaderUtils;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yectep\PhpSpreadsheetBundle\Factory;

class XlsExporter
{
    public function __construct(
        private readonly Factory $spreadsheetFactory
    ) {
    }

    /**
     * @param array|EventParticipant[] $objectToExport
     *
     * @throws Exception
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     * @throws \Exception
     */
    public function createEventReportByLaunchPoint(array $objectToExport): Spreadsheet
    {
        $spreadsheet = $this->spreadsheetFactory->createSpreadsheet();

        // List of launch points as we will have each one have its own sheet
        $launchPoints = [];
        $worksheets = [];
        $exportTime = new DateTime('now', new DateTimeZone('America/Chicago'));

        /** @var EventParticipant $participent */
        foreach ($objectToExport as $participent) {
            $worksheetName = $participent->getLaunchPoint()->getName();

            // Create all Worksheets we need, will add to these later
            if (!in_array($worksheetName, array_keys($launchPoints))) {
                $launchPoints[$worksheetName] = []; // this will hold the data we will insert
                $launchPoints[$worksheetName][] = ['Launch Point:', $worksheetName, 'Exported At:', $exportTime->format('d/m/y H:i')];
                $launchPoints[$worksheetName][] = []; // blank row

                $launchPoints[$worksheetName][] = array_keys($participent->getBasicSerialization());
                $worksheets[$worksheetName] = new Worksheet($spreadsheet, strlen($worksheetName) > 27 ? substr($worksheetName, 0, 27) : $worksheetName);
            }

            $launchPoints[$worksheetName][] = $participent->getBasicSerialization();
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

        return $spreadsheet;
    }

    /**
     * @param array|EventParticipant[] $participants
     *
     * @throws \PhpOffice\PhpSpreadsheet\Reader\Exception
     */
    public function createEventReport(array $participants): Spreadsheet
    {
        $spreadsheet = $this->spreadsheetFactory->createSpreadsheet();
        $worksheet = $spreadsheet->getSheetByName('Worksheet');

        $worksheet->fromArray(array_merge([array_keys($participants[0]->getExtendedSerialization())], array_map(function (EventParticipant $participant) {
            return $participant->getExtendedSerialization();
        }, $participants)));

        return $spreadsheet;
    }

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     */
    public function streamSpreadSheetResponse(
        Spreadsheet $spreadsheet, $type = IOFactory::WRITER_XLSX, $status = 200, $headers = [], $writerOptions = []
    ): StreamedResponse {
        $dispositionHeader = HeaderUtils::makeDisposition(
            HeaderUtils::DISPOSITION_ATTACHMENT,
            'Export.xlsx'
        );

        $headers = array_merge(
            $headers,
            [
                'Content-Disposition' => $dispositionHeader,
                'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
            ]
        );

        return $this->spreadsheetFactory->createStreamedResponse(
            $spreadsheet,
            $type,
            $status,
            $headers,
            $writerOptions
        );
    }
}
