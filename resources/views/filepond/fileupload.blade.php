@push('css_link')
    <link rel="stylesheet" href="{{ asset('file_pond/css/filepond.css') }}">
    <link rel="stylesheet" href="{{ asset('file_pond/css/filepond-plugin-image-preview.css') }}">
@endpush
@push('js')
    <script>
        function file_upload(selectors, name, creatorType) {
            $.each(selectors.reverse(), function(index, selector) {
                FilePond.registerPlugin(FilePondPluginImagePreview);
                FilePond.registerPlugin(FilePondPluginFileValidateSize);
                FilePond.registerPlugin(FilePondPluginFileValidateType);

                var actualName = $(selector).attr("data-actualName");

                const inputElement = document.querySelector(selector);
                const pond = FilePond.create(inputElement);
                pond.setOptions({
                    server: {
                        url: "/file-upload",
                        process: {
                            url: "/uploads",
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            onload: (response_data) => {
                                var f_selector = $('input[name="' + name + '"]');
                                $(f_selector).attr("name", actualName);
                                return response_data;
                            },
                            onerror: (response_data) => {
                                console.log(response_data);
                            },
                            ondata: (formData) => {
                                formData.append("name", name);
                                formData.append("creatorType", creatorType);
                                return formData;
                            },
                        },
                        revert: {
                            url: "/delete-temp-file",
                            method: "DELETE",
                            headers: {
                                "X-CSRF-TOKEN": "{{ csrf_token() }}",
                            },
                            onerror: (response_data) => {
                                console.log(response_data);
                            },
                        },
                        fetch: null,
                    },
                });
            });
        }
        // function fp_modal_close(selectors) {
        //     // Iterate through each selector
        //     $.each(selectors, function(index, selector) {
        //         let inputElement = document.querySelector(selector);
        //         let pond = FilePond.create(inputElement);
        //         pondFiles = pond.getFiles();
        //         pondFiles.forEach(fileItem => {
        //             let indexOfLessThan = fileItem.source.indexOf('<');
        //             if (indexOfLessThan !== -1) {
        //                 let filed_id = fileItem.source.substring(0, indexOfLessThan);
        //                 $.ajax({
        //                     url: "{{ route('file.reset') }}", // Replace with your endpoint URL
        //                     method: 'POST',
        //                     headers: {
        //                         "X-CSRF-TOKEN": "{{ csrf_token() }}",
        //                     },
        //                     data: {
        //                         filed_id: filed_id
        //                     },
        //                     success: function(response) {
        //                         console.log('Success:', response);
        //                     },
        //                     error: function(xhr, status, error) {
        //                         console.error('Error:', error);
        //                     }
        //                 });
        //             }
        //         });

        //     });
        // }
    </script>
@endpush
@push('js_link')
    <script src="{{ asset('file_pond/js/filepond-plugin-image-preview.js') }}"></script>
    <script src="{{ asset('file_pond/css/filepond-plugin-file-validate-type.js') }}"></script>
    <script src="{{ asset('file_pond/css/filepond-plugin-image-validate-size.js') }}"></script>
    <script src="{{ asset('file_pond/js/filepond.js') }}"></script>
@endpush
