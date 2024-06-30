function isTextareaExists() {
    return document.querySelector("textarea") !== null;
}

const initializedEditors = new Map();

$(document).ready(function () {
    initializeEditor();
});

function initializeEditor() {
    if (isTextareaExists()) {
        // Select all textareas and filter out the ones with "ck-off" class
        $("textarea:not(.ck-off):not(.select2 textarea)").each(function () {
            var textarea = this;
            if (!initializedEditors.has(textarea)) {
                ClassicEditor.create(this, {
                    licenseKey: "",
                    toolbar: {
                        items: [
                            "heading",
                            "|",
                            "fontFamily",
                            "fontSize",
                            "fontColor",
                            "fontBackgroundColor",
                            "bold",
                            "italic",
                            "highlight",
                            "underline",
                            "|",
                            "link",
                            "bulletedList",
                            "numberedList",
                            "|",
                            "superscript",
                            "subscript",
                            "|",
                            "outdent",
                            "indent",
                            "alignment",
                            "|",
                            "imageUpload",
                            "blockQuote",
                            "insertTable",
                            "mediaEmbed",
                            "horizontalLine",
                            "htmlEmbed",
                            "findAndReplace",
                            "|",
                            "undo",
                            "redo",
                        ],
                        shouldNotGroupWhenFull: false,
                    },
                    plugins: [
                        "Alignment",
                        "Autoformat",
                        "AutoLink",
                        "Base64UploadAdapter",
                        "BlockQuote",
                        "Bold",
                        "Essentials",
                        "FindAndReplace",
                        "FontBackgroundColor",
                        "FontColor",
                        "FontFamily",
                        "FontSize",
                        "GeneralHtmlSupport",
                        "Heading",
                        "Highlight",
                        "HorizontalLine",
                        "HtmlComment",
                        "HtmlEmbed",
                        "Image",
                        "ImageCaption",
                        "ImageResize",
                        "ImageStyle",
                        "ImageToolbar",
                        "ImageUpload",
                        "Indent",
                        "IndentBlock",
                        "Italic",
                        "Link",
                        "List",
                        "ListProperties",
                        "MediaEmbed",
                        "MediaEmbedToolbar",
                        "Paragraph",
                        "PasteFromOffice",
                        "Subscript",
                        "Superscript",
                        "Table",
                        "TableCaption",
                        "TableCellProperties",
                        "TableColumnResize",
                        "TableProperties",
                        "TableToolbar",
                        "Underline",
                    ],
                    removePlugins: ["Title"],
                })
                    .then((editor) => {
                        window.editor = editor;
                        initializedEditors.set(textarea, editor);
                    })
                    .catch((error) => {
                        console.error("Oops, something went wrong!");
                        console.error(
                            "Please, report the following error on https://github.com/ckeditor/ckeditor5/issues with the build id and the error stack trace:"
                        );
                        console.warn("Build id: ft9qmrg1pzi1-s4l9tbd9o6iv");
                        console.error(error);
                    });
            }
        });
    }
}
