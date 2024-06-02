<template>
    <div v-if="show" class="modal-overlay" @click.self="close">
      <div class="modal-container">
        <div class="modal-header">
          <slot name="header">
            <h5 class="modal-title">Edit Car</h5>
          </slot>
          <button type="button" class="close" @click="close">
            <span>&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <slot name="body"></slot>
        </div>
        <div class="modal-footer">
          <slot name="footer"></slot>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    props: {
      show: {
        type: Boolean,
        required: true
      }
    },
    methods: {
      close() {
        this.$emit('close');
      }
    }
  };
  </script>
  
  <style scoped>
  .modal-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
  }
  .modal-container {
    background: white;
    padding: 20px;
    border-radius: 5px;
    width: 500px;
    max-width: 100%;
  }
  .modal-header,
  .modal-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
  }
  .modal-body {
    margin-top: 10px;
    margin-bottom: 10px;
  }
  .close {
    cursor: pointer;
  }
  </style>
  