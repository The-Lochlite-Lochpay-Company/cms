<script setup>
 import DOMPurify from 'dompurify';
 import tinymce from 'tinymce';
 import 'tinymce/icons/default';
 import 'tinymce/models/dom/model';
 import 'tinymce/themes/silver';
 import 'tinymce/skins/ui/oxide/skin.css';
 import 'tinymce/plugins/code';
 import 'tinymce/plugins/media';
 import 'tinymce/plugins/image';
 import 'tinymce/plugins/advlist';
 import 'tinymce/plugins/anchor';
 import 'tinymce/plugins/codesample';
 import 'tinymce/plugins/emoticons';
 import 'tinymce/plugins/emoticons/js/emojis';
 import 'tinymce/plugins/link';
 import 'tinymce/plugins/lists';
 import 'tinymce/plugins/table';
 import 'tinymce/plugins/insertdatetime';
 import 'tinymce-i18n/langs5/pt_BR';
 import('tinymce/skins/ui/oxide/content.css');
 import('tinymce/skins/content/default/content.css');

defineProps({
    id: '',
    class: '',
});
</script>
<template>
    <textarea
        ref="textarea"
        class="form-control border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
        :class="class"
        id="mylochi-tinyeditor"
        :uuid="uuid"
    ></textarea>
</template>
<script>
const uuid = Math.random().toString(36).replace(/[^a-z0-9]+/gim, '');
$('body').ready(function(){
     tinymce.init({
       selector: 'textarea[uuid="' + uuid + '"]', // Replace this CSS selector to match the placeholder element for TinyMCE
       plugins: 'anchor media code advlist emoticons link lists image table codesample insertdatetime',
       toolbar: 'undo redo | formatselect| bold italic | alignleft aligncenter alignright | indent outdent | bullist numlist | image | media | code | table | anchor | codesample | insertdatetime',
       language: 'pt_BR',
       skin: false,
	   content_css: "/css/app.css",
       image_title: true, 
       automatic_uploads: true,
       file_picker_types: 'image', 
       file_picker_callback: (cb, value, meta) => {
           var input = document.createElement('input');
           input.setAttribute('type', 'file');
           input.setAttribute('accept', 'image/*');
           input.onchange = () => {
             var file = this.files[0];
             var reader = new FileReader();
             reader.onload = () => {
             var id = 'blobid' + (new Date()).getTime();
             var blobCache =  tinymce.activeEditor.editorUpload.blobCache;
             var base64 = reader.result.split(',')[1];
             var blobInfo = blobCache.create(id, file, base64);
             blobCache.add(blobInfo);
             cb(blobInfo.blobUri(), { title: file.name });
           };
           reader.readAsDataURL(file);
       }
       },
       setup: function (event) {
        event.on('change', function () {
            tinymce.triggerSave();
        });
        event.on('init', function(args) {
         if($('textarea[uuid="' + uuid + '"]').data('type') == 'edit'){
          var contentpost = $('textarea[uuid="' + uuid + '"]').data('body');
          if(contentpost.length > 0){
          var body = Base64.atob(contentpost);
          event.setContent(body);
	      }
	     }
	   })
	   }
     });
     });

</script>