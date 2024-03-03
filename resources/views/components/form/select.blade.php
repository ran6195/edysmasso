@props(['name', 'options' => [], 'option_value' => 'id', 'option_caption'])


<div>
    <select name="{{ $name }}" id="{{ $name }}"
        class="w-full block appearance-none bg-white border-2 border-white hover:border-neutral-500 hover:border-2 px-4 py-2 pr-8 rounded shadow leading-tight focus:border-neutral-500 focus:ring-0 transition-all ease-in-out duration-500">
        @foreach ($options as $option)
            <option value="{{ $option->$option_value }}">{{ $option->$option_caption }}</option>
        @endforeach
    </select>
</div>
