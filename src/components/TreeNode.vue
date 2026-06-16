<template>
  <div class="k-tree-node">
    <button
      class="k-tree-node__row"
      :style="{ paddingLeft: indent + 'px' }"
      @click="$emit('navigate', node)"
    >
      <span class="k-tree-node__toggle" @click.stop="toggleExpand">
        <k-icon
          v-if="node.hasChildren"
          :type="expanded ? 'angle-down' : 'angle-right'"
        />
      </span>

      <span class="k-tree-node__icon">
        <k-icon :type="node.icon || 'page'" />
      </span>

      <span class="k-tree-node__title">{{ node.title }}</span>

      <span v-if="node.info" class="k-tree-node__info">{{ node.info }}</span>

      <span
        v-if="showStatus"
        class="k-tree-node__dot"
        :class="`k-tree-node__dot--${node.status}`"
        :title="node.status"
      />
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
    return { expanded: false };
  },

  computed: {
    indent() {
      return this.depth * 20;
    },
  },

  methods: {
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
  width: 100%;
  padding-top: 6px;
  padding-bottom: 6px;
  padding-right: 12px;
  background: none;
  border: none;
  cursor: pointer;
  color: var(--color-text);
  font-size: var(--text-sm, 0.875rem);
  text-align: left;
  white-space: nowrap;
  overflow: hidden;
  transition: background 0.1s;
}

.k-tree-node__row:hover {
  background: rgba(0, 0, 0, 0.04);
}

.k-tree-node__row:focus-visible {
  outline: 2px solid var(--color-focus, #4271ae);
  outline-offset: -2px;
}

.k-tree-node__toggle {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 20px;
  flex-shrink: 0;
  color: var(--color-text-light, #999);
}

.k-tree-node__icon {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 24px;
  flex-shrink: 0;
  margin-right: 6px;
  color: var(--color-text);
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
  overflow: hidden;
  text-overflow: ellipsis;
}

.k-tree-node__dot {
  width: 8px;
  height: 8px;
  border-radius: 50%;
  flex-shrink: 0;
  margin-left: 8px;
  transform: translateY(-1px);
}

.k-tree-node__dot--listed {
  background: #38a169;
}

.k-tree-node__dot--unlisted {
  background: linear-gradient(to right, #3182ce 50%, transparent 50%);
  border: 1.5px solid #3182ce;
  box-sizing: border-box;
}

.k-tree-node__dot--draft {
  background: transparent;
  border: 1.5px solid #e53e3e;
  box-sizing: border-box;
}
</style>
