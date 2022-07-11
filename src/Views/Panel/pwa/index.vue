<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from '@/Jetstream/DialogModal.vue';
import JetSelect from '@/Jetstream/Select.vue';
import JetInputError from '@/Jetstream/InputError.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menuitems: Object,
    pwa: Object,
});
const form = useForm({
    name: props.pwa.name,
    short_name: props.pwa.short_name,
    scope: props.pwa.scope,
    start_url: props.pwa.start_url,
    background_color: props.pwa.background_color,
    theme_color: props.pwa.theme_color,
    description: props.pwa.description,
    dir: props.pwa.dir,
    orientation: props.pwa.orientation,
    display: props.pwa.display,
	icons: props.pwa.icons
});
const submit = () => {
    const addicons = [];
    $.each($('input.inputicon'), function(index,item){
	var val = $(item).val();
	var name = $(item).attr('name');
	var mimetype = $(item).attr('mimetype') ?? 'application/octet-stream';
	if(val.length > 0){
	addicons.push({sizes: name, type: mimetype, src: val});
	}
	});
	form.icons = addicons;
    form.transform(data => ({
        ...data,
    })).post(route('managerpwa.store'), {
        onFinish: () => form.reset(),
    });
};
$('body').on('change keyup keydown', 'input.inputicon', function(event){
var elem = $(this);
var id = $(this).attr('id');
var val = $(this).val();
if(val.length > 0){
$('img#img-' + id).attr('src', val).removeClass('d-none hidden');
function mimetype() {
    var xhr = new XMLHttpRequest();
    xhr.open("HEAD", val, true);
    xhr.onreadystatechange = function() {
        if (this.readyState == this.DONE) {
        if (this.status == 200) {
		var type = xhr.getResponseHeader("Content-Type");
             if (type == 'image/x-icon' || type == 'image/png' || type == 'image/jpg' || type == 'image/jpeg' || type == 'image/gif' || type == 'image/webp') {
                 $(elem).attr('mimetype', type).removeClass('border-danger').addClass('border-success');
             } else {
                 $(elem).attr('mimetype', 'image/' + val.split('.').pop() ?? '').removeClass('border-danger').addClass('border-success');
		     }
        } else {
		$(elem).addClass('border-danger').removeClass('border-success');
		}
        }
    };
    xhr.send();
}
mimetype()
} else {
$('img#img-' + id).addClass('d-none hidden');
$(elem).removeClass('border-danger border-success');
}
})

$('body').ready(function(){
$.each(props.pwa.icons, function(index,item){
if($('input#' + item.sizes).length > 0){
$('input#' + item.sizes).val(item.src);
}
});
});

</script>

<template>
<AppLayout :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
       <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Configuração padrão do Webmanifest</li>
        </template>
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="name" value="Name" />
                     <JetInput id="name" type="text" class="form-control mt-1 block w-full" placeholder="Name" v-model="form.name" name="name" autocomplete="name" required />
                     <JetInputError for="name" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="short_name" value="Short name" />
                     <JetInput id="short_name" type="text" class="form-control mt-1 block w-full" placeholder="Short name" v-model="form.short_name" name="short_name" autocomplete="short_name" required />
                     <JetInputError for="short_name" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="scope" value="Scope" />
                     <JetInput id="scope" type="text" class="form-control mt-1 block w-full" placeholder="Scope" v-model="form.scope" name="scope" autocomplete="scope" required />
                     <JetInputError for="scope" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="start_url" value="Start url" />
                     <JetInput id="start_url" type="text" class="form-control mt-1 block w-full" placeholder="Start url" v-model="form.start_url" name="short_name" autocomplete="start_url" required />
                     <JetInputError for="start_url" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="background_color" value="Background color" />
                     <JetInput id="background_color" type="color" class="form-control mt-1 block w-full" placeholder="Background color" v-model="form.background_color" name="background_color" autocomplete="background_color" required />
                     <JetInputError for="background_color" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="theme_color" value="Theme color" />
                     <JetInput id="theme_color" type="color" class="form-control mt-1 block w-full" placeholder="Theme color" v-model="form.theme_color" name="theme_color" autocomplete="theme_color" required />
                     <JetInputError for="theme_color" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="description" value="Description" />
                     <JetInput id="description" type="text" class="form-control mt-1 block w-full" placeholder="Description" v-model="form.description" name="description" autocomplete="description" required />
                     <JetInputError for="description" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="dir" value="Dir" />
                     <JetSelect id="dir" class="form-control mt-1 block w-full" placeholder="Dir" v-model="form.dir" name="dir" autocomplete="dir" required>
					 <option>ltr</option>
					 <option>rtl</option>
					 </JetSelect>
                     <JetInputError for="dir" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="orientation" value="Orientation" />
                     <JetSelect id="orientation" class="form-control mt-1 block w-full" placeholder="Orientation" v-model="form.orientation" name="orientation" autocomplete="orientation" required>
					 <option value="any">any</option>
					 <option value="natural">natural</option>
					 <option value="landscape">landscape</option>
					 <option value="landscape-primary">landscape-primary</option>
					 <option value="landscape-secondary">landscape-secondary</option>
					 <option value="portrait">portrait</option>
					 <option value="portrait-primary">portrait-primary</option>
					 <option value="portrait-secondary">portrait-secondary</option>
					 </JetSelect>
                     <JetInputError for="orientation" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-4">
                <div class="form-group">
                     <JetLabel for="display" value="Display" />
                     <JetSelect id="display" class="form-control mt-1 block w-full" placeholder="Display" v-model="form.display" name="display" autocomplete="display" required>
					 <option value="fullscreen">Fullscreen</option>
					 <option value="standalone">Standalone</option>
					 <option value="minimal-ui">Minimal-ui</option>
					 <option value="browser">Browser</option>
					 </JetSelect>
                     <JetInputError for="display" class="mt-2" />
                </div>
            </div>
			
            <div class="card card-body mx-2 mb-3">
            <div class="card-header border-0 text-dark font-bold fw-bold"> icons </div>
            <div class="row mt-2 px-1"> 
                 <div class="col-xs-12 col-sm-12 col-md-4">
				     <img class="d-none hidden" id="img-48x48" src="" width="48" height="48">
                     <div class="form-group">
                          <JetLabel for="48x48" value="48x48" />
                          <JetInput id="48x48" type="url" class="form-control mt-1 block w-full inputicon" placeholder="https://exemple.com/imagem.png" v-model="form.s48x48" name="48x48" autocomplete="48x48" required />
                          <JetInputError for="48x48" class="mt-2" />
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-4">
				     <img class="d-none hidden" id="img-72x72" src="" width="48" height="48">
                     <div class="form-group">
                          <JetLabel for="72x72" value="72x72" />
                          <JetInput id="72x72" type="url" class="form-control mt-1 block w-full inputicon" placeholder="https://exemple.com/imagem.png" v-model="form.s72x72" name="72x72" autocomplete="72x72" />
                          <JetInputError for="72x72" class="mt-2" />
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-4">
				     <img class="d-none hidden" id="img-96x96" src="" width="48" height="48">
                     <div class="form-group">
                          <JetLabel for="96x96" value="96x96" />
                          <JetInput id="96x96" type="url" class="form-control mt-1 block w-full inputicon" placeholder="https://exemple.com/imagem.png" v-model="form.s96x96" name="96x96" autocomplete="96x96" />
                          <JetInputError for="96x96" class="mt-2" />
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-4">
				     <img class="d-none hidden" id="img-144x144" src="" width="48" height="48">
                     <div class="form-group">
                          <JetLabel for="144x144" value="144x144" />
                          <JetInput id="144x144" type="url" class="form-control mt-1 block w-full inputicon" placeholder="https://exemple.com/imagem.png" v-model="form.s144x144" name="144x144" autocomplete="144x144" />
                          <JetInputError for="144x144" class="mt-2" />
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-4">
				     <img class="d-none hidden" id="img-168x168" src="" width="48" height="48">
                     <div class="form-group">
                          <JetLabel for="168x168" value="168x168" />
                          <JetInput id="168x168" type="url" class="form-control mt-1 block w-full inputicon" placeholder="https://exemple.com/imagem.png" v-model="form.s168x168" name="168x168" autocomplete="168x168" />
                          <JetInputError for="168x168" class="mt-2" />
                     </div>
                 </div>
                 <div class="col-xs-12 col-sm-12 col-md-4">
				     <img class="d-none hidden" id="img-192x192" src="" width="48" height="48">
                     <div class="form-group">
                          <JetLabel for="192x192" value="192x192" />
                          <JetInput id="192x192" type="url" class="form-control mt-1 block w-full inputicon" placeholder="https://exemple.com/imagem.png" v-model="form.s192x192" name="192x192" autocomplete="192x192" />
                          <JetInputError for="192x192" class="mt-2" />
                     </div>
                 </div>
			</div>
			</div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>

