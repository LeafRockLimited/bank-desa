<?php

namespace Tests\Feature;

use App\LpeTrait;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LpeTest extends TestCase
{
    use LpeTrait;
    /**
     * A basic feature test example.
     */
    public function test_create_lpe(): void
    {
        $this->createLpe();

    }
}
