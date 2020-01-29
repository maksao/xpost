{{--

    v.1.0

--}}
<div class="custom-file">
    {{--<input type="file" class="custom-file-input" id="customFile">--}}
    @include('components.forms.elements.input', array_merge(get_defined_vars()['__data'], [
        'type'=>'file',
        'class'=>'custom-file-input',
        'id'=> $id ?? 'custom-file-'.$name
    ]))
    <label class="custom-file-label" for="customFile">{{ $placeholder ?? '' }}</label>
</div>
@push('scripts')
    <script>
        $('#{{ $id ?? 'custom-file-'.$name }}').on('change',function(){
            //get the file name
            let fileName = $(this).val().replace(/C:\\fakepath\\/i, '');
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })
    </script>
@endpush
