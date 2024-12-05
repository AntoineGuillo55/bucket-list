<?php

namespace App\Service;

class Censurator
{
    private array $forbiddenWords = ["MACRON", "MACRONISTE", "DROITE", "NEO-LIBERALISME", "FACHOS", "CHOCOLATINE"];
    public function purify(string $string) {

        $arrayString = explode(' ', $string);

        foreach($arrayString as $key => $value) {

            if(in_array(strtoupper($value), $this->forbiddenWords)) {
                $arrayString[$key] = "";

                for($i=0; $i<strlen($value)-1; $i++){
                    $arrayString[$key].= "*";
                }
            }
        }

        return implode(" ", $arrayString);
    }

    public function addForbiddenWord(string $word){

        $this->forbiddenWords[] = strtoupper($word);
    }
}