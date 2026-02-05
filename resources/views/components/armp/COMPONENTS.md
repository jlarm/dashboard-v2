# Armp Component Library

Custom Blade components located in `resources/views/components/armp/`.

---

## Button

**Tag:** `<x-armp.button>`
**File:** `button.blade.php`

A flexible button component supporting multiple visual variants, sizes, link rendering, loading states, and tooltips.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `outline` | Visual style: `outline`, `primary`, `filled`, `danger`, `ghost`, `subtle` |
| `size` | string | `base` | Size: `base`, `sm`, `xs` |
| `square` | bool | `false` | Render as a square (equal width/height) |
| `align` | string | `center` | Content alignment: `start`, `center`, `end` |
| `as` | string | `null` | Override the HTML tag (`button`, `a`, `div`, etc.) |
| `href` | string | `null` | Renders as `<a>` tag with this URL |
| `type` | string | `button` | Button type attribute (`button`, `submit`, `reset`) |
| `loading` | bool | `false` | Show a loading spinner during Livewire actions |
| `tooltip` | string | `null` | Tooltip text on hover |
| `tooltipPosition` | string | `top` | Tooltip placement: `top`, `bottom`, `left`, `right` |

### Slots

| Slot | Description |
|------|-------------|
| default | Button label text |
| `icon` | Leading icon (before text) |
| `iconTrailing` | Trailing icon (after text) |

### Usage

```blade
{{-- Basic --}}
<x-armp.button>Click Me</x-armp.button>

{{-- Primary with loading --}}
<x-armp.button variant="primary" loading wire:click="save">
    Save Changes
</x-armp.button>

{{-- Link button --}}
<x-armp.button variant="ghost" href="/settings">Settings</x-armp.button>

{{-- Icon button with tooltip --}}
<x-armp.button square variant="subtle" tooltip="Delete" tooltipPosition="bottom">
    <x-slot:icon>
        <svg>...</svg>
    </x-slot:icon>
</x-armp.button>

{{-- Danger with trailing icon --}}
<x-armp.button variant="danger" size="sm">
    Remove
    <x-slot:iconTrailing>
        <svg>...</svg>
    </x-slot:iconTrailing>
</x-armp.button>
```

### Variants

| Variant | Light | Dark |
|---------|-------|------|
| `outline` | White bg, gray border | Dark bg, gray border |
| `primary` | arm-blue-600 bg, white text | arm-blue-500 bg |
| `filled` | Gray-100 bg | Gray-800 bg |
| `danger` | Red-600 bg, white text | Red-500 bg |
| `ghost` | Transparent, hover gray-100 | Transparent, hover gray-900 |
| `subtle` | Gray-600 text, hover gray-100 | Gray-400 text, hover gray-900 |

---

## Select

**Tag:** `<x-armp.select>`
**File:** `select/index.blade.php`

A full-featured select component with three rendering modes: native HTML select, custom listbox dropdown, and searchable combobox. Built with pure HTML and vanilla JavaScript.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `variant` | string | `native` | Rendering mode: `native`, `listbox`, `combobox` |
| `placeholder` | string | `null` | Placeholder text when nothing is selected |
| `value` | mixed | `null` | Pre-selected value |
| `size` | string | `base` | Size: `base`, `sm`, `xs` |
| `disabled` | bool | `false` | Disable the component |
| `invalid` | bool | `false` | Force error/invalid styling |
| `multiple` | bool | `false` | Allow multiple selections (listbox only) |
| `searchable` | bool | `false` | Enable search filtering (listbox only; always on for combobox) |
| `clearable` | bool | `false` | Show an X button to clear the selection |
| `label` | string | `null` | Label text rendered above the select |
| `description` | string | `null` | Helper text rendered below the select |

### Variants

#### Native (`variant="native"`)

Renders a styled `<select>` element with a custom chevron icon. All standard HTML attributes and `wire:model` pass through directly to the `<select>`.

```blade
<x-armp.select wire:model="country" placeholder="Choose country...">
    <x-armp.select.option value="us">United States</x-armp.select.option>
    <x-armp.select.option value="ca">Canada</x-armp.select.option>
    <x-armp.select.option value="uk">United Kingdom</x-armp.select.option>
</x-armp.select>
```

#### Listbox (`variant="listbox"`)

Custom dropdown powered by vanilla JavaScript. Supports search, multiple selection, clearable, and full keyboard navigation.

```blade
{{-- Basic listbox --}}
<x-armp.select variant="listbox" placeholder="Choose industry...">
    <x-armp.select.option value="photography">Photography</x-armp.select.option>
    <x-armp.select.option value="design">Design Services</x-armp.select.option>
    <x-armp.select.option value="web">Web Development</x-armp.select.option>
</x-armp.select>

{{-- Searchable + clearable --}}
<x-armp.select variant="listbox" searchable clearable placeholder="Search...">
    <x-armp.select.option value="1">Option 1</x-armp.select.option>
    <x-armp.select.option value="2">Option 2</x-armp.select.option>
</x-armp.select>

{{-- Multiple selection --}}
<x-armp.select variant="listbox" multiple searchable placeholder="Select tags...">
    <x-armp.select.option value="laravel">Laravel</x-armp.select.option>
    <x-armp.select.option value="vue">Vue.js</x-armp.select.option>
    <x-armp.select.option value="tailwind">Tailwind CSS</x-armp.select.option>
</x-armp.select>
```

#### Combobox (`variant="combobox"`)

An input field that opens a filterable dropdown as you type. Search is always enabled.

```blade
<x-armp.select variant="combobox" clearable placeholder="Type to search...">
    <x-armp.select.option value="photography">Photography</x-armp.select.option>
    <x-armp.select.option value="design">Design Services</x-armp.select.option>
</x-armp.select>
```

### Keyboard Navigation (Listbox & Combobox)

| Key | Action |
|-----|--------|
| `ArrowDown` / `ArrowUp` | Move highlight through options |
| `Enter` | Select the highlighted option |
| `Escape` | Close the dropdown |
| `Tab` | Close the dropdown and move focus |
| `Space` | Open the dropdown (listbox only) |
| Typing | Filter options (when searchable/combobox) |

### Livewire Integration

The component works with `wire:model` on all variants. For `native`, the binding goes directly on the `<select>`. For `listbox` and `combobox`, a hidden `<input>` carries the binding and dispatches `input` and `change` events on selection.

```blade
<x-armp.select variant="listbox" wire:model="selectedIndustry" label="Industry" placeholder="Choose...">
    <x-armp.select.option value="tech">Technology</x-armp.select.option>
    <x-armp.select.option value="finance">Finance</x-armp.select.option>
</x-armp.select>
```

### Error Handling

Errors are detected automatically when `wire:model` is present and the field has validation errors. You can also force the error state with `invalid`.

```blade
<x-armp.select variant="listbox" wire:model="category" invalid label="Category">
    ...
</x-armp.select>
```

---

## Select Option

**Tag:** `<x-armp.select.option>`
**File:** `select/option.blade.php`

An individual option used inside `<x-armp.select>`. Automatically adapts its rendering based on the parent select's variant.

### Props

| Prop | Type | Default | Description |
|------|------|---------|-------------|
| `value` | string | `null` | Option value. Falls back to the slot text content if not provided. |

### Inherited from Parent (`@aware`)

The option component automatically receives `variant`, `multiple`, and `size` from its parent `<x-armp.select>`.

### Rendering Behavior

| Parent Variant | Renders As | Selection Indicator |
|----------------|------------|---------------------|
| `native` | `<option>` element | Browser default |
| `listbox` / `combobox` (single) | `<div>` with data attributes | Checkmark icon |
| `listbox` / `combobox` (multiple) | `<div>` with data attributes | Checkbox indicator |

### Usage

```blade
{{-- Value from prop --}}
<x-armp.select.option value="photography">Photography</x-armp.select.option>

{{-- Value auto-derived from text content --}}
<x-armp.select.option>Photography</x-armp.select.option>

{{-- Dynamic from model --}}
@foreach ($industries as $industry)
    <x-armp.select.option :value="$industry->id">{{ $industry->name }}</x-armp.select.option>
@endforeach
```
