<?php

namespace App\Service;

use App\Form\Model\EventSearch;

class EventApiService
{
    private readonly string $BASE_URL;

    /**
     * @param string $BASE_URL
     */
    public function __construct()
    {
        $this->BASE_URL = "https://public.opendatasoft.com/api/records/1.0/search/?dataset=evenements-publics-openagenda";
    }


    public function search(EventSearch $eventSearch = null)
    {
        $url = $this->BASE_URL;

        if ($eventSearch) {

            if ($eventSearch->getCity()) {
                $url .= "&refine.location_city=" . $eventSearch->getCity();
            }
            if($eventSearch->getStartDate()) {
                $url .= "&refine.firstdate_begin=" . $eventSearch->getStartDate()->format("Y-m-d");
            }
        }


        $content = file_get_contents($url);

        return json_decode($content, true);

    }
}