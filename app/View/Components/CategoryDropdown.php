<?php

namespace App\View\Components;

use App\Models\Category;
use Illuminate\View\Component;

class CategoryDropdown extends Component
{
    public $categories;
    public $selectedCategory;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function __construct($selectedCategory = null)
    {
        // Fetch categories to be passed to the component view
        $this->categories = Category::all();
        $this->selectedCategory = $selectedCategory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.category-dropdown');
    }
}
