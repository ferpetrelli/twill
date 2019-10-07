<template>
  <div class="fieldset" :class="visibilityClasses">

    <!-- Header (with title) -->
    <header v-if="title" class="fieldset__header" :class="activeClasses">
      <div class="fieldset__header-left">
        <h3 v-if="activeToggle" class="fieldset__header-title" @click="onClickVisibility" role="button" :aria-expanded="visible ?  'true' : 'false'" >{{ title}} <span v-svg symbol="dropdown_module"></span></h3>
        <h3 v-else class="fieldset__header-title">{{ title }}</h3>
      </div>
      <div v-if="links" class="fieldset__header-right">
        <a v-for="(link, key) in links" class="fieldset__header-link" :key="key" :href="link.href">
          <span class="f--underlined--o">{{ link.label }}</span>
        </a>
      </div>
    </header>

    <!-- Header (free slot) -->
    <header v-else="" class="fieldset__header" :class="activeClasses">
      <slot name="header"></slot>
    </header>

    <div class="fieldset__container" :hidden="!visible ?  true : null" :aria-hidden="!visible ?  true : null">

      <!-- Content -->
      <div class="fieldset__content">
        <slot></slot>
      </div>

      <!-- Footer -->
      <div v-if="action" class="fieldset__footer">
        <a17-button-action :label="action.label" :formId="action.form_id"/>
      </div>
    </div>

  </div>
</template>

<script>
  import A17ButtonAction from '@/components/ButtonAction.vue'
  import VisibilityMixin from '@/mixins/toggleVisibility'

  export default {
    name: 'A17Fieldset',
    components: {
      'a17-button-action': A17ButtonAction
    },
    mixins: [VisibilityMixin],
    props: {
      open: {
        type: Boolean,
        default: true
      },
      title: {
        default: ''
      },
      activeToggle: {
        type: Boolean,
        default: true
      },
      links: {
        type: Array,
        default: null
      },
      action: {
        type: Object,
        default: null
      }
    },
    computed: {
      activeClasses: function () {
        return { 'fieldset--hoverable': this.activeToggle }
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import '~styles/setup/_mixins-colors-vars.scss';

  .fieldset {
    border-radius: 2px;
    border: 1px solid $color__border;
    margin-bottom: 20px;
    background:$color__background;
  }

  .fieldset__header {
    position: relative;
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    height: 50px;
    margin: -1px;
    white-space: nowrap;
    background: $color__border;
    border-radius: 2px;

    h2, h3, h4 {
      height: 50px;
      line-height: 50px;
      padding: 1px 21px 0 21px;
      margin: 0;
      font-weight: 600;
      border-radius: 2px;
      user-select:none;
    }
  }

  .fieldset__header-left {
    flex: 1;
  }

  .fieldset__header-right {
    display: flex;
    flex-flow: row wrap;
  }

  .fieldset__header-title {
    position: relative;
    flex: 1;

    .icon {
      float: right;
      display: block;
      position: absolute;
      right: 20px;
      top: 50%;
      margin-top: -3px;
      color: $color__icons;
      transition: transform .25s linear;
    }
  }

  .fieldset__header-link {
    display: flex;
    flex-flow: row wrap;
    align-items: center;
    height: 50px;
    padding: 0 20px;
    text-decoration: none;
    border-left: 1px solid $color__fborder;

    .icon {
      margin-left: 5px;
    }

    &:hover,
    &:focus {
      background: $color__border--hover
    }
  }

  .fieldset__content {
    > h2,
    > h3,
    > h4 {
      font-size: 1em;
      font-weight: 600;
      margin-top: 35px;
    }

    > p {
      margin-top: 35px;
    }

    > hr {
      height: 5px;
      margin: 50px -20px 20px -20px;
      padding: 0;
      background: $color__border--light;
      border: 0 none;

      + .repeater {
        margin-top:20px;
      }
    }
  }

  .fieldset__content {
    padding: 0 20px 20px 20px;
    display: none;
  }

  .fieldset__footer {
    margin-top: 15px;
    padding: 21px;
    border-top: 5px solid $color__border--light;
  }

  /* Modifiers */

  .fieldset--hoverable {
    h2, h3, h4 {
      cursor: pointer;

      &:hover,
      &:focus {
        background: $color__border--hover
      }
    }
  }

  .s--open {
    .fieldset__header {
      margin-bottom: 0;
      border-radius: 2px 2px 0 0;

      h2, h3, h4 {
        border-radius: 2px 2px 0 0;
      }
    }

    .fieldset__header .icon {
      transform: rotate(180deg);
    }

    .fieldset__content {
      display: block;
    }
  }
</style>
