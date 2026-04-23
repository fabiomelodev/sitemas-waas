<?php

namespace App\View\Components\Layout;

use App\Models\Faq;
use App\Settings\GeneralSettings;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\Component;

class Footer extends Component
{
    public Collection $faqs;

    /**
     * Create a new component instance.
     */
    public function __construct(public GeneralSettings $settings)
    {
        $this->faqs = Faq::query()->active()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.layout.footer');
    }
}
