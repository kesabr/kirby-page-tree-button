<template>
  <div class="k-tree-node">
    <button
      class="k-tree-node__row"
      :style="{ paddingLeft: indent + 'px' }"
      @click="handleClick"
    >
      <span
        class="k-tree-node__toggle"
        :class="{ 'k-tree-node__toggle--visible': node.hasChildren }"
        @click.stop="toggleExpand"
      >
        <k-icon
          v-if="node.hasChildren"
          :type="expanded ? 'angle-down' : 'angle-right'"
        />
      </span>

      <span
        v-if="showStatus"
        class="k-tree-node__dot"
        :class="`k-tree-node__dot--${node.status}`"
        :title="$t('page-tree.status.' + node.status) || node.status"
      />

      <span class="k-tree-node__title">{{ node.title }}</span>

      <span v-if="node.info" class="k-tree-node__info">{{ node.info }}</span>
    </button>

    <template v-if="expanded && node.hasChildren">
      <k-tree-node
        v-for="child in node.children"
        :key="child.id"
        :node="child"
        :depth="depth + 1"
        :show-status="showStatus"
        @navigate="$emit('navigate', $event)"
      />
    </template>
  </div>
</template>

<script>
export default {
  name: 'k-tree-node',

  props: {
    node: {
      type: Object,
      required: true,
    },
    depth: {
      type: Number,
      default: 0,
    },
    showStatus: {
      type: Boolean,
      default: true,
    },
  },

  emits: ['navigate'],

  data() {
    return {
      expanded: false,
    };
  },

  computed: {
    indent() {
      return 12 + this.depth * 16;
    },
  },

  methods: {
    handleClick() {
      if (this.node.hasChildren) {
        this.toggleExpand();
      } else {
        this.$emit('navigate', this.node);
      }
    },

    toggleExpand() {
      if (this.node.hasChildren) {
        this.expanded = !this.expanded;
      }
    },
  },
};
</script>

<style>
.k-tree-node__row {
  display: flex;
  align-items: center;
  gap: 6px;
  width: 100%;
  padding-top: 5px;
  padding-bottom: 5px;
  padding-right: 12px;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--color-text);
  font-size: var(--text-sm, 0.8125rem);
  text-align: left;
  white-space: nowrap;
  overflow: hidden;
  transition: background 0.1s;
}

.k-tree-node__row:hover {
  background: rgba(0, 0, 0, 0.05);
}

.k-tree-node__row:focus-visible {
  outline: 2px solid var(--color-focus, #4271ae);
  outline-offset: -2px;
}

.k-tree-node__toggle {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 16px;
  flex-shrink: 0;
  color: var(--color-text-light, #999);
}

.k-tree-node__toggle:not(.k-tree-node__toggle--visible) {
  pointer-events: none;
}

.k-tree-node__dot {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  flex-shrink: 0;
}

.k-tree-node__dot--listed {
  background: var(--color-positive-on-light, #3d9970);
}

.k-tree-node__dot--unlisted {
  background: var(--color-notice-on-light, #f0ad4e);
}

.k-tree-node__dot--draft {
  background: var(--color-text-light, #aaa);
}

.k-tree-node__title {
  flex: 1;
  min-width: 0;
  overflow: hidden;
  text-overflow: ellipsis;
  white-space: nowrap;
}

.k-tree-node__info {
  flex-shrink: 0;
  color: var(--color-text-light, #999);
  font-size: var(--text-xs, 0.75rem);
  padding-left: 8px;
}
</style>
