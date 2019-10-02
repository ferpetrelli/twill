<template>
  <a17-button type="button" variant="action" :disabled="loading" @click="clickHandler">
    {{ label }}
  </a17-button>
</template>

<script>
  import { NOTIFICATION } from '@/store/mutations'

  export default {
    name: 'A17ButtonAction',
    props: {
      label: {
        type: String,
        default: null
      },
      formId: {
        type: String,
        default: null,
        required: true
      }
    },
    data () {
      return {
        loading: false
      }
    },
    methods: {
      clickHandler () {
        // Get form inside page.
        const form = document.querySelector(`#${this.formId}`)

        // If form doesn't exist.
        if (!form) {
          console.error(`Form with id '${this.formId}' does not exist in the page.`)
          return
        }

        // Get data.
        this.getData(form)
      },
      getData (form) {
        // Init data object.
        let data = {}

        // Get fields inside form.
        const fields = form.querySelectorAll('input', 'checkbox', 'radio', 'textarea', 'select')

        // Loop through each field.
        Array.from(fields).map(field => {
          data[field.name] = field.value
        })

        // Turn button into loading state.
        this.loading = true

        // Get data.
        this.sendRequest(form, data)
      },
      sendRequest (form, data) {
        const self = this

        // Get form action.
        const formAction = form.getAttribute('action')

        // If form doesn't has an action attribute.
        if (!formAction) {
          console.error(`Attribute 'action' is missing on your form`)
          return
        }

        // Launch request.
        this.$http.post(formAction, {
          params: data
        }).then(function (resp) {
          self.loading = false
          self.$store.commit(NOTIFICATION.SET_NOTIF, {
            message: 'Your request has been send successfully.',
            variant: 'success'
          })
        }, function (resp) {
          self.loading = false
          self.$store.commit(NOTIFICATION.SET_NOTIF, {
            message: 'Error during request.',
            variant: 'error'
          })
        })
      }
    }
  }
</script>

<style lang="scss" scoped>
  @import '~styles/setup/_mixins-colors-vars.scss';
</style>
