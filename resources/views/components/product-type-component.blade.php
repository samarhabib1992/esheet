@props(['selectedValue' => null,'isShowEmptyMessage' => false])
@if($productTypes)
    <select id='product_type_id' name='product_type_id' class='form-control product-type'>
        <option value="">Select Product Type</option>
        @foreach($productTypes as $type)
            <option value='{{ $type->id ?? '' }}' {{ $selectedValue == $type->id ? 'selected' : '' }}>{{ $type->name ?? '' }}</option>
        @endforeach
    </select>
    @else
        @if($isShowEmptyMessage)
            <div class="text-danger">No Product Type Found!</div>
        @endif
@endif