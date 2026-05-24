@csrf
<div class="row">
    <div class="col-md-8">
        <div class="form-group mb-3">
            <x-form.input name="name" :value="$product->name" lable="Product Name" />
        </div>

        <div class="form-group mb-3">
            <label for="category_id">Category</label>
            <select name="category_id" id="category_id" class="form-control @error('category_id') is-invalid   @enderror">
                <option value="">Select One</option>
                @foreach (\App\Models\Category::all() as $category)
                    <option value="{{ $category->id }}" @if ($category->id == old('category_id', $product->category_id)) selected @endif>
                        {{ $category->name }}</option>
                @endforeach
            </select>
            @error('category_id')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror
        </div>

        {{-- textarea.blade --}}

        <div class="form-group mb-3">
            <x-form.textarea lable="Description" name="description" :value="$product->description" />
        </div>

        {{-- here down --}}
        <div class="form-row">
            <div class="col-md-6">
                <div class="form-group mb-3">
                    <x-form.input type="number" name="price" value="{{ $product->price }}" lable="Price"
                        placeholder="price" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group mb-3">
                    <x-form.input type="number" name="compare_price" value="{{ $product->compare_price }}"
                        lable="Compare Price" />
                </div>
            </div>


            <div class="col-md-6">
                <div class="form-group mb-3">
                    <x-form.input type="number" name="cost" value="{{ $product->cost }}" lable="Cost" />
                </div>
            </div>


            <div class="form-row">


                <div class="form-group mb-3">
                    <label for="sku">SKU</label>
                    <input type="text" name="sku" id="sku" value="{{ old('sku', $product->sku) }}"
                        class="form-control @error('sku') is-invalid @enderror">
                    @error('sku')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>


                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="barcode">BarCode</label>
                        <input type="text" name="barcode" id="barcode"
                            value="{{ old('barcode', $product->barcode) }}"
                            class="form-control @error('barcode') is-invalid   @enderror">
                        @error('barcode')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
            </div>


            <div class="form-row">
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="quantity">Quantity</label>
                        <input type="number" name="quantity" id="quantity"
                            value="{{ old('quantity', $product->quantity) }}"
                            class="form-control @error('quantity') is-invalid   @enderror">
                        @error('quantity')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="availabillty">Availabillty</label>
                        <select name="availabillty" id="availabillty"
                            class="form-control @error('availabillty') is-invalid   @enderror">
                            <option value="">Select One</option>
                            @foreach ($availabillties as $key => $availabillty)
                                <option value="{{ $key }}" @if ($key == old('availabillty', $product->availabillty)) selected @endif>
                                    {{ $availabillty }}</option>
                            @endforeach
                        </select>
                        @error('availabillty')
                            <p class="invalid-feedback">{{ $message }}</p>
                        @enderror

                    </div>
                </div>
            </div>
        </div>

        <div class="form-group mb-6">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid   @enderror">
                <option value="">Select One</option>
                @foreach ($status_options as $key => $status)
                    <option value="{{ $key }}" @if ($key == old('status', $product->status)) selected @endif>
                        {{ $status }}</option>
                @endforeach
            </select>
            @error('status')
                <p class="invalid-feedback">{{ $message }}</p>
            @enderror

        </div>

        {{-- ===== قسم الصور ===== --}}
        <div class="card mb-4">
            <div class="card-header"><strong>Product Images</strong></div>
            <div class="card-body">

                {{-- الصور الحالية المرفوعة عبر Medialibrary --}}
                @if($product->exists && $product->getMedia('product-images')->count())
                    <p class="text-muted mb-2">Current Images — check to delete:</p>
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($product->getMedia('product-images') as $media)
                            <div class="position-relative text-center me-3 mb-3" style="width:110px;">
                                <img src="{{ $media->getUrl() }}" alt="" style="width:100px;height:100px;object-fit:cover;border-radius:6px;border:1px solid #ddd;">
                                <div class="mt-1">
                                    <input type="checkbox" name="delete_media[]" value="{{ $media->id }}" id="del_{{ $media->id }}">
                                    <label for="del_{{ $media->id }}" class="text-danger small">Delete</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @elseif($product->image_url !== asset('images/defluat.jpg'))
                    {{-- صورة قديمة من الـ uploads --}}
                    <div class="mb-3">
                        <p class="text-muted small">Current image (legacy):</p>
                        <img src="{{ $product->image_url }}" height="100" style="border-radius:6px;border:1px solid #ddd;">
                    </div>
                @endif

                {{-- رفع صور جديدة --}}
                <div class="form-group">
                    <label for="images"><strong>Upload Images</strong> <span class="text-muted small">(you can select multiple)</span></label>
                    <input type="file" name="images[]" id="images" multiple accept="image/*"
                        class="form-control @error('images.*') is-invalid @enderror"
                        onchange="previewImages(this)">
                    @error('images.*')
                        <p class="invalid-feedback">{{ $message }}</p>
                    @enderror
                </div>

                {{-- معاينة الصور قبل الرفع --}}
                <div id="images-preview" class="d-flex flex-wrap mt-2"></div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="form-group mb-3">
                <div class="form-group mb-6" >
                    <label for="tags">Tags</label>
                    <x-form.textarea name="tags" />
                </div>
            </div>
        </div>

        <div class="form-group mb-3">
            <button type="submit" class="btn btn-primary">{{ $button }}</button>
            <a href="{{ route('dashboard.products.index') }}" class="btn btn-danger ml-2">{{ $button2 }}</a>
        </div>

    </div>
</div>

<script>
function previewImages(input) {
    const preview = document.getElementById('images-preview');
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
