<?php

class Csv {
    private $filePath;
    private $separator;
    private $data;

    public function __construct($filePath,  $separator = ",") {
        $this->filePath = $filePath;
        $this->separator=  $separator;
        $this->data = [];
    }

    public function read() {
        $csv = fopen($this->filePath, "r");
        if ($csv) {
            fgetcsv($csv, 1000, $this->separator);
            while (!feof($csv)) {
                $row = fgetcsv($csv, 1000, $this->separator);
                if (!empty($row)) {
                    $this->data[]=[
                        'Nom'=>$row[1],
                        'Prenom'=>$row[2],
                        'groupe'=>$row[3],
                        'VilleP'=>$row[4],
                        'CPP'=>$row[5],
                        'VilleS'=>$row[7],
                        'CPS'=>$row[8],
                        ] ;
                }
            }
            fclose($csv);
        }
    }

    public function getData() :?array{
         return $this->data;
    }
}
