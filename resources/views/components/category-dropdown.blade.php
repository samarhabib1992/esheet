@if(isset($categories) && $categories->isNotEmpty())
    <select name="category_id" id="category_id" class="form-control">
        <option value="">-- Select Category --</option>
        @foreach($categories as $category)
            <option value="{{ $category->id }}" {{ $selectedCategory == $category->id ? 'selected' : '' }}>
                {{ $category->name }}
            </option>
        @endforeach
    </select>
@else
    <p class="text-danger">Add Categories First to continue</p>
@endif
