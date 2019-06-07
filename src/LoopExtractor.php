<?php

namespace YakTrack\Loop;

use YakTrack\Loop\Types\Question;
use YakTrack\Loop\Types\Request;

class LoopExtractor
{
    public function extract($input)
    {
        return new LoopsCollection(
            $this->extractSentences($input)
                ->map(function ($sentence) {
                    return $this->convertToLoop($sentence);
                })
        );
    }

    public function extractSentences($input)
    {
        return collect(explode('. ', $input));
    }

    public function convertToLoop($string)
    {
        $loopType = $this->detectLoopType($string);

        return new $loopType($string);
    }

    public function detectLoopType($string)
    {
        if (str_contains($string, '?')) {
            return Question::class;
        }

        return Request::class;
    }
}
