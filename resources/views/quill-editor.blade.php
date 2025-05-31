@include("admin::form._header")

        <style>

            #{{ $id }}_quill_wrapper .ql-editor{
                min-height:{{$minHeight}};
            }
            #{{ $id }}_quill_wrapper .quill-editor{
                max-height:{{$maxHeight}};
            }

        </style>
        <div class="quill-wrapper" id="{{ $id }}_quill_wrapper" onClick="this.classList.add('focus')">
            <div id="{{ $id }}_quill_editor" class="quill-editor"></div>

            <textarea style="display:none;"name="{{$name}}" rows="{{ $rows }}" id="{{ $id }}" placeholder="{{ $placeholder }}" {!! $attributes !!} >
                {{ old($column, $value) }}
            </textarea>
        </div>

@include("admin::form._footer")