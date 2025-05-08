<script src="https://cdn.tiny.cloud/1/135raohagcr975nitlfexoja26qqwc3er6gi4tg7x56x2y0u/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
  const useDarkMode = window.matchMedia('(prefers-color-scheme: dark)').matches;
  tinymce.init({
    selector: 'textarea#content', // Replace this CSS selector to match the placeholder element for TinyMCE
    plugins: 'code table lists wordcount',
    toolbar: 'undo redo | blocks | bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | code | table',
    skin: useDarkMode ? 'oxide-dark' : 'oxide',
    content_css: useDarkMode ? 'dark' : 'default',
    setup: function (editor) {
        editor.on('change', function () {
            tinymce.triggerSave();
        });
    }
  });
</script>