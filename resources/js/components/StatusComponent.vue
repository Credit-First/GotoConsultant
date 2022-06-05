<template>
<div v-if="curUser">
  <label :class="[curUser.status == 'available' ? 'available' : curUser.status == 'offline' ? 'offline' : 'busy']" v-if="curUser && !is_mobile">
    {{curUser.status}}
  </label>
  <label :class="[curUser.status == 'available' ? 'available' : curUser.status == 'offline' ? 'offline' : 'busy']" v-else></label>
</div>
</template>

<script>
  import { isMobile } from "mobile-device-detect";
  export default {
    name: "status-component",
    props: {
      userProfile: {
        type: Object,
        required: true
      }
    },
    data() {
      return {
        curUser: null,
        is_mobile: false
      }
    },
    mounted() {
      this.is_mobile = isMobile ? true : false;
      this.curUser = this.userProfile;
      Echo.private('status').listen('UserStatus', (e) => {
        if (this.curUser.id == e.id) {
          this.curUser.status = e.status;
        }
      });
      this.$socket.onopen = () => {
        this.$socket.onmessage = data => {
          var msg = JSON.parse(data.data);
          if (msg.type != "token" && msg.type != "request" && this.curUser.id == msg.id) {
            self.curUser.status = msg.status;
          }
        };
      };
    }
  };
</script>