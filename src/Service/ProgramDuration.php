<?php

namespace App\Service;

use App\Entity\Programm;

class ProgramDuration
{
    public function calculate(Programm $programm): string
    {
        $programDuration = 0;
        for ($i = 0; $i < count($programm->getSeasons()); $i++) {
            $seasons = $programm->getSeasons();
            $episodes = $seasons[$i]->getEpisodes();
            for ($j = 0; $j < count($episodes); $j++) {
                $programDuration += $episodes[$j]->getDuration();
            }
        }
        return $programDuration;
}
}