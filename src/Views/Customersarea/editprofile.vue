<script setup>
import { ref } from 'vue';
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import AppLayout from 'lochlitecms/Views/Customersarea/AppLayout.vue';
import DOMPurify from 'dompurify';
import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue';

const props = defineProps({
    title: String,
    lang: String,
    tab: String,
    mynotifications: Object,
    status: String,
    user: Object,
    email: String,
    name: String,
    avatar: String,
    wallpaper: String,
    customersarea: Object,
});

const form = useForm({
    first_name: props.name,
    last_name: props.user.last_name,
    gender: props.user.gender,
    social_security: props.user.social_security,
    email: props.email,
    phone: props.user.phone,
    address: props.user.address,
    address_number: props.user.address_number,
    city: props.user.city,
    state: props.user.state,
    country: props.user.country,
    zipcode: props.user.zipcode,
    password: '',
    confirmpassword: '',
});
const submit = () => {
    form.first_name = DOMPurify.sanitize(form.first_name);
    form.last_name = DOMPurify.sanitize(form.last_name);
    form.gender = DOMPurify.sanitize(form.gender);
    form.social_security = DOMPurify.sanitize(form.social_security);
    form.email = DOMPurify.sanitize(form.email);
    form.phone = DOMPurify.sanitize(form.phone);
    form.address = DOMPurify.sanitize(form.address);
    form.address_number = DOMPurify.sanitize(form.address_number);
    form.city = DOMPurify.sanitize(form.city);
    form.state = DOMPurify.sanitize(form.state);
    form.country = DOMPurify.sanitize(form.country);
    form.zipcode = DOMPurify.sanitize(form.zipcode);
    form.password = DOMPurify.sanitize(form.password);
    form.transform(data => ({
        ...data,
    })).put(route('dashboard.update', {id: props.user.id}));
};

</script>
<template>
<AppLayout :totalmessages="mynotifications.total" :customersarea="customersarea" :lang="lang" :user="user" :name="name" :email="email" :avatar="avatar" :title="title">
     <div class="container">
         <div class="card card-body bg-white dark:bg-gray-800 py-3 px-4">
             <div class="h4 mb-4 text-lg font-semibold text-gray-600 dark:text-gray-300">
              <span v-if="lang == 'pt_BR'" class="ml-4">Editar perfil</span>
              <span v-else-if="lang == 'en_US'" class="ml-4">Edit profile</span>
              <span v-else class="ml-4">Edit profile</span>
             </div>
             
			 <JetValidationErrors class="my-4" />

		     <ul class="nav nav-tabs flex flex-col md:flex-row flex-wrap list-none border-b-0 pl-0 mb-4" id="tabs-tab" role="tablist">
                 <li class="nav-item" role="presentation">
                   <a href="#tabs-photo" class="
                     nav-link
                     block
                     font-medium
                     text-xs
                     leading-tight
                     uppercase
                     border-x-0 border-t-0 border-b-2 border-transparent
                     px-6
                     py-3
                     my-2
                     hover:border-transparent hover:bg-gray-100
                     focus:border-transparent
                   " :class="{'active': tab == null || tab == 'photo'}" id="tabs-photo-tab" data-bs-toggle="pill" data-bs-target="#tabs-photo" role="tab" aria-controls="tabs-photo"
                     aria-selected="true">
                         <span v-if="lang == 'pt_BR'" class="ml-4">Foto</span>
                         <span v-else-if="lang == 'en_US'" class="ml-4">Photo</span>
                         <span v-else class="ml-4">Photo</span>							  					 
					 </a>
                 </li>
                 <li class="nav-item" role="presentation">
                   <a href="#tabs-personal" class="
                     nav-link
                     block
                     font-medium
                     text-xs
                     leading-tight
                     uppercase
                     border-x-0 border-t-0 border-b-2 border-transparent
                     px-6
                     py-3
                     my-2
                     hover:border-transparent hover:bg-gray-100
                     focus:border-transparent
                   " :class="{'active': tab == 'personal'}" id="tabs-personal-tab" data-bs-toggle="pill" data-bs-target="#tabs-personal" role="tab" aria-controls="tabs-personal"
                     aria-selected="true">
                         <span v-if="lang == 'pt_BR'" class="ml-4">Dados pessoais</span>
                         <span v-else-if="lang == 'en_US'" class="ml-4">Personal information</span>
                         <span v-else class="ml-4">Personal information</span>							  					 
					 </a>
                 </li>
                 <li class="nav-item" role="presentation">
                   <a href="#tabs-address" class="
                     nav-link
                     block
                     font-medium
                     text-xs
                     leading-tight
                     uppercase
                     border-x-0 border-t-0 border-b-2 border-transparent
                     px-6
                     py-3
                     my-2
                     hover:border-transparent hover:bg-gray-100
                     focus:border-transparent
                   " :class="{'active': tab == 'address'}" id="tabs-address-tab" data-bs-toggle="pill" data-bs-target="#tabs-address" role="tab"
                     aria-controls="tabs-address" aria-selected="false">
                        <span v-if="lang == 'pt_BR'" class="ml-4">Endereço</span>
                        <span v-else-if="lang == 'en_US'" class="ml-4">Address</span>
                        <span v-else class="ml-4">Address</span>							  					 
					 </a>
                 </li>
                 <li class="nav-item" role="presentation">
                   <a href="#tabs-password" class="
                     nav-link
                     block
                     font-medium
                     text-xs
                     leading-tight
                     uppercase
                     border-x-0 border-t-0 border-b-2 border-transparent
                     px-6
                     py-3
                     my-2
                     hover:border-transparent hover:bg-gray-100
                     focus:border-transparent
                   " :class="{'active': tab == 'password'}" id="tabs-password-tab" data-bs-toggle="pill" data-bs-target="#tabs-password" role="tab"
                     aria-controls="tabs-password" aria-selected="false">
                        <span v-if="lang == 'pt_BR'" class="ml-4">Alterar senha</span>
                        <span v-else-if="lang == 'en_US'" class="ml-4">Change Password</span>
                        <span v-else class="ml-4">Change Password</span>							  					 
					 </a>
                 </li>
             </ul>
             
                     <form @submit.prevent="submit" title="Dados da conta">
                     <div class="tab-content mb-3" id="tabs-tabContent">
                     <div class="tab-pane fade" :class="{'active show': tab == null || tab == 'photo'}" id="tabs-photo" role="tabpanel" aria-labelledby="tabs-photo-tab">
                         <img width="72" height="72" class="rounded-full mb-3" :src="avatar" alt="Image profile">
                         <DropZone 
                         method="POST" 
                         :maxFiles="Number(1)" 
			  	         :acceptedFiles="['png','jpg','jpeg','ico','webp','gif']" 
                         :headers="{ 'X-CSRF-TOKEN': token }"
                         :url="route('dashboard.store')" 
                         :uploadOnDrop="true" 
                         :multipleUpload="false" 
                         :parallelUpload="1"
                         @uploaded="onSuccessUpload" @errorUpload="onErrorUpload">
                         <div class="dropZone-info">
                         <span class="fa fa-cloud-upload dropZone-title"></span>
                         <span class="dropZone-title">Drop file or click to upload</span>        <div class="dropZone-upload-limit-info">
                         <div>extension support: png, jpeg, jpg</div>
                         <div>maximum file size: 5 MB</div>
                         </div>
                         </div>
	                     </DropZone>
                         <div id="status"></div> 

					 </div>
					 <div class="tab-pane fade" :class="{'active show': tab == 'personal'}" id="tabs-personal" role="tabpanel" aria-labelledby="tabs-personal-tab">
                      <div class="row grid grid-cols-1 md:grid-cols-3 gap-3">
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="firstname">Primeiro nome</label>
                                   <input id="firstname" type="text" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="John" v-model="form.first_name" title="Digite o seu primeiro nome" name="first_name" autocomplete="first_name" required />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="lastname">Sobrenome</label>
                                   <input id="lastname" type="text" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="Joe" v-model="form.last_name" title="Digite o seu sobrenome" name="last_name" autocomplete="last_name" required />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="gender">Gênero</label>
                                   <select id="gender" class="form-select rounded-0 shadow-none mt-1 block w-full" placeholder="john@mail.com" v-model="form.gender" title="Selecione o seu gênero" name="gender" autocomplete="gender">
		              			   <option value="male">Masculino</option>
		              			   <option value="female">Feminino</option>
		              			   <option value="others">Outro</option>
		              			   </select>
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="socialsecurity">CPF</label>
                                   <input id="socialsecurity" type="number" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="00000000000" title="Digite o seu CPF" v-model="form.social_security" name="social_security" autocomplete="social_security" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="email">E-mail</label>
                                   <input id="email" type="email" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="john@mail.com" title="Digite o seu email" v-model="form.email" name="email" autocomplete="email" required />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="phone">Telefone</label>
                                   <input id="phone" type="tel" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="1 0000 0000" title="Digite o seu número de telefone" v-model="form.phone" name="phone" autocomplete="phone" />
                              </div>
                          </div>


                      </div>
                      </div>
                     <div class="tab-pane fade" :class="{'active show': tab == 'address'}" id="tabs-address" role="tabpanel" aria-labelledby="tabs-address-tab">
                      <div class="row grid grid-cols-1 md:grid-cols-3 gap-3">
					  
                          <div class="col-xs-12 col-sm-12 col-md-6">
                              <div class="form-group">
                                   <label for="address">Endereço</label>
                                   <input id="address" type="text" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="Ex: 1252 Snider Street, Hartsel, Colorado" title="Digite o seu endereço completo" v-model="form.address" name="address" autocomplete="address" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-2">
                              <div class="form-group">
                                   <label for="addressnumber">Número</label>
                                   <input id="addressnumber" type="number" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="101" title="Digite o número do seu endereço" v-model="form.address_number" name="addressnumber" autocomplete="suite" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="city">Cidade</label>
                                   <input id="city" type="text" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="Hartsel" title="Digite o nome da sua cidade" v-model="form.city" name="city" autocomplete="city" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="state">Estado</label>
                                   <input id="state" type="text" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="Colorado" title="Digite o nome do seu estado" v-model="form.state" name="state" autocomplete="state" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="country">País</label>
                                   <input id="country" type="text" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="United States" title="Digite o nome do seu país" v-model="form.country" name="country" autocomplete="country" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-4">
                              <div class="form-group">
                                   <label for="zipcode">CEP</label>
                                   <input id="zipcode" type="number" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="00 000 0000" title="Digite o seu codigo postal" v-model="form.zipcode" name="zipcode" autocomplete="zipcode" />
                              </div>
                          </div>					  
					  
					  
                      </div>
                      </div>
                     <div class="tab-pane fade" :class="{'active show': tab == 'password'}" id="tabs-password" role="tabpanel" aria-labelledby="tabs-password-tab">
                      <div class="row grid grid-cols-1 md:grid-cols-2 gap-2">
					  
                          <div class="col-xs-12 col-sm-12 col-md-6">
                              <div class="form-group">
                                   <label for="password">Nova senha</label>
                                   <input id="password" type="password" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="**********" title="Digite a sua nova senha" v-model="form.password" name="password" autocomplete="new-password" />
                              </div>
                          </div>
                          <div class="col-xs-12 col-sm-12 col-md-6">
                              <div class="form-group">
                                   <label for="confirmpassword">Confime a nova senha</label>
                                   <input id="confirmpassword" type="password" class="form-control rounded-0 shadow-none mt-1 block w-full" placeholder="***********" title="Digite novamente a sua nova senha" v-model="form.confirmpassword" name="confirmpassword" autocomplete="new-password" />
                              </div>
                          </div>
						  
                      </div>
                      </div>
					  
                      </div>
					  
					  
					  
                     <button type="submit" class="py-2 px-3 bg-gray-800 text-white dark:text-gray-800 dark:bg-white hover:bg-blue-500 dark:hover:bg-blue-500 font-bold" title="Clique para atualizar os seus dados" aria-label="Atualizar" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">Atualizar</button>
                     </form>
     </div>
     </div>
</AppLayout>
</template>
<script>
const token = document.head.querySelector('meta[name="_token"]').content
export default{
data(){
return{
onSuccessUpload(a){
$('div#status').html('<div class="fixed-bottom shadow-sm bg-success max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8"><p class="ml-3 font-medium text-sm text-white truncate">A sua foto de perfil foi atualizada com sucesso.</p></div></div>');
$('#newavatar').modal('hide');
setTimeout(function(){
$('div#status').html('');
location.reload(true);
}, 5000);
},
onErrorUpload(a,b,c){
$('div#status').html('<div class="fixed-bottom shadow-sm bg-danger max-w-screen-xl mx-auto py-2 px-3 sm:px-6 lg:px-8"><p class="ml-3 font-medium text-sm text-white truncate">Ocorreu um erro no carregamento.</p></div></div>');
setTimeout(function(){$('div#status').html('');}, 8000);
}
}
}
}
</script>