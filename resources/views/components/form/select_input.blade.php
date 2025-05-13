<div class="inputArea">
    <label for="{{$name}}">
        {{$label ?? ''}}
    </label>
    <select id="{{$name}}" name="{{$name}}" {{empty($required) ? '' : 'required'}}>
        <option selected disabled value=""> Selecione uma opção </option>
        {{$slot}}
    </select>
</div>
