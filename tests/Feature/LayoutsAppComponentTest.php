<?php

namespace Tests\Feature;

use Illuminate\Support\Facades\Blade;
use Tests\TestCase;

class LayoutsAppComponentTest extends TestCase
{
    public function test_layouts_app_component_renders_with_slot_content(): void
    {
        $html = Blade::render('<x-layouts.app>Layout component content</x-layouts.app>');

        $this->assertStringContainsString('<!DOCTYPE html>', $html);
        $this->assertStringContainsString('Layout component content', $html);
    }
}
