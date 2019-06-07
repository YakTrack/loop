<?php

namespace Tests\Unit;

use YakTrack\Loop\LoopExtractor;
use YakTrack\Loop\LoopsCollection;
use YakTrack\Loop\Types\Question;
use YakTrack\Loop\Types\Request;
use Tests\TestCase;

class LoopExtractorTest extends TestCase
{
    /** @test */
    public function extract_method_returns_expected_output_for_input()
    {
        $this->loopExtractor = new LoopExtractor;

        $this->detectsQuestions();
        $this->detectsRequests();
    }

    protected function detectsQuestions()
    {
        $loops = $this->loopExtractor->extract('Can you tell me how long this will take?');

        $this->assertTrue($loops instanceof LoopsCollection);
        $this->assertTrue($loops->first() instanceof Question);
    }

    protected function detectsRequests()
    {
        $text = 'Allow users to add a text input.';

        $loops = $this->loopExtractor->extract($text);

        $this->assertTrue($loops instanceof LoopsCollection);

        $this->assertTrue($loops->contains(function ($loop) {
            return $loop instanceof Request &&
                $loop->content = 'Allow users to have a friendly editor for anywhere they can input HTML for the event app.';
        }));
    }
}
