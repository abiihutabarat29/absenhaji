@props(['name', 'label', 'opsi'])
<div class="col mb-3">
    <label class="form-label">{{ $label }}</label>
    @if ($opsi == 'false')
        <small class="text-muted">(opsional)</small>
    @else
        <span class="text-danger">*</span>
    @endif
    <select id="{{ $name }}" name="{{ $name }}" style="width: 100%;"
        {{ $attributes->merge(['class' => 'form-select']) }}>
        <option selected disabled>::Pilih {{ $label }}::</option>
        {{ $slot }}
    </select>
</div>
