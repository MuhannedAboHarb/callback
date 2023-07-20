@props([
    'id' => null,
    'lable' => null,
    'name',
    'type' => 'text',
    'value' => '',
])

@php
    $id = $id ?? $name;
@endphp


@if ($lable)
    <label for="{{ $id }}">{{ $lable }}</label>
@endif
<input type="{{ $type }}" name="{{ $name }}" id="{{ $id }}" value="{{ old($name, $value) }}"
    class="form-control @error($name) is-invalid   @enderror">
@error($name)
    <p class="invalid-feedback">{{ $message }}</p>
@enderror
