<?php
/**
 * Created by PhpStorm.
 * User: illia
 * Date: 03.07.18
 * Time: 18:47
 */

class CsvExporter
{
    public static function exportReport($name, $data)
    {
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . date("Ymd_His_") . $name . '.csv"');

        echo self::toCsv($data);
        exit();
    }
    
    protected static function toCsv($data)
    {
        ob_start();
        $df = fopen("php://output", 'w');
        fputcsv($df, array_keys($data[0]));
        foreach ($data as $row) {
            fputcsv($df, $row);
        }
        fclose($df);
        return ob_get_clean();
    }
}