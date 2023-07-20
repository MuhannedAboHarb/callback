@props([
    'name' => 'success' , 'class' => 'success'
])

@if (Session::has($name))
        <div class="alert alert-{{ $class }} alert-dismissible fade show">
            {{ Session::get($name) }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
@endif

@push('script')
    <script>
        window.setInterval(function() {
            $('.alert').alert('close')
        }, 2000);
    </script>
@endpush()
