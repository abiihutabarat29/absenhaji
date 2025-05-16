@props(['type', 'name', 'label'])
<div class="col mb-3">
    <div class="form-password-toggle">
        <label class="form-label">{{ $label }}<span class="text-danger optionSpan">*</span></label>
        <small class="text-muted optionSmall">(opsional)</small>
        <div class="input-group input-group-merge">
            <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}" placeholder="············"
                aria-describedby="basic-default-password" {{ $attributes->merge(['class' => 'form-control']) }}>
            <span class="input-group-text cursor-pointer" id="basic-default-password"><i class="bx bx-show"></i></span>

        </div>
    </div>
</div>
