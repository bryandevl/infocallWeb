<?php

namespace App\Helpers;

use App\Helpers\FormatHelper;
use File;
/*use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Common\Entity\Row;*/

class FileHelper
{
	public static function exportArrayToExcelHTML($reporte, $fileName)
	{
		header('Content-Type: text/html; charset=UTF-8');
        header("Content-type:application/vnd.ms-excel;charset=UTF-8");
        header("Content-Disposition:atachment;filename=".$fileName);
        header("Pragma:no-cache");
        header("Expires:0");

        $cab = 1;
        echo '<table border="0">';
        foreach ($reporte as $data) {
            if ($cab == 1) {
                echo '<tr>';
                foreach ($data as $key=>$val) {
                    echo "<td align='center' style='width:auto; color: #fff; background-color: #000'>"
                        . "<b><font size='2'>"
                        . strtoupper(FormatHelper::swapString($key))
                        ."</font></b>"
                        ."</td>";
                }
                echo '</tr>';
                $cab = 2;
            }
            echo '<tr>';
            foreach ($data as $val) {
                echo "<td style='width:auto;'>".FormatHelper::swapString($val)."</td>";
            }
            echo '</tr>';
        }
        echo '</table>';
	}

    public static function exportArrayToCsv($reporte = [], $fileName = "")
    {
        $fecha = date("d/m/Y");
        $hora = date("h:i:s");
        $hh = substr($hora, 0, 2);
        $mm = substr($hora, 3, 2);
        $ss = substr($hora, 6, 2);
        $hora = $hh."_".$mm."_".$ss;
        $filename = $fileName.'_'.$fecha."-".$hora.".csv";

        header("Expires: 0");
        header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
        header("Content-Type: application/force-download");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename={$filename}");
        header("Content-Transfer-Encoding: binary");

        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys(reset($reporte)));
        foreach ($reporte as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }
    public static function exportSpoutExcel($reporte = [], $fileName, $columnsArray = [])
    {
        /*$writer = WriterEntityFactory::createXLSXWriter();
        $writer->openToBrowser($fileName); // stream data directly to the browser
        $style = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(12)
            ->setShouldWrapText()
            //->setCellAlignment(CellAlignment::CENTER)
            ->build();

        $row = WriterEntityFactory::createRowFromArray(array_keys($columnsArray), $style);
        $writer->addRow($row);
        foreach ($reporte as $key => $value) {
            $rowData = WriterEntityFactory::createRowFromArray($value);
            $writer->addRow($rowData);
        }
        $writer->close();*/
    }

    public static function exportAndSaveArrayToCsv($reporte, $filename)
    {
        ob_start();
        $df = fopen($filename, 'w');

        fputcsv($df, array_keys(reset($reporte)));
        foreach ($reporte as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        ob_get_clean();
    }

    public static function createFolderRecursive($pathPrincipal = "", $arrayFolders = [])
    {
        $pathResult = $pathPrincipal;
        foreach ($arrayFolders as $key => $value) {
            $pathResult.=$value."/";
            if (!File::exists($pathResult)) {
                File::makeDirectory($pathResult, 0777, true, true);
            }
        }
        return $pathResult;
    }
}