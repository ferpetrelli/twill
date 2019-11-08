@php
    $note = $note ?? false;
    $inline = $inline ?? false;
    $default = $default ?? false;
    $inModal = $fieldsInModal ?? false;
    $disabled = $disabled ?? false;
    $translated = $translated ?? false;
@endphp

@if($translated)
    <a17-locale
        type="a17-singlecheckbox"
        :attributes="{
            label: '{{ $label }}',
            @include('twill::partials.form.utils._field_name', ['asAttributes' => true])
            @if ($note) note: '{{ $note }}', @endif
            {{-- initialValue: {{ $default ? 'true' : 'false' }}, --}}
            {{-- hasDefaultStore: true, --}}
            @if ($disabled) disabled: true, @endif
            inStore: 'value'
        }"
    ></a17-locale>
@else
    <a17-singlecheckbox
        @include('twill::partials.form.utils._field_name')
        label="{{ $label ?? '' }}"
        :initial-value="{{ $default ? 'true' : 'false' }}"
        @if ($note) note='{{ $note }}' @endif
        @if ($disabled) disabled @endif
        :has-default-store="true"
        in-store="currentValue"
    ></a17-singlecheckbox>
@endif

@unless($renderForBlocks || $renderForModal || (!isset($item->$name) && null == $formFieldsValue = getFormFieldsValue($form_fields, $name)))
@push('vuexStore')

    @if($translated)
        window.STORE.form.fields.push({
            name: '{{ $name }}',
            value: {
                @foreach(getLocales() as $locale)
                    '{{ $locale }}': @if($form_fields['translations'][$name][$locale]) true @else false @endif,
                @endforeach
            }
        })
    @else
        window.STORE.form.fields.push({
            name: '{{ $name }}',
            value: @if(isset($item) && $item->$name || ($formFieldsValue ?? false)) true @else false @endif
        })
    @endif

@endpush
@endunless
