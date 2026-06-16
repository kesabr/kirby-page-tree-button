<template>
  <div class="k-page-tree">
    <div v-if="config.search" class="k-page-tree__search">
      <input
        v-model="query"
        class="k-page-tree__search-input"
        :placeholder="$t('page-tree.search.placeholder') || 'Search pages…'"
        type="search"
      />
    </div>
    <template v-if="!loading && filteredPages.length">
      <k-tree-node
        v-for="page in filteredPages"
        :key="page.id"
        :node="page"
        :depth="0"
        :show-status="config.status !== false"
        @navigate="$emit('select', $event)"
      />
    </template>
    <p v-else-if="!loading" class="k-page-tree__empty">
      {{ $t('page-tree.search.empty') || 'No pages found.' }}
    </p>
  </div>
</template>

<script>
import TreeNode from './TreeNode.vue';

export default {
  name: 'k-page-tree',

  components: { 'k-tree-node': TreeNode },

  data() {
    return {
      loading: true,
      pages: [],
      config: { status: true, search: false, depth: null, info: null },
      query: '',
    };
  },

  computed: {
    filteredPages() {
      const q = this.query.trim().toLowerCase();
      if (!q) return this.pages;
      return this.filterNodes(this.pages, q);
    },
  },

  mounted() {
    this.load();
  },

  methods: {
    async load() {
      try {
        const response = await this.$api.get('page-tree/pages');
        this.pages = response.pages;
        this.config = response.config;
      } finally {
        this.loading = false;
      }
    },

    filterNodes(nodes, query) {
      return nodes.reduce((acc, node) => {
        const filteredChildren = this.filterNodes(node.children || [], query);
        const matchesSelf = node.title.toLowerCase().includes(query);
        if (matchesSelf || filteredChildren.length) {
          acc.push({
            ...node,
            children: matchesSelf ? (node.children || []) : filteredChildren,
          });
        }
        return acc;
      }, []);
    },
  },
};
</script>

<style>
.k-page-tree__search {
  padding: 0.5rem 0.75rem;
  border-bottom: 1px solid var(--color-border, rgba(0, 0, 0, 0.1));
}

.k-page-tree__search-input {
  width: 100%;
  padding: 0.3rem 0.5rem;
  border: 1px solid var(--color-border, rgba(0, 0, 0, 0.15));
  border-radius: var(--rounded, 0.25rem);
  background: var(--color-white, #fff);
  color: var(--color-text, #1a1a1a);
  font-size: var(--text-sm, 0.8125rem);
  outline: none;
  box-sizing: border-box;
}

.k-page-tree__search-input:focus {
  border-color: var(--color-focus, #4271ae);
  box-shadow: 0 0 0 2px rgba(66, 113, 174, 0.15);
}

.k-page-tree__empty {
  padding: 0.75rem 1rem;
  color: var(--color-text-dimmed, #999);
  font-size: var(--text-sm, 0.8125rem);
  text-align: center;
  margin: 0;
}
</style>
