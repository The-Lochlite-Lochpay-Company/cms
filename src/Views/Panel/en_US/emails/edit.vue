<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import MylochiTinyEditor from  'lochlitecms/Views/Components/MylochiTinyEditor.vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    model: Object,
    modelbody: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    subject: props.model.subject,
    body: props.model.html_template,
});

const submit = (event) => {
    form.body = tinymce.activeEditor.getContent() || '<p><br><br></p>';
    form.transform(data => ({
        ...data,
    })).put(route('manageremailsmodel.update', {id: event.submitter.dataset.model}), {
        onFinish: () => form.reset(),
    });
};
</script>

<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
        <template #breadcrumb>
              <li class="breadcrumb-item active" aria-current="page">Editing model: {{ model.id }} - {{ model.subject }}</li>
        </template>
		
		 <div class="bg-teal-100 border-t-4 border-teal-500 rounded-b text-teal-900 px-4 py-3 my-3" role="alert">
             <div class="flex">
             <div class="py-1"><svg class="fill-current h-6 w-6 text-teal-500 mr-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M2.93 17.07A10 10 0 1 1 17.07 2.93 10 10 0 0 1 2.93 17.07zm12.73-1.41A8 8 0 1 0 4.34 4.34a8 8 0 0 0 11.32 11.32zM9 11V9h2v6H9v-4zm0-6h2v2H9V5z"/></svg></div>
             <div>
                <p class="font-bold">Instructions</p>
                <p class="text-sm">You can now use dynamic data to send individualized emails.</p>
                <p class="text-sm">Use one of the available options like this: <code v-pre>{{ optionname }}</code>, in the body and/or subject of the email template.</p>
				<div class="accordion w-100" id="accordionExample">

                 <div class="accordion-item mt-2 w-100">
                    <h2 class="accordion-header mb-0" id="headingThree">
                      <button class="accordion-button collapsed bg-transparent font-bold relative flex items-center w-full text-base text-dark text-left border-0 rounded-none transition focus:outline-none" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                        See available options
                      </button>
                    </h2>
                    <div id="collapseThree" class="accordion-collapse collapse bg-white w-100" aria-labelledby="headingThree"
                      data-bs-parent="#accordionExample">
                      <div class="accordion-body py-4 px-5 w-100">
                      <table class="table table-responsive w-100">
                        <thead>
                          <tr>
                            <th>Option</th>
                            <th>Way of use</th>
                            <th>Description</th>
                          </tr>
                        </thead>
                        <tbody>
                          <tr>
                            <td>appname</td>
                            <td v-pre>{{ appname }}</td>
                            <td>Add the name of this site</td>
                          </tr>
                          <tr>
                            <td>name</td>
                            <td v-pre>{{ name }}</td>
                            <td>Add recipient's name</td>
                          </tr>
                          <tr>
                            <td>email</td>
                            <td v-pre>{{ email }}</td>
                            <td>Add recipient email</td>
                          </tr>
                          <tr>
                            <td>phone</td>
                            <td v-pre>{{ phone }}</td>
                            <td>Add recipient's phone</td>
                          </tr>
                          <tr>
                            <td>address</td>
                            <td v-pre>{{ address }}</td>
                            <td>Add recipient address</td>
                          </tr>
                          <tr>
                            <td>addressNumber</td>
                            <td v-pre>{{ addressNumber }}</td>
                            <td>Add recipient address number</td>
                          </tr>
                          <tr>
                            <td>city</td>
                            <td v-pre>{{ city }}</td>
                            <td>Add recipient city/district</td>
                          </tr>
                          <tr>
                            <td>state</td>
                            <td v-pre>{{ state }}</td>
                            <td>Add recipient state/province</td>
                          </tr>
                          <tr>
                            <td>country</td>
                            <td v-pre>{{ country }}</td>
                            <td>Add recipient country</td>
                          </tr>
                        </tbody>
                      </table>
                      </div>
                    </div>
                  </div>
                 </div>
             </div>
             </div>
         </div>
		
        <JetValidationErrors class="mb-4" />

        <form @submit.prevent="submit">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                     <JetLabel for="subject" value="Subject" />
                     <JetInput id="subject" type="text" class="form-control mt-1 block w-full" placeholder="Welcome to the {{ appname }}, {{ name }}!" v-model="form.subject" name="subject" autocomplete="subject" />   
                     <JetInputError for="subject" class="mt-2" />
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 mb-3 rowcolumneditor">
             <MylochiTinyEditor data-type="edit" placeholder="Escreva aqui o conteúdo do modelo" v-model="form.body" name="body" id="mylochi-tiny" :data-body="modelbody"></MylochiTinyEditor>
	        </div>
            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
                <JetButton type="submit" class="btn btn-primary" title="Update" aria-label="Update" :data-model="model.id" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Update</JetButton>
            </div>
        </div>
      </form>

</AppLayout>
</template>
