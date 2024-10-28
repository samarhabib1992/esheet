<?php

namespace App\View\Components;

use App\Models\BlogCategory;
use Illuminate\View\Component;

class BlogCategoryDropdown extends Component
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
        $this->categories = BlogCategory::all();
        $this->selectedCategory = $selectedCategory;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.blog-category-dropdown');
    }
}
