@props(['type', 'name', 'label', 'opsi'])
<div class="col mb-3">
    <label class="form-label">{{ $label }}</label>
    @if ($opsi == 'false')
        <small class="text-muted">(opsional)</small>
    @else
        <span class="text-danger">*</span>
    @endif
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
        {{ $attributes->merge(['class' => 'form-control']) }} />
</div>
