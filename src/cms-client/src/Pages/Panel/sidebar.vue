<script setup>
/**
* The Lochlite & Lochpay Company - Technology that makes people's lives easier
*
* (c) 2019 - 2022 LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA., All Right Reserved.
*
* Software: LOCHLITE CMS
* Version: 2.0.7  
* License: Proprietary
* Made in: Brazil
* Author: The Lochlite & Lochpay Company
* Developer: IGOR MACEDO MONTALVÃO
* Website: https://lochlite.com | https://lochpay.com | https://gpgic.com 
* Support: drcg@gpgic.com | drcg@lochlite.com | drcl@lochlite.com
*
* LEGAL NOTICE: The author(s) of the software grants the user of the software a personal, non-transferable, limited and revocable license without the right to market, resell, distribute, clone or recycle the software; The author(s) reserve the right to renew, revoke or modify the license, as well as impose fines for its violation at its most reasonable discretion.
*
* DISCLAIMER: The author(s) of the Software will not be responsible for any physical, moral, property damages or of any nature due to the software, its enjoyment or risks up to the limits of the legislation in force in Brazil.
*
* ('Art. 43 - LEI No 4.502/1964' - law of brazil) Indústria Brasileira - LOCHLITE E LOCHPAY SOFTWARES E PAGAMENTOS LTDA, CNPJ: 37.816.728/0001-04; Address: SCS QUADRA 9, BLOCO C, 10 ANDAR, SALA 1003, Brasilia, Federal District, Brazil, Zip Code: 70308-200
**/

import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import JetActionMessage from '@/Jetstream/ActionMessage.vue';
import JetButton from '@/Jetstream/Button.vue';
import JetInput from '@/Jetstream/Input.vue';
import JetCheckbox from '@/Jetstream/Checkbox.vue';
import JetLabel from '@/Jetstream/Label.vue';
import JetValidationErrors from '@/Jetstream/ValidationErrors.vue';
import {mask, TheMask}  from 'vue-the-mask'

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    status: String,
    name: String,
    avatar: String,
    role: String,
    email: String,
    message: String,
});

const form = useForm({
    name: '',
    email: '',
    message: '',
});

const submit = () => {
    form.transform(data => ({
        ...data,
        remember: form.remember ? 'on' : '',
    })).post(route('sendcontact'), {
        onFinish: () => form.reset('email'),
    });
};
</script>

<template>
<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item nav-profile not-navigation-link">
      <div class="nav-link">
        <div class="user-wrapper">
          <div class="profile-image">
            <img :src="avatar" alt="name">
          </div>
          <div class="text-wrapper">
            <p class="profile-name text-truncate overflow-none" style="max-width:125px !important;">{{ name}}</p>
              <div class="d-flex inline-block" id="UsersettingsDropdown" href="#" data-bs-toggle="dropdown" aria-expanded="false">
                <small class="designation text-muted">{{ role }}</small>
                <span class="status-indicator online"></span>
			   </div>
          </div>
        </div>
        <Link class="btn btn-success btn-block p-2 d-flex justify-content-between" :href="route('managerposts.create')"><span class="align-self-center">Novo artigo</span> <i class="mdi mdi-plus align-self-center"></i></Link>
      </div>
    </li>
    <li class="nav-item">
      <Link class="nav-link" :href="route('index.index')">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </Link>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#posts" aria-expanded="" aria-controls="posts">
        <i class="menu-icon mdi mdi-format-float-left"></i>
        <span class="menu-title">Posts</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="posts">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerposts.create')">Criar artigo</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerposts.index')">Todos os artigos</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#pages" aria-expanded="" aria-controls="pages">
        <i class="menu-icon mdi mdi-newspaper"></i>
        <span class="menu-title">Página</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="pages">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerpages.create')">Criar página</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerpages.index')">Todas as páginas</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#comment" aria-expanded="" aria-controls="comment">
        <i class="menu-icon mdi mdi-message-text"></i>
        <span class="menu-title">Comentários</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="comment">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('managercomments.moderate')">Aprovar comentários</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('managercomments.index')">Todos os comentários</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#basic-ui" aria-expanded="" aria-controls="basic-ui">
        <i class="menu-icon mdi mdi-security"></i>
        <span class="menu-title">Administração do site</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="basic-ui">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('managersettings.index')">Configurações do sistema</Link>
          </li>
          <li class="nav-item"> 
            <Link class="nav-link" :href="route('managersettings.cleandata')">Dados armazenados</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#storange" aria-expanded="" aria-controls="storange">
        <i class="menu-icon mdi mdi-database"></i>
        <span class="menu-title">Amazenamento</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="storange">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerstorange.index')">Todos os arquivos</Link>
          </li>
          <li class="nav-item"> 
            <Link class="nav-link" :href="route('managerstorange.create')">Fazer upload</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#email" aria-expanded="" aria-controls="email">
        <i class="menu-icon mdi mdi-email"></i>
        <span class="menu-title">Email</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="email">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('manageremails.index')">Todos os emails</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('manageremailsmodel.index')">Modelos de email</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('manageremails.create')">Novo email</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" data-bs-toggle="collapse" href="#users" aria-expanded="" aria-controls="users">
        <i class="menu-icon mdi mdi-account-multiple"></i>
        <span class="menu-title">Gestão de usuários</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
      <div class="collapse" id="users">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerusers.index')">Todos os usuários</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerroles.index')">Gestão De Permissões</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerroles.create')">Novo tipo de usuário</Link>
          </li>
          <li class="nav-item">
            <Link class="nav-link" :href="route('managerusers.create')">Cadastrar usuário</Link>
          </li>
        </ul>
      </div>
    </li>
    <li class="nav-item">
      <a class="nav-link" href="#basic-ui">
        <i class="menu-icon mdi mdi-help-circle"></i>
        <span class="menu-title">Documentação</span>
        <i class="text-right mdi mdi-chevron-right pl-auto ml-auto"></i>
      </a>
    </li>
  </ul>
</nav>
</template>
