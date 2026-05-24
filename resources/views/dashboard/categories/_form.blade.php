@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <label for="name">Category Name</label>
            <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}"
                class="form-control @error('name') is-invalid   @enderror">
            @error('name')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group mb-3">
            <label for="parent_id">Category Parent</label>
            <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid   @enderror">
                <option value="">No Parent</option>
                @foreach ($parents as $parent)
                    <option value="{{ $parent->id }}" @if ($parent->id == old('parent_id', $category->parent_id)) selected @endif>
                        {{ $parent->name }}</option>
                @endforeach
            </select>
            @error('parent_id')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>


        <div class="form-group mb-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
            @error('description')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>


        {{-- ===== قسم الصور ===== --}}
        <div class="card mb-4">
            <div class="card-header"><strong>Category Images</strong></div>
            <div class="card-body">

                {{-- الصور الحالية --}}
                @if($category->exists && $category->getMedia('category-images')->count())
                    <p class="text-muted mb-2">Current Images — check to delete:</p>
                    <div class="d-flex flex-wrap mb-3">
                        @foreach($category->getMedia('category-images') as $media)
                            <div class="text-center me-3 mb-3" style="width:110px;">
                                <img src="{{ $media->getUrl() }}" alt="" style="width:100px;height:100px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                                <div class="mt-1">
                                    <input type="checkbox" name="delete_media[]" value="{{ $media->id }}" id="del_{{ $media->id }}">
                                    <label for="del_{{ $media->id }}" class="text-danger small">Delete</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($category->exists && $category->image)
                    <div class="mb-3">
                        <p class="text-muted small">Current image (legacy):</p>
                        <img src="{{ $category->image_url }}" height="100" style="border-radius:6px;border:1px solid #ddd;">
                    </div>
                @endif

                {{-- رفع صور جديدة --}}
                <div class="form-group">
                    <label for="images"><strong>Upload Images</strong> <span class="text-muted small">(you can select multiple)</span></label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="form-control @error('images.*') is-invalid @enderror"
                        onchange="previewCatImages(this)">
                    @error('images.*')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                <div id="cat-images-preview" class="d-flex flex-wrap mt-2"></div>
            </div>
        </div>


        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">{{ $button }}</button>
            <a href="{{ route('dashboard.categories.index') }}" class="btn btn-danger ml-2">{{ $button2 }}</a>
        </div>

    </div>
</div>

<script>
function previewCatImages(input) {
    const preview = document.getElementById('cat-images-preview');
    preview.innerHTML = '';
    if (input.files) {
        Array.from(input.files).forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                const div = document.createElement('div');
                div.style.cssText = 'margin:4px;';
                div.innerHTML = `<img src="${e.target.result}" style="width:80px;height:80px;object-fit:cover;border-radius:6px;border:1px solid #ccc;">`;
                preview.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}
</script>
