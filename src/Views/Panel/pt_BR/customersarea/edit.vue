<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetDialogModal from 'lochlitecms/Views/Components/Layouts/DialogModal.vue';
import JetActionMessage from 'lochlitecms/Views/Components/Layouts/ActionMessage.vue';
import JetButton from 'lochlitecms/Views/Components/Layouts/Button.vue';
import JetInput from 'lochlitecms/Views/Components/Layouts/Input.vue';
import JetInputError from 'lochlitecms/Views/Components/Layouts/InputError.vue';
import JetCheckbox from 'lochlitecms/Views/Components/Layouts/Checkbox.vue';
import JetLabel from 'lochlitecms/Views/Components/Layouts/Label.vue';
import JetSelect from 'lochlitecms/Views/Components/Layouts/Select.vue';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';
import AppLayout from 'lochlitecms/Views/Panel/AppLayout.vue';
import MylochiTinyEditor from  'lochlitecms/Views/Components/MylochiTinyEditor.vue';
import DOMPurify from 'dompurify';

const props = defineProps({
    cancustomersarea: Boolean,
    canRegister: Boolean,
    title: String,
    status: String,
    name: String,
    role: String,
    avatar: String,
    version: String,
    breadcrumbCurrentTitle: String,
    breadcrumbCurrentSection: String,
    services: Object,
    customersarea: Object,
    menulang: Object,
    menuitems: Object,
});
const form = useForm({
    domain: props.customersarea.domain,
    default: props.customersarea.default,
    logo: props.customersarea.logo,
    logotype: props.customersarea.logotype,
    logowidth: props.customersarea.logowidth,
    logoheight: props.customersarea.logoheight,
    themecolor: props.customersarea.themecolor,
    textsidebar: props.customersarea.textsidebar,
    coloredsidebar: props.customersarea.coloredsidebar,
    buttoncolor: props.customersarea.buttoncolor,
    buttontext: props.customersarea.buttontext,
    buttonurl: props.customersarea.buttonurl,
    alert: props.customersarea.alert,
    search: props.customersarea.search,
    darkmode: props.customersarea.darkmode,
    button: props.customersarea.button,
    notifications: props.customersarea.notifications,
    comments: props.customersarea.comments,
    history: props.customersarea.history,
    shopping: props.customersarea.shopping,
    default: props.customersarea.default,
    items: props.customersarea.items,
    status: props.customersarea.status,
});
const submit = () => {
    form.put(route('managercustomersarea.update', {id: props.customersarea.id}));
};
</script>
<template>
<AppLayout :menulang="menulang" :menuitems="menuitems" :avatar="avatar" :role="role" :name="name" :version="version" :breadcrumbCurrentTitle="breadcrumbCurrentTitle" :breadcrumbCurrentSection="breadcrumbCurrentSection" :title="title">
  <template #breadcrumb>
    <li class="breadcrumb-item active" aria-current="page">Editando área do cliente</li>
  </template>
  <JetValidationErrors class="mb-4" />

  <form @submit.prevent="submit">
    <div class="flex flex-wrap">
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="domain" value="Domain" />
          <JetInput id="domain" type="text" class="mt-1 block w-full" placeholder="https://domain.com" v-model="form.domain" name="domain" autocomplete="domain" autofocus required />
          <JetInputError for="domain" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="default" value="Default" />
          <JetSelect id="default" class="mt-1 block w-full" placeholder="Default" v-model="form.default" name="default" autocomplete required>
            <option value="0">False</option>
            <option value="1">True</option>
          </JetSelect>
          <JetInputError for="default" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="status" value="Status" />
          <JetSelect id="status" class="mt-1 block w-full" placeholder="status" v-model="form.status" name="status" autocomplete required>
            <option value="active">Active</option>
            <option value="disabled">Disabled</option>
          </JetSelect>
          <JetInputError for="status" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="themecolor" value="Theme color" />
          <JetInput id="themecolor" type="color" class="mt-1 block w-full" placeholder="#00000" v-model="form.themecolor" name="themecolor" autocomplete="themecolor" required />
          <JetInputError for="themecolor" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="coloredsidebar" value="Colored sidebar" />
          <JetInput id="coloredsidebar" type="color" class="mt-1 block w-full" placeholder="#00000" v-model="form.coloredsidebar" name="coloredsidebar" autocomplete="coloredsidebar" required />
          <JetInputError for="coloredsidebar" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="textsidebar" value="Text sidebar" />
          <JetInput id="textsidebar" type="color" class="mt-1 block w-full" placeholder="#00000" v-model="form.textsidebar" name="textsidebar" autocomplete="textsidebar" required />
          <JetInputError for="textsidebar" class="mt-2" />
        </div>
      </div>
      <div class="w-full md:w-1/3">
        <div class="mb-4">
          <JetLabel for="buttoncolor" value="Button color" />
          <JetInput id="buttoncolor" type="color" class="mt-1 block w-full" placeholder="#00000" v-model="form.buttoncolor" name="buttoncolor" autocomplete="buttoncolor" required />
          <JetInputError for="buttoncolor" class="mt-2" />
        </div>
            </div>
      <div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="buttontext" value="Button text" />
    <JetInput id="buttontext" type="text" class="mt-1 block w-full" placeholder="Exemple link" v-model="form.buttontext" name="buttontext" autocomplete="buttontext" required />
    <JetInputError for="buttontext" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="buttonurl" value="Button url" />
    <JetInput id="buttonurl" type="text" class="mt-1 block w-full" placeholder="https://domain.com" v-model="form.buttonurl" name="buttonurl" autocomplete="buttonurl" required />
    <JetInputError for="buttonurl" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/2">
  <div class="mb-4">
    <JetLabel for="logo" value="Logo" />
    <JetInput id="logo" type="text" class="mt-1 block w-full" placeholder="url or text" v-model="form.logo" name="logo" autocomplete="logo" autofocus required />
    <JetInputError for="logo" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/2">
  <div class="mb-4">
    <JetLabel for="logotype" value="Logo type" />
    <JetSelect id="logotype" class="mt-1 block w-full" placeholder="logotype" v-model="form.logotype" name="logotype" autocomplete required>
      <option value="text">Text</option>
      <option value="image">image</option>
    </JetSelect>
    <JetInputError for="logotype" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/2">
  <div class="mb-4">
    <JetLabel for="logowidth" value="Logo width" />
    <JetInput id="logowidth" type="number" class="mt-1 block w-full" placeholder="72" v-model="form.logowidth" name="logowidth" autocomplete="logowidth" autofocus required />
    <JetInputError for="logowidth" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/2">
  <div class="mb-4">
    <JetLabel for="logoheight" value="Logo height" />
    <JetInput id="logoheight" type="number" class="mt-1 block w-full" placeholder="72" v-model="form.logoheight" name="logoheight" autocomplete="logoheight" autofocus required />
    <JetInputError for="logoheight" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="search" value="Enable search" />
    <JetSelect id="search" class="mt-1 block w-full" placeholder="search" v-model="form.search" name="search" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="search" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="darkmode" value="Enable darkmode" />
    <JetSelect id="darkmode" class="mt-1 block w-full" placeholder="darkmode" v-model="form.darkmode" name="darkmode" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="darkmode" class="mt-2" />
  </div>
            </div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="button" value="Enable button" />
    <JetSelect id="button" class="mt-1 block w-full" placeholder="button" v-model="form.button" name="button" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="button" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="notifications" value="Enable notifications" />
    <JetSelect id="notifications" class="mt-1 block w-full" placeholder="notifications" v-model="form.notifications" name="notifications" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="notifications" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="comments" value="Enable comments" />
    <JetSelect id="comments" class="mt-1 block w-full" placeholder="comments" v-model="form.comments" name="comments" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="comments" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="history" value="Enable history" />
    <JetSelect id="history" class="mt-1 block w-full" placeholder="history" v-model="form.history" name="history" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="history" class="mt-2" />
  </div>
</div>
<div class="w-full md:w-1/3">
  <div class="mb-4">
    <JetLabel for="shopping" value="Enable shopping" />
    <JetSelect id="shopping" class="mt-1 block w-full" placeholder="shopping" v-model="form.shopping" name="shopping" autocomplete required>
      <option value="0">False</option>
      <option value="1">True</option>
    </JetSelect>
    <JetInputError for="shopping" class="mt-2" />
  </div>
</div>
<div class="w-full">
  <div class="mb-4">
    <JetLabel for="alert" value="Show alert" />
    <textarea id="alert" class="mt-1 block w-full" placeholder="alert" v-model="form.alert" name="alert" autocomplete></textarea>
    <JetInputError for="alert" class="mt-2" />
  </div>
</div>

<div class="w-full text-center">
  <JetButton type="submit" class="btn btn-primary" title="Atualizar" aria-label="Atualizar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</JetButton>
</div>
</div>
      </form>
</AppLayout>
</template>
