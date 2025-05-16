@props(['type', 'name', 'label', 'opsi'])
<div class="mb-3">
    <label class="form-label">{{ $label }}</label>
    @if ($opsi == 'false')
        <small class="text-muted">(opsional)</small>
    @else
        <span class="text-danger">*</span>
    @endif
    <input name="{{ $name }}" id="{{ $name }}" type="{{ $type }}"
        {{ $attributes->merge(['class' => 'form-control']) }}>
</div>
