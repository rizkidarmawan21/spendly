<?php

namespace App\View\Components;

use Illuminate\View\Component;

class Tooltip extends Component
{
    public string $id;
    public string $position;
    public string $title;
    public string $content;

    public function __construct(
        string $id = null,
        string $position = 'top',
        string $title = '',
        string $content = ''
    ) {
        $this->id = $id ?? 'tooltip-' . uniqid();
        $this->position = $this->getTooltipPosition($position);
        $this->title = $title;
        $this->content = $content;
    }

    private function getTooltipPosition(string $position): string
    {
        return match ($position) {
            'top' => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
            'bottom' => 'top-full mt-2 left-1/2 -translate-x-1/2',
            'left' => 'top-1/2 right-full -translate-y-1/2 mr-2',
            'right' => 'top-1/2 left-full -translate-y-1/2 ml-2',
            default => 'bottom-full mb-2 left-1/2 -translate-x-1/2',
        };
    }

    public function render()
    {
        return view('components.tooltip');
    }
}
