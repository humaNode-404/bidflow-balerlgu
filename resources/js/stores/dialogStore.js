import { defineStore } from 'pinia';

export const newPRDialog = defineStore('newPRDialog', {
  state: () => ({
    isOpen: false,
  }),
  actions: {
    openDialog() {
      this.isOpen = true;
    },
    closeDialog() {
      this.isOpen = false;
    },
  },
  persist: {
    storage: localStorage,
  },
});

export const editUserDialog = defineStore('editUserDialog', {
  state: () => ({
    isOpen: false,
  }),
  actions: {
    openDialog() {
      this.isOpen = true;
    },
    closeDialog() {
      this.isOpen = false;
    },
  },
  persist: {
    storage: localStorage,
  },
});

export const createUserDialog = defineStore('createUserDialog', {
  state: () => ({
    isOpen: false,
  }),
  actions: {
    openDialog() {
      this.isOpen = true;
    },
    closeDialog() {
      this.isOpen = false;
    },
  },
  persist: {
    storage: localStorage,
  },
});
