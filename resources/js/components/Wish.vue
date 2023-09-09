<script setup>
  import { ref, inject } from 'vue'
  import Dropdown from './Dropdown.vue'
  import DropdownItem from './DropdownItem.vue'
  import Button from './Button.vue';

  const $eventBus = inject('$eventBus');
  const emit = defineEmits(['deleteWish', 'editWish', 'checkWish'])
  const props = defineProps(['position', 'id', 'name', 'user', 'description', 'disabled', 'errors', 'url', 'checked', 'allowDeleting', 'allowChecking']);
  const isAboveTablet = window.innerWidth > 768

  const emitCheckWish = () => {
    if (!props.allowChecking || props.disabled) {
      return;
    }

    emit("checkWish", props.position)
  }

  const emitDeleteWish = () => {
    emit("deleteWish", props.position)
  }

  const editWish = () => {
    $eventBus.emit('showWishCreationModal', {
      position: props.position,
      wish: {
        id: props.id,
        name: props.name,
        url: props.url,
        description: props.description,
      }
    });
  }
</script>

<template>
  <li :id="'wishlist_wish_' + position"
    @click="emitCheckWish"
    class="wish group mb-2 w-auto px-2 py-1 sm:px-4 sm:py-3 flex gap-4 duration-200 rounded-xl"
    :class="{ 'wish-ok': !errors && !checked, disabled: disabled, checked: checked, error: errors, 'cursor-pointer' : allowChecking }"
    >
    <span
      class="wish-bullet rounded-md font-bold duration-200 my-1 w-8 h-8 shrink-0 flex justify-center items-center not-italic text-sm"
      :class="{'bg-rose-700 text-rose-200': errors, 'text-slate-500': checked && !errors, 'bg-slate-800  group-active:text-sky-600': !errors && !checked}">
      <Transition name="switch" mode="out-in">
        <svg v-if="checked"><use href="#check"/></svg>
        <span v-else>{{ position + 1 }}</span>
      </Transition>
    </span>

    <div class="flex-grow flex-shrink py-2">
      <p class="wish-name duration-300 leading-normal" :class="{'line-through': checked, 'text-slate-200 group-active:text-sky-500': !errors && !checked}"><strong>{{ name }}</strong></p>
      <p class="text-sm flex gap-3 mt-1 ml-1 break-all"  v-if="url" href="{{ url }}" target="_blank">
        <svg class="w-4 shrink-0 mt-0.5"><use href="#link"/></svg>
        {{ url }}
      </p>
      <a class="text-sm flex gap-3 mt-1 ml-1"  v-if="description" >
        <svg class="w-4 shrink-0 mt-0.5"><use href="#info"/></svg>
        {{ description }}
      </a>
      <ul v-if="errors" class="text-rose-500 mt-4 ml-1 text-sm">
        <li v-for="error in errors">{{ error[0] }}</li>
      </ul>
    </div>

    <div v-if="allowDeleting && isAboveTablet" class="flex gap-2 shrink-0 opacity-0 group-hover:opacity-100 duration-200">
      <Button @click.prevent.stop="editWish" icon="edit" size="lg"></Button>
      <Button @click.prevent.stop="emitDeleteWish" icon="delete" color="rose" size="lg"></Button>
    </div>
    <Dropdown v-if="allowDeleting && !isAboveTablet">
      <DropdownItem @click.prevent="editWish" icon="edit" text="Edit"></DropdownItem>
      <DropdownItem @click.prevent="emitDeleteWish" icon="delete" text="Delete"></DropdownItem>
    </Dropdown>
  </li>
</template>

<style lang="scss">
@media (hover: hover) {
  .wish-ok:hover .wish-name {
    @apply text-sky-500
  }

  .wish-ok:hover .wish-bullet {
    @apply  text-sky-600;
  }
}
</style>