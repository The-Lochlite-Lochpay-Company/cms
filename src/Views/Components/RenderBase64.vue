<script setup>
import DOMPurify from 'dompurify';

const props = defineProps({
    body: String,
});

const currentid = 'bodyRenderLazy-' + parseInt(Math.random());

$('body').ready(function(){
if($('div#' + currentid).length > 0){
$('div#' + currentid).html(Base64.atob(props.body))
}
});

</script>
<template>
  <div :id="currentid" v-if="body.length > 0">
	<div class="border border-blue-300 rounded-md p-4 w-full mx-auto">
        <div class="animate-pulse flex space-x-4">
          <div class="rounded-full bg-slate-700 h-10 w-10"></div>
          <div class="flex-1 space-y-6 py-1">
            <div class="h-2 bg-slate-700 rounded"></div>
            <div class="space-y-3">
              <div class="grid grid-cols-3 gap-4">
                <div class="h-2 bg-slate-700 rounded col-span-2"></div>
                <div class="h-2 bg-slate-700 rounded col-span-1"></div>
              </div>
              <div class="h-2 bg-slate-700 rounded"></div>
            </div>
          </div>
        </div>
    </div>
  </div>
</template>
