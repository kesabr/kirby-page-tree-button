<template>
  <div ref="wrapper" class="k-page-tree-button">
    <k-button
      icon="menu"
      :text="buttonLabel"
      :dropdown="true"
      @click="toggle"
    />
    <div v-show="isOpen" class="k-page-tree-dropdown" @click.stop>
      <k-page-tree @select="navigate" />
    </div>
  </div>
</template>

<script>
export default {
  name: 'k-page-tree-button',

  data() {
    return { isOpen: false };
  },

  computed: {
    buttonLabel() {
      return this.$t('page-tree.button.label') || 'All pages';
    },
  },

  mounted() {
    document.addEventListener('click', this.onClickOutside);
  },

  beforeUnmount() {
    document.removeEventListener('click', this.onClickOutside);
  },

  methods: {
    toggle() {
      this.isOpen = !this.isOpen;
    },

    navigate(node) {
      this.isOpen = false;
      this.$panel.view.open(this.$api.pages.url(node.id));
    },

    onClickOutside(event) {
      if (this.$refs.wrapper && !this.$refs.wrapper.contains(event.target)) {
        this.isOpen = false;
      }
    },
  },
};
</script>

<style>
.k-page-tree-button {
  position: relative;
}

.k-page-tree-dropdown {
  position: absolute;
  top: calc(100% + 4px);
  right: 0;
  z-index: 999;
  min-width: 260px;
  max-height: 70vh;
  overflow-y: auto;
  background: var(--color-background);
  color: var(--color-text);
  border-radius: var(--dropdown-rounded, var(--rounded));
  box-shadow: var(--dropdown-shadow);
  padding: 0.5rem 0;
}
</style>
