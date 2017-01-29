<div class="form-group">
    <label for="lead--{{ $type }}--{{ $field->id }}">
        {{ $field->label }}
    </label>
    <input type="hidden"
           name="{{ $type }}[{{ $subType }}][{{$key}}][name]"
           value="{{ $field->name }}"/>
    @if($field->type == 'text')
        <input id="lead--{{ $type }}--{{ $field->id }}" class="form-control"
               type="text" name="{{ $type }}[{{ $subType }}][{{ $key }}][value]"/>
    @endif
    @if($field->type == 'numeric')
        <input id="lead--{{ $type }}--{{ $field->id }}" class="form-control"
               type="number" name="{{ $type }}[{{ $subType }}][{{ $key }}][value]"/>
    @endif
    @if($field->type == 'boolean')
        <input id="lead--{{ $type }}--{{ $field->id }}" class="form-control"
               type="checkbox" name="{{ $type }}[{{ $subType }}][{{ $key }}][value]"/>
    @endif
    @if($field->type == 'single_choice')
        <select id="lead--{{ $type }}--{{ $field->id }}" class="form-control"
                name="{{ $type }}[{{ $subType }}][{{ $key }}][value]">
            @foreach($field->options as $option)
                <option value="{{ $option->id }}">
                    {{ $option->value }}
                </option>
            @endforeach
        </select>
    @endif
</div>