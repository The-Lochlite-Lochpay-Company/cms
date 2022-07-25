<style scoped>#newcomment {min-height: 2.5rem; white-space: pre-wrap; overflow-wrap: break-word;} .emoji-mart {position: absolute; top: 23px; right: 10px; z-index: 10000 !important;} @media (max-width: 600px){ .emoji-mart {position: absolute; top: 23px; right: 0; left: 0; padding: 1rem; width: 100%;}}</style>
<script setup>
import { ref } from 'vue'; import { Head, Link, useForm } from '@inertiajs/inertia-vue3'; import JetValidationErrors from 'lochlitecms/Views/Components/Layouts/ValidationErrors.vue'; import DOMPurify from 'dompurify'; import arrive from 'arrive';
const props = defineProps({user: Object, post: Object, comments: Object, likes: Object, deslikes: Object, voted: Boolean, status: ''});
const commentform = useForm({comment: ''});
const formaddcomment = (event) => {
commentform.transform(data => ({ ...data, comment: Base64.encode(DOMPurify.sanitize($('textarea#newcomment').val())), })).post(route('sendcomment', {id: event.submitter.dataset.post}), {onFinish: () => commentform.reset(),});
};
const votesform = useForm({type: 'upvote'});
const formaddvotes = (event) => {
votesform.transform(data => ({ ...data, id: event.submitter.dataset.id, type: event.submitter.dataset.type })).post(route('sendvotes', {id: event.submitter.dataset.post}));
};
function timeSince(date) {
  var seconds = Math.floor((new Date() - date) / 1000);
  var interval = seconds / 31536000;
  if (interval > 1) {return Math.floor(interval) + " years";}
  interval = seconds / 2592000;
  if (interval > 1) {return Math.floor(interval) + " months";}
  interval = seconds / 86400;
  if (interval > 1) {return Math.floor(interval) + " days";}
  interval = seconds / 3600;
  if (interval > 1) {return Math.floor(interval) + " hours";}
  interval = seconds / 60;
  if (interval > 1) {return Math.floor(interval) + " minutes";}
  return Math.floor(seconds) + " seconds";
}

$('body').ready(function(){
   $('body').on("keyup keydown change input", '#newcomment', function(){$(this).css('height', 'auto').css('height', this.scrollHeight+ (this.offsetHeight - this.clientHeight));});
   $.each($('#group-comment > div.main-comment'), function(index, item){
        var setbody = $(item).find('div.body-comment');
        var getbase = $(setbody).data('body');
        $(setbody).html(DOMPurify.sanitize(Base64.decode(getbase)));
   });
   $("#group-comment").arrive("div.main-comment", function() {
	    var setbody = $(this).find('div.body-comment');
        var getbase = $(setbody).data('body');
        $(setbody).html(DOMPurify.sanitize(Base64.decode(getbase)));
   });
});
</script>
<template>
     <div class="flex justify-start mb-2 border-t border-gray-100">
         <div v-if="user" class="flex w-full mt-1 pt-2 pl-5">
             <form id="addnewupvote" @submit.prevent="formaddvotes">
             <input type="hidden" class="form-control" name="type" v-model="votesform.type"/>
             <button type="submit" class="text-blue-700 border border-blue-700 hover:bg-blue-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800 mr-3" data-type="upvote" :data-post="post.id" :class="{ 'opacity-25': votesform.processing || voted == true }" :disabled="votesform.processing || voted == true">
                 <i class="fa-solid fa-thumbs-up w-5 h-5"></i>
             </button>
             </form>
             <form id="addnewdownvote" @submit.prevent="formaddvotes">
             <input type="hidden" class="form-control" name="type" v-model="votesform.type"/>
             <button type="submit" class="text-red-700 border border-red-700 hover:bg-red-700 hover:text-white focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center dark:border-blue-500 dark:text-blue-500 dark:hover:text-white dark:focus:ring-blue-800" data-type="downvote" :data-post="post.id" :class="{ 'opacity-25': votesform.processing || voted == true }" :disabled="votesform.processing || voted == true">
                 <i class="fa-solid fa-thumbs-down w-5 h-5"></i>
             </button>
             </form>
         </div>
         <div v-else class="flex w-full mt-1 pt-2 pl-5">
             <Link :href="route('login.index')" class="border border-blue-700 from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br hover:text-white hover:outline-none focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center mr-3">
                 Faça login para comentar
             </Link>
         </div>
         <div class="dropdown flex justify-end w-full mt-1 pt-2 pr-5">
             <button class="transition ease-out duration-300 hover:bg-blue-50 bg-blue-100 h-8 px-2 py-2 text-center rounded-full text-blue-400 cursor-pointer mr-2" data-bs-toggle="dropdown" data-dropdown-toggle="dropdownsherepost" id="dropdownDefault" aria-expanded="false" aria-haspopup="true" type="button">
                 <svg xmlns="http://www.w3.org/2000/svg" fill="none" width="14px" viewBox="0 0 24 24" stroke="currentColor">
                     <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z" />
                 </svg>
             </button>
             <div id="dropdownsherepost" class="dropdown-menu z-10 bg-white divide-y divide-gray-100 rounded shadow w-44 dark:bg-gray-700" aria-labelledby="dropdownsherepost">
                 <ul class="py-1 text-sm text-dark dark:text-gray-200" aria-labelledby="dropdownDefault">
                   <li>
                     <a :href="'https://www.facebook.com/sharer/sharer.php?u=' + route(route().current(), {id: post.url})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Facebook</a>
                   </li>
                   <li>
                     <a :href="'https://twitter.com/intent/tweet?url=' + route(route().current(), {id: post.url})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Twitter</a>
                   </li>
                   <li>
                     <a :href="'whatsapp://send?text=' + route(route().current(), {id: post.url})" class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">Whatsapp</a>
                   </li>
                 </ul>
             </div>
         </div>
     </div>
     <div class="flex w-full border-t border-gray-100">
         <div class="mt-3 mx-5 flex flex-row">
             <div class='flex text-gray-700 font-normal text-sm rounded-md mb-2 mr-4 items-center'>Comentários:<div class="ml-1 text-gray-400 font-thin text-ms"> {{ comments.length }}</div></div>
             <div class='flex text-gray-700 font-normal text-sm rounded-md mb-2 mr-4 items-center'>Visualizações: <div class="ml-1 text-gray-400 font-thin text-ms"> {{ post.views }}</div></div>
         </div>
         <div class="mt-3 mx-5 w-full flex justify-end">
             <div class='flex text-gray-700 font-normal text-sm rounded-md mb-2 mr-4 items-center'>Likes: <div class="ml-1 text-gray-400 font-thin text-ms"> {{ post.upvote }}</div></div>
             <div class='flex text-gray-700 font-normal text-sm rounded-md mb-2 mr-4 items-center'>Deslikes: <div class="ml-1 text-gray-400 font-thin text-ms"> {{ post.downvote }}</div></div>
         </div>
     </div>
     <form v-if="user" class="relative flex items-center self-center w-full p-4 overflow-hidden text-gray-600 focus-within:text-gray-400" @submit.prevent="formaddcomment">
         <img class='w-10 h-10 object-cover rounded-full shadow mr-2 cursor-pointer' alt='User avatar' :src="user.avatar">
         <span class="absolute inset-y-0 right-0 flex items-center pr-6">
             <button type="button" class="p-1 focus:outline-none focus:shadow-none hover:text-blue-500"  :class="{ 'triggered': showEmojiPicker }" @mousedown.prevent="toggleEmojiPicker">
             <svg class="w-6 h-6 transition ease-out duration-300 hover:text-blue-500 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                 <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.828 14.828a4 4 0 01-5.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
             </svg>
             </button>
             <button type="submit" class="p-1 focus:outline-none focus:shadow-none hover:text-blue-500 ml-2 mr-3" :data-post="post.id" :class="{ 'opacity-25': commentform.processing }" :disabled="commentform.processing">
             <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
               <path stroke-linecap="round" stroke-linejoin="round" d="M13 9l3 3m0 0l-3 3m3-3H8m13 0a9 9 0 11-18 0 9 9 0 0118 0z" />
             </svg>
             </button>
          </span>
          <textarea id="newcomment" class="h-10 w-full px-3 py-1.5 w-full py-2 pl-4 pr-10 text-sm bg-gray-100 border border-transparent appearance-none rounded-tg placeholder-gray-400 focus:bg-white focus:outline-none focus:border-blue-500 focus:text-gray-900 focus:shadow-outline-blue" style="border-radius: 25px" placeholder="Post a comment..." v-model="commentform.comment" name="comment" ref="textarea" @input="$emit('input', $event.target.value)" autocomplete required></textarea>
     </form>
     <JetValidationErrors class="mb-4" />
     <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
         {{ status }}
     </div>
     <Picker v-show="showEmojiPicker" :data="emojiIndex" emoji="point_up" @select="addEmoji" title="Pick your emoji…" />
     <div class="bg-white flex justify-center items-center">
           <div class="bg-white w-full mx-5 px-3 py-2 flex flex-col space-y-2" id="group-comment">
         
             <div v-for="row in comments" class="flex items-center space-x-2 main-comment">
               <div class="flex flex-shrink-0 self-start">
                 <img :src="row.avatar" alt="" class="h-8 w-8 object-cover rounded-full">
               </div>
         
               <div class="flex items-center justify-center space-x-2">
                 <div class="block">
                   <div class="bg-gray-100 w-auto rounded-xl px-2 pb-2">
                     <div class="font-medium">
                       <div class="hover:underline text-md">
                         <small>{{row.name}}</small>
                       </div>
                     </div>
                     <div class="text-sm body-comment" :data-body="row.comment">
	       		  
                     </div>
                   </div>
                   <div class="flex justify-start items-center text-xs w-full">
                     <div class="font-semibold text-gray-700 px-2 flex items-center justify-center space-x-1">
                      <small class="self-center">.</small>
                       <div class="hover:underline">
                         <small>{{timeSince(new Date(row.created_at))}}</small>
                       </div>
                     </div>
                   </div>
                   
                 </div>
               </div>
             </div>
         </div>
     </div>
</template>

<script>
import data from "emoji-mart-vue-fast/data/all.json";
import "emoji-mart-vue-fast/css/emoji-mart.css";
import { Picker, EmojiIndex } from "emoji-mart-vue-fast/src";
// Create emoji data index.
// We can change it (for example, filter by category) before passing to the component.
let emojiIndex = new EmojiIndex(data);

export default {components: {Picker}, data() {return {emojiIndex: emojiIndex, emojisOutput: "", showEmojiPicker: false};},

methods: {addEmoji (emoji) { //https://stackoverflow.com/a/47850725/12114919
function insertAtCursor(myField, myValue) {
    //IE support
    if (document.selection) {myField.focus(); sel = document.selection.createRange(); sel.text = myValue;}
    // Microsoft Edge
    else if(window.navigator.userAgent.indexOf("Edge") > -1) {var startPos = myField.selectionStart; var endPos = myField.selectionEnd; myField.value = myField.value.substring(0, startPos)+ myValue + myField.value.substring(endPos, myField.value.length); var pos = startPos + myValue.length; myField.focus(); myField.setSelectionRange(pos, pos);}
    //MOZILLA and others
    else if (myField.selectionStart || myField.selectionStart == '0') {var startPos = myField.selectionStart; var endPos = myField.selectionEnd; myField.value = myField.value.substring(0, startPos) + myValue + myField.value.substring(endPos, myField.value.length);}
	else {myField.value += myValue;}
    triggerEvent(myField,'input');
}
function triggerEvent(el, type){
    // modern browsers, IE9+
  if ('createEvent' in document) { var e = document.createEvent('HTMLEvents'); e.initEvent(type, false, true); el.dispatchEvent(e);}
    // IE 8
  else {var e = document.createEventObject(); e.eventType = type; el.fireEvent('on'+e.eventType, e);}
} 
insertAtCursor(this.$refs.textarea, emoji.native)}, toggleEmojiPicker () {this.showEmojiPicker = !this.showEmojiPicker}}

};
</script>
