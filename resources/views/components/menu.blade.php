@props(['link', 'icon', 'label', 'active'])
<li class="menu-item {{ request()->segment(1) == $active ? 'active' : '' }}">
    <a href="{{ $link }}" class="menu-link">
        <i class="menu-icon {{ $icon }}"></i>
        <div data-i18n="{{ $label }}">{{ $label }}</div>
    </a>
</li>
