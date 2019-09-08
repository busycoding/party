@section('style')
    <link rel="stylesheet" href="/admin/plugins/tag-editor/jquery.tag-editor.css">
@endsection

@section('script')
    <script src="/admin/plugins/tag-editor/jquery.caret.min.js"></script>
    <script src="/admin/plugins/tag-editor/jquery.tag-editor.min.js"></script>
    <script type="text/javascript">
        var options = {};

        @if ($company->exists)
            //options = {
            //    initialTags: {!! $company->tags_list !!}
            //}
            options = {
                initialTags: {!! json_encode($company->tags->pluck('name')) !!},
            };
        @endif

        //$('input[name=tags]').tagEditor();
        $('input[name=tags]').tagEditor(options);
    </script>

    <script type="text/javascript">
        $('ul.pagination').addClass('no-margin pagination-sm');


        $('#title').on('blur', function() {
            var theTitle = this.value.toLowerCase().trim(),
                slugInput = $('#slug'),
                theSlug = theTitle.replace(/&/g, '-and-')
                                  .replace(/[^a-z0-9-]+/g, '-')
                                  .replace(/\-\-+/g, '-')
                                  .replace(/^-+|-+$/g, '');

            slugInput.val(theSlug);
        });

    </script>
@endsection