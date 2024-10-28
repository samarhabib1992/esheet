<?php
namespace App\View\Components;

use Illuminate\View\Component;
use App\Models\ProductType;

class ProductTypeComponent extends Component
{
    public $productTypes;
    public $selectedValue;

    /**
     * Create a new component instance.
     *
     * @param int|null $selectedProductTypeId
     * @return void
     */
    public function __construct($selectedValue = null)
    {
        // Fetch all active product types
        $this->productTypes = ProductType::where('status', 1)->get();
        $this->selectedValue = $selectedValue;
    }

    /**
     * Get the view / contents that represent the component.
     *
     * @return \Illuminate\Contracts\View\View|\Closure|string
     */
    public function render()
    {
        return view('components.product-type-component');
    }
}
