@props(['icon', 'label', 'active', 'open'])
<li class="menu-item {{ $active }} {{ $open }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon {{ $icon }}"></i>
        <div data-i18n="{{ $label }}">{{ $label }}</div>
    </a>
    <ul class="menu-sub">
        {{ $slot }}
    </ul>
</li>
