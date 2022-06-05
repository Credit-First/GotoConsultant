<template>
  <div class="full-chat-section">
    <vue-loader :active.sync="isLoading" :is-full-page="true" />
    <div class="chat-left" v-if="contactedUsers.length > 0">
      <h2>{{ $t('member.my-sessions') }}
      </h2>
      <div
        :class="[user.user_id === current_user.user_id ? 'chat-model active' : 'chat-model']"
        v-for="user in contacted_users"
        :key="user.id"
        v-on:click="selectChannel(user, 'selecting')"
      >
<!--          user.user_id::{{ user.user_id}}<br>-->
<!--          user.id::{{ user.id}}<br>-->
<!--          current_user.user_id::{{ current_user.user_id}}<br>-->

          <div class="chat-icon" :style="{ 'background-image': 'url(' + user.profile.avatar + ')' }" v-if="user.profile != null && user.profile.avatar != '' && user.profile.avatar != undefined"></div>
        <div class="chat-icon" v-else>
            <span class="numberCircleRaised consultant" v-if="user.sender_total">{{user.sender_total}}</span>
            <label>{{user.user.first_name[0]}}{{user.user.last_name[0]}}</label>
        </div>
        <div
          :class="[user.user.status == 'available' ? 'chat-details' : user.user.status == 'offline' ? 'chat-details offline' : 'chat-details busy']"
        >

          <span class="numberCircleRaised consultant" v-if="user.sender_total">{{user.sender_total}}</span>
          <label>
            {{user.user.first_name}} {{user.user.last_name}}
            <span>{{ $t(`member.${user.user.status}`) }}</span>
          </label>
          <legend
            v-if="user.profile && user.profile.profession"
          >{{ $t(`member.${user.profile.profession}`) }}</legend>
        </div>
      </div>
    </div>
    <div class="select-box"  v-if="!is_selected">
      <div class="step">
        <img src="/images/mascot.svg" alt="no-image" />
        <div v-if="contactedUsers.length > 0">
          <label>{{ $t('member.no-customers') }}</label>
          <p class="text">{{ $t('member.no-customers-des') }}</p>
        </div>
        <div v-else>
          <label>
            {{ $t('member.no-session')}}
          </label>
          <p class="text">{{ $t('member.no-session-des')}}</p>
          <button class="btn-pink" v-on:click="goToFindConsult()">{{ $t('about.find_consult') }}</button>
        </div>
      </div>
    </div>
    <div class="chat-room" v-else>
      <div class="chat-right">
        <div class="chat-profile">
          <div class="end-chat-right">
            <div class="timer">
              <img src="/images/timer.svg" />
              <p class="m-0 pl-1">
                <b>{{toHHMMSS(time_clock)}}</b>
              </p>
            </div>
            <div class="btn-group">
              <button class="btn-session start" v-on:click="startSession()" v-if="!is_session && current_user.user.role !== 'customer' && current_user.user.status =='available'">{{ $t('member.start_session') }}</button>
              <div class="btn-session-group" v-else-if="is_session">
                <button class="btn-session pause" v-on:click="pauseSession()" v-if="!is_paused">{{ $t('member.pause_session') }}</button>
                <button class="btn-session pause" v-on:click="continueSession()" v-else>{{ $t('member.continue_session') }}</button>
                <button class="btn-session end" v-on:click="endSession()">{{ $t('member.end_session') }}</button>
                <button class="btn-image" v-if="current_user.user.role !== 'customer'" v-on:click="startCall()"><img src="/images/call-session.svg" alt="voice"/></button>
                <button class="btn-image" v-if="current_user.user.role !== 'customer'" v-on:click="startVideo()"><img src="/images/video-session.svg" alt="video"/></button>
              </div>
              <button class="btn-image" v-on:click="showSetting()" v-if="!is_setting"><img src="/images/user-profile.svg" alt="setting"/></button>
            </div>
          </div>
        </div>
        <div class="chat-history" id="scroll-view" v-if="messages.length > 0">
          <div class="chat-list" v-for="(message, index) in messages" v-bind:key="message.index">
            <div class="date-separate" v-if="index == 0">
              <legend>
                <span>{{ message.timestamp.toDateString() == today ? 'Today': dateTranslationFormt(message.timestamp.toDateString()) }}</span>
              </legend>
            </div>
            <div
              class="date-separate"
              v-else-if="index > 0 && messages[index-1].timestamp.toDateString() !== message.timestamp.toDateString()"
            >
              <legend>
                <span>{{ message.timestamp.toDateString() == today ? 'Today': dateTranslationFormt(message.timestamp.toDateString()) }}</span>
              </legend>
            </div>
            <div class="self" v-if="message.author === authUser.user.email">
              <label>{{ message.timestamp.toLocaleTimeString() }}</label>
              <div class="identity">
                <p>{{ message.body }}</p>
                <div :style="{'background-image': 'url(' + authUser.profile.avatar + ')'}" v-if="authUser.profile && authUser.profile.avatar"></div>
                <b v-else>{{authUser.user.first_name[0]}}{{authUser.user.last_name[0]}}</b>
              </div>
            </div>
            <div class="other" v-if="message.author != authUser.user.email">
              <label>{{ message.timestamp.toLocaleTimeString() }}</label>
              <div class="identity">
                <div :style="{'background-image': 'url(' + current_user.profile.avatar + ')'}" v-if="current_user.profile && current_user.profile.avatar"></div>
                <b
                  v-else-if="current_user.user"
                >{{current_user.user.first_name[0]}}{{current_user.user.last_name[0]}}</b>
                <p>{{ message.body }}</p>
              </div>
            </div>
          </div>
          <div class="rate-session">
            <div class="date-separate" v-if="time_clock <= 15 && time_clock > 0">
              <legend>
                <span>{{ $t('member.session-end-alert') }}</span>
              </legend>
            </div>
            <div class="date-separate" v-if="time_clock == 0 && is_session">
              <legend>
                <span>{{ $t('member.chat-end') }}</span>
              </legend>
            </div>
          </div>
        </div>
        <div class="no-chat-history" v-else>
          <div class="no-chat-alert-box">
            <img src="/images/mascot.svg" alt="no-image" />
            <label>
              {{ $t('member.no-chat-history')}}
            </label>
            <p>{{ $t('member.no-chat-history-des1')}} {{current_user.user.first_name}} {{ $t('member.no-chat-history-des2')}}</p>
          </div>
        </div>
        <div class="write-text">
          <span>
            <input
              type="text"
              :placeholder="$t('member.write-message')"
              v-model="newMessage"
              @keyup.enter="sendMessage"
            />
          </span>
          <div class="send-msg">
            <button class="btn" v-on:click="sendMessage()">{{ $t('member.send') }}</button>
            <!-- <input type="checkbox" id="fruit1" name="fruit-1" value="Apple" />
            <label id="sms" for="fruit1">{{ $t('member.sms') }}</label>
            <input type="checkbox" id="fruit4" name="fruit-4" value="Strawberry" />
            <label id="inapp" for="fruit4">{{ $t('member.in_app') }}</label> -->
          </div>
        </div>
      </div>
    </div>
    <div class="drawer-pane">
      <!-- <vue-drawer @close="handleClose('setting')" align="right" :closeable="true"> -->
        <div class="chatter-pro" v-if="is_setting">
          <div class="chatter-setting">
            <button type="button" class="close" aria-label="Close" v-on:click="handleClose('setting')">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div
            :class="[current_user.user.status == 'available' ? 'rate-session chat-setting' : current_user.user.status == 'offline' ? 'rate-session offline' : 'rate-session busy']"
          >
            <div class="chat-icon" v-on:click="goProfile()" :style="{ 'background-image': 'url(' + current_user.profile.avatar + ')' }" v-if="current_user.profile != null && current_user.profile.avatar != '' && current_user.profile.avatar != undefined">
              <span v-if="current_user.company && current_user.user.role === 'consultant'"><img src="/images/mortarboard-w.svg" alt="no-img" /></span>
            </div>
            <div class="chat-icon" v-on:click="goProfile()" v-else>
              <span v-if="current_user.company && current_user.user.role === 'consultant'"><img src="/images/mortarboard-w.svg" alt="no-img" /></span>
              <label>{{current_user.user.first_name[0]}}{{current_user.user.last_name[0]}}</label>
            </div>
            <span :class="[current_user.user.status == 'available' ? 'absol-span consultant available' : current_user.user.status == 'offline' ? 'absol-span consultant offline' : 'absol-span consultant busy']">&#8226;</span>
            <p
              v-if="current_user.profile && current_user.profile.profession"
            >{{current_user.profile.profession}}</p>
            <h2>{{current_user.user.first_name}} {{current_user.user.last_name}}</h2>
            <small v-if="current_user.user.role === 'consultant'">{{current_user.currency}} {{current_user.hourly_rate}} p/m</small><small v-else></small>
            <vue-custom-rate :_rate="current_user.rate ? parseInt(current_user.rate) : 0" :_type="'static'"></vue-custom-rate>
          </div>
          <div class="chat-records">
            <div class="records-left">
              <label>{{current_user.completed_sessions > 0 ? current_user.completed_sessions : 0}}</label>
              <span>{{ $t('member.sessions') }}</span>
            </div>
            <div class="records-right">
              <label>30 min</label>
              <span>{{ $t('member.last-online') }}</span>
            </div>
          </div>
          <div class="chat-drop">
            <vue-accordion
              title-bg-color="#f0f0f0"
              title-color="#424874"
              title-hover-color="#6983aa80"
              accordion-width="600px"
              :datas="[{title: $t('member.details'), content: current_user.profile.description }, {title: $t('member.ratings'), content: ratingContent}]"
            />
          </div>
        </div>
      <!-- </vue-drawer> -->
    </div>
    <!-- Incoming -->
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('incoming_voice')" v-show="is_incomingCall_modal"  class="incoming-call">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + incoming_user.prof_image + ')'}" v-if="incoming_user.prof_image != '' && incoming_user.prof_image != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <p><span>{{incoming_user.name}}</span><br/>{{ $t('member.incoming-call') }}</p>
      </div>
      <div class="modal-footer">
        <button class="img_btn" type="button" v-on:click="handleClose('incoming_voice')">
          <img src="/images/home/hang-up.svg" />
        </button>
        <button class="img_btn" type="button" v-on:click="acceptIncomingCall()">
          <img src="/images/home/ph.svg" />
        </button>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('incoming_video')" v-show="is_incomingVideo_modal"  class="incoming-call">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + incoming_user.prof_image + ')'}" v-if="incoming_user.prof_image != '' && incoming_user.prof_image != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <p><span>{{incoming_user.name}}</span><br/>{{ $t('member.incoming-video')}}</p>
      </div>
      <div class="modal-footer">
        <button class="img_btn" type="button" v-on:click="handleClose('incoming_video')">
          <img src="/images/home/hang-up.svg" />
        </button>
        <button class="img_btn" type="button" v-on:click="acceptIncomingVideoCall()">
          <img src="/images/home/video.svg" />
        </button>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('incoming_session')" v-show="is_incomingSession_modal" class="incoming-session">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + incoming_user.prof_image + ')'}" v-if="incoming_user.prof_image != '' && incoming_user.prof_image != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <h2>{{ $t('member.incoming-session') }}</h2>
        <p>{{ $t('member.incoming-session-des') }} {{incoming_user.name}}</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="decline" v-on:click="sessionReject()">
          {{$t('member.decline')}}
        </button>
        <button type="button" class="accept" v-on:click="sessionAccept()">
          {{$t('member.accept')}}
        </button>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('call')" v-show="is_call_modal" class="call" :class="{fullscreen: isFullscreen}">
      <div class="modal-header">
        <div class="time-status">
          <img src="/images/timer.svg" />
          <p>{{toHHMMSS(time_clock)}}</p>
        </div>
        <div class="right-end">
          <button class="pause" v-on:click="pauseSession()" v-if="!is_paused">{{ $t('member.pause_session') }}</button>
          <button class="continue" v-on:click="continueSession()" v-else>{{ $t('member.continue_session') }}</button>
          <button class="end" v-on:click="endSession()">{{ $t('member.end_session') }}</button>
        </div>
      </div>
      <div class="modal-body">
        <div ref="video_tag" class="main" id="remote_video">
          <div ref="videoPreview" id="videoPreview"></div>
          <div ref="audioPreview" id="audioPreview"></div>
        </div>
        <div ref="self_video_tag" class="self" id="self_video"></div>
        <div class="btn-group">
          <button type="button" v-on:click="handlingCallMode('audio')"><img src="/images/home/voice-available.svg" v-if="is_call_mode" /><img src="/images/home/voice-unavailable.svg" v-else /></button>
          <button type="button" v-on:click="handlingCallMode('video')"><img src="/images/home/video-available.svg" v-if="is_video_mode" /><img src="/images/home/video-unavailable.svg" v-else /></button>
          <button type="button" ref="stopScreenShareRef" v-on:click="handlingShareMode"><img src="/images/home/screen-share-available.svg" v-if="is_share_mode" /><img src="/images/home/screen-share-unavailable.svg" v-else /></button>
          <button type="button" v-on:click="isFullscreen = !isFullscreen"><img src="/images/fullscreen.png" /></button>
          <button type="button" v-on:click="handleClose('call')"><img src="/images/hang-up.svg" /></button>
        </div>
      </div>
    </drag-dialog>
    <!-- Outgoing -->
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('session')" v-show="is_session_modal" class="session">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_user.profile.avatar + ')'}" v-if="current_user.profile && current_user.profile.avatar != '' && current_user.profile.avatar != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <h2>{{ $t('member.session-end-modal') }}</h2>
        <p>{{ $t('member.session-end-modal-des') }}</p>
      </div>
      <div class="modal-footer">
        <button
          class="btn accept"
          v-on:click="continueSession()"
        >{{ $t('member.btn-no') }}</button>
        <button
          class="btn decline"
          v-on:click="handleSessionEnd()"
        >{{ $t('member.btn-yes') }}</button>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('progress')" v-show="is_progress_modal" class="connect">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_user.profile.avatar + ')'}" v-if="current_user.profile && current_user.profile.avatar != '' && current_user.profile.avatar != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <h2>{{ $t('member.progress-start') }}</h2>
        <p>{{ $t('member.progress-start-des') }} {{current_user.user.first_name}}</p>
      </div>
      <div class="modal-footer">
        <div class="btn" v-if="progress === 'connect'">
          <h3>{{$t('member.connecting')}}</h3>
          <vue-loading :color="'#fff'"></vue-loading>
        </div>
        <div class="btn notAnswered" v-else-if="progress === 'notAnswered'" v-on:click="handleCloseProgress()">
          <h3>{{$t('member.no_answer')}}</h3>
        </div>
        <div class="btn decline" v-else v-on:click="handleCloseProgress()">
          <h3>{{$t('member.declined')}}</h3>
        </div>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('review')" v-show="is_review_modal" class="review">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_user.profile.avatar + ')'}" v-if="current_user.profile && current_user.profile.avatar != '' && current_user.profile.avatar != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <div class="content">
          <h2>{{ $t('member.rate-session') }}</h2>
          <vue-custom-rate v-model="rate" :_type="'dynamic'"></vue-custom-rate>
          <textarea v-model="review_des" :placeholder="$t('member.write-review-msg')"></textarea>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn review" v-on:click="submitReview()" >{{ $t('member.submit-review') }}</button>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('payment')" v-show="is_payment_modal" class="payment">
      <div class="modal-body">
        <div class="avatar icon" :style="{'background-image': 'url(/images/earnings-icon.svg)'}"></div>
        <div class="content">
          <h2>{{ $t('member.start-session-dialog') }}</h2>
          <p>
            <b>{{ $t('member.account-balance')}} {{balance}}</b>
          </p>
          <p>{{ $t('member.balance-charge-question')}}</p>
          <div :class="[$v.form.$error ? 'hasError input-box': 'input-box']">
            <input type="text" v-model="form.minute" v-on:change="minuteChange" />
            <label>min</label>
          </div>
          <p class="total">
            {{ $t('member.total-cost')}}:
            <b>{{formatted_cost}}</b>
          </p>
        </div>
      </div>
      <div class="modal-footer">
        <button class="btn review" v-on:click="startMethod()" :disabled="authUser.user.balance == 0">{{ $t('member.start-session') }} <vue-loading :color="'#fff'" v-if="is_progress_loading"/></button>
      </div>
    </drag-dialog>
     <drag-dialog :options="{ buttonPin:false }" @close="handleClose('pause')" v-show="is_pause_modal" class="pause">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_user.profile.avatar + ')'}" v-if="current_user.profile && current_user.profile.avatar != '' && current_user.profile.avatar != undefined"></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <h2>{{ $t('member.session-pause-modal') }}</h2>
        <p>{{ $t('member.session-pause-modal-des1') }} {{current_user.user.first_name}} {{ $t('member.session-pause-modal-des2')}}</p>
      </div>
      <div class="modal-footer">
        <button class="btn decline" v-on:click="handleClose('pause')">{{$t('member.close')}}</button>
      </div>
    </drag-dialog>
  </div>
</template>

<script>
// import axios from "../Http";
import VueAccordion from "accordion-vue";
import StarRate from "vue-cute-rate";
import Loading from 'vue-loading-overlay';
import moment from "moment";
import Drawer from "vue-simple-drawer";
import DialogDrag from 'vue-dialog-drag';
import { Device } from "twilio-client";
import { required, minValue } from "vuelidate/lib/validators";
import { isMobile } from "mobile-device-detect";
import EllipsisLoader from './Loader';
import CustomStarRating from './CustomRating';
import {
  muteYourAudio,
  unmuteYourAudio,
  muteYourVideo,
  unmuteYourVideo,
  participantMutedOrUnmutedMedia
} from '../helpers/local-media-controls';
import { createScreenTrack } from "../helpers/screenshare";

const Video = require("twilio-video");
const {
  connect,
  createLocalTracks,
  createLocalVideoTrack
} = require("twilio-video");
window.$ = window.jQuery = require('jquery')

export default {
  name: "consultant-component",
  components: {
    "vue-start-rate": StarRate,
    "vue-custom-rate": CustomStarRating,
    "vue-accordion": VueAccordion,
    "vue-loading": EllipsisLoader,
    "vue-loader": Loading,
    "vue-drawer": Drawer,
    "drag-dialog": DialogDrag
  },
  props: {
    lang: {
      type: Object,
      required: true
    },
    consultants: {
      type: Array,
      required: true
    },
    customers: {
      type: Array,
      required: true
    },
    authUser: {
      type: Object,
      required: true
    },
    selectedId: {
      type: Number,
      required: true
    },
    contactedUsers: {
      type: Array,
      required: true
    },
    accessKey: {
      type: Object,
      required: true
    },
    findRoute: {
      type: Object,
      required: true
    }
  },
  data() {
    return {
      is_outgoing: false, // if consultant start session himself
      is_mobile: false, // show if mobile is detected
      is_paused: false, // session is paused or not
      is_session: false, // session started or not
      isLoading: false, // loading screen active
      is_progress_modal: false, // progress modal
      is_minus_balance: false, // balance validation
      is_selected: false, // user is selected or not
      is_setting: false, // detail view is shown
      is_call_modal: false, // call interface
      is_session_modal: false, // if session end button is clicked
      is_review_modal: false, // review modal
      is_payment_modal: false, // payment process modal
      is_progress_loading: false, // outgoing request modal
      is_incomingCall_modal: false, // voice call interface
      is_incomingVideo_modal: false, // get video call request
      is_incomingSession_modal: false, // get session request
      is_pause_modal: false, // session pause modal
      is_call_mode: false,
      is_video_mode: false,
      is_share_mode: false,
      messages: [],
      users: [],
      all_users: [],
      contacted_users: [],
      progress: "connect",
      device: new Device(),
      device_connection: null,
      roomName: null,
      activeRoom: null,
      interval: null,
      time_clock: 0,
      cost: 0,
      rate: 0,
      newMessage: null,
      channel: null,
      ratingContent: "",
      review_des: null,
      balance: null,
      formatted_cost: null,
      today: null,
      incoming_audio: null,
      outgoing_audio: null,
      isFullscreen: false,
      incoming_user: {
        id: "",
        name: "",
        request_min: "",
        prof_image: "",
        min: ""
      },
      current_user: {
        user: {
          first_name: "",
          last_name: "",
        },
        profile: {}
      },
      form: {
        minute: 0
      },
    };
  },
  validations: {
    form: {
      minute: { required, min: minValue(1) }
    }
  },
  mounted() {
    console.log("consultant chat service started!");
    this.is_mobile = isMobile ? true : false;
    this.today = moment(new Date()).format("ddd MMM DD YYYY");
    this.balance = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(this.authUser.user.balance).replace('kr', 'NOK');
    this.users = [...this.customers];
    this.contacted_users = [...this.contactedUsers];
    this.consultants.forEach((consultant) => {
      if (consultant.id != this.authUser.id) {
        this.users.push(consultant);
      }
    });
    this.all_users = [...this.users];
    this.all_users.push(this.authUser);
    this.setStatus("available");
    let self = this;

    // set Twilio Call Client with own name token
    this.initializeCallClient();

    if (this.selectedId != 0) {
      const user = this.users.find(element => parseInt(element.user_id) === this.selectedId);
      this.selectChannel(user, 'selecting');
    }
    // get call incoming event
    this.device.incoming(function(connection) {
      var type = connection.customParameters.get("type");
      self.roomName = connection.customParameters.get("roomName");
      self.device_connection = connection;
      console.log("device incoming connection - origin: ", connection);
      if (type == "voice") {
        self.is_incomingCall_modal = true;
      } else {
        self.is_incomingVideo_modal = true;
      }
    });
    // get call disconnect event
    this.device.disconnect(function(connection) {
      self.is_incomingCall_modal = false;
    });
    this.device.connect(function(connection) {
      console.log("device connected");
      // self.is_incomingCall_modal = false;
      // self.device.disconnectAll();
    });
    this.device.ready(function(device) {
      console.log("Ready");
    });
    this.device.error(function(error) {
      console.error("ERROR: " + error.message);
      if (error.code == "31205") {
        self.initializeCallClient();
      }
    });

    this.$socket.onopen = () => {
      this.$socket.onmessage = data => {
        var msg = JSON.parse(data.data);
        console.log(msg);
        if (msg.type == "token") {

          self.voice_token_name = msg.token;

        } else if (msg.type == "request") {

          if (!msg.sub_type && msg.name == "accepted") {
            self.stopAudio("outgoing");
            self.time_clock = Number(self.form.minute) * 60; // set time count value
            self.progress = "connected";
            self.is_progress_modal = false; // open connecting progress modal
            self.is_session = true; // let user can't select other consultant from the list
            self.is_outgoing = true;
            self.startTimer(); // start time interval
            // process the transaction if the consultant accept the session request
            axios.post("/api/manage_transaction", {
              id: self.authUser.user.id,
              cost: self.cost,
              time: self.form.minute,
              consultant_id: self.current_user.user_id
            }).then(res => {
              self.form.minute = 0;
              self.cost = 0;
              self.balance = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(res).replace('kr', 'NOK'); // update balance into new reducted value
            });
          } else if (!msg.sub_type && msg.name == "rejected") {
            self.stopAudio("outgoing");
            self.progress = "declined"; // update progress modal status
            self.is_session = false;
          } else {
            self.incoming_user.id = msg.id;
            self.incoming_user.name = msg.name;
            self.incoming_user.min = msg.min;
            self.incoming_user.prof_image = msg.image;
            if (msg.sub_type == "session_start") { // get session start request from customer
              axios.post("/api/add_request", {
                customer_id: msg.id,
                consultant_id: self.authUser.id
              }).then((res) => {
                console.info("request updated successfully");
              });
              if (Object.keys(self.current_user.profile).length > 0) { // if consultant selected incoming customer
                self.is_incomingSession_modal = true; // show incoming session modal
                self.playAudio("incoming");
                self.time_clock = self.incoming_user.min * 60; // set time clock to incoming user's request time
              } else { // if consultant didn't select incoming user before then select incoming user manually
                const user = self.users.find(element => parseInt(element.user_id) === msg.id);
                self.selectChannel(user, "incoming");
              }
            } else if (msg.sub_type == "session_pause") {
              self.is_paused = true; // if opponent pause session, then set session pause
              self.is_pause_modal = true;
            } else if (msg.sub_type == "session_continue") {
              self.is_paused = false; // if opponent continue session, then set session continue
              self.is_pause_modal = false;
              self.interval = setInterval(function() {
                if (self.time_clock > 0 && !self.is_paused) { // decrease time counter to zero unless session isn't paused
                  self.time_clock--;
                } else {
                  clearInterval(self.interval);
                }
              }, 1000);
            } else if (msg.sub_type == "session_end") { // if opponent end session
              clearInterval(self.interval);
              self.setStatus("available");
              self.sendStatusSocket("available");
              self.is_session = false;
              self.is_pause_modal = false;
              self.is_call_modal = false;
              self.is_review_modal = true;
              self.incoming_user = {};
            } else if (msg.sub_type == "session_cancel") { // if opponent cancel session
              self.stopAudio("incoming");
              self.is_incomingSession_modal = false;
              self.incoming_user = {};
            } else if (msg.sub_type == "video_call_start") {
              self.is_incomingVideo_modal = true
            }
          }

        } else {

          const index = self.users.findIndex(element => parseInt(element.user_id) === parseInt(msg.id));
          if (index > -1) {
            self.users[index].user.status = msg.status;
          } else {
            // add a newly registered user
            axios.post("/api/find_new_registered_user", {
              id: msg.id
            }).then((res) => {
              self.users.push(res.data);
            });
          }

        }
      };
      this.$socket.sendObj({ command: "subscribe", channel: this.authUser.user.id });
    };

    Echo.private('status').listen('UserStatus', (e) => {
      this.contacted_users.forEach((sel) => {
        if (sel.user.id == e.id) {
          sel.user.status = e.status;
          console.log("update user's status: ", e.status);
        }
      });
    });

    window.addEventListener('click', this.handleClickEvent);
  },
  methods: {
    // initiate voice call twilio client
    async initializeCallClient() {
      axios
        .post("/api/call_token", {
          name: this.authUser.user.first_name + this.authUser.user.last_name
        })
        .then(res => {
          this.device.setup(res.data.token, { debug: true });
        });
    },
    // initiate video twilio client
    async initializeVideoClient() {
      await axios
        .post("/api/create_room", {
          name: `videoRoom-${this.current_user.user.id}-${this.authUser.user.id}`
        })
        .then(res => {
          console.log(res);
        });
    },
    // get video token
    async fetchVideoToken() {
      const { data } = await axios.post("/api/video_token", {
        userName:
          this.authUser.user.first_name + this.authUser.user.last_name,
        roomName: `videoRoom-${this.current_user.user.id}-${this.current_user.user.id}`
      });
      return data.token;
    },

    // get chat token
    async fetchChatToken() {
      const { data } = await axios.post("/api/chat_token", {
        email: this.authUser.user.email
      });
      return data.token;
    },
    // initiate chat twilio client after user select consultant
    async initializeChatClient(token, id, channel) {
      const client = await Twilio.Chat.Client.create(token);
      client.on("tokenAboutToExpire", async () => {
        const token = await this.fetchChatToken();
        client.updateToken(token);
      });
      this.channel = await client.getChannelByUniqueName(channel);
      this.channel.on("messageAdded", message => {
        if (this.messages.length > 0 && this.messages[this.messages.length - 1].state.index != message.state.index) {
          this.messages.push(message);
          let self = this;
          setTimeout(function() {
            self.scrollToEnd();
          }, 100);
        } else {
          this.messages.push(message);
        }
      });
    },

    // fetch messages from the channel
    async fetchMessages() {
      this.messages = (await this.channel.getMessages()).items;
      let self = this;
      setTimeout(function() {
        if(self.messages.length > 0) self.scrollToEnd();
      }, 100);
      this.isLoading = false;
    },
    // message send event
    sendMessage() {
      this.channel.sendMessage(this.newMessage);
      this.newMessage = "";
    },

    // if user click user on the list
    async selectChannel(data, type) {
      this.is_selected = true;
      this.isLoading = true;
      if (!this.is_session) {
          // alert( 'selectChannel::' )
        this.current_user = data;
        this.is_setting = false;
        axios.post("/api/get_reviews", data).then((res) => {
          var data = res.data.data;
          if (data.length > 0) {
            data.forEach((item, index) => {

              const cus = this.all_users.find(element => parseInt(element.user_id) === parseInt(item.sender_id));
                // console.log('selectChannel cus.user.id::')
                // console.log(cus.user.id)
              const profile_url = this.lang.data == 'en' ? cus.user.account_id ? this.Uri('/profile/' + cus.user.account_id) : this.Uri('/profile/' + cus.user.id) : cus.user.account_id ? this.Uri('/no/profil/' + cus.user.account_id) : this.Uri('/no/profil/' + cus.user.id);
              const avatar = cus.profile.avatar ? cus.profile.avatar : 'images/white-logo.svg';
              const size = cus.profile.avatar ? 'cover' : '20px 20px';
              let html = `<div class='review-accordion'><div class='avatar'><a href='${profile_url}'><div style="background-image: url('${avatar}'); background-size: ${size};" class="img"></div></a></div><div class='rate-stars'>`;
              if (item.rate >= 4.5) {
                html += "<img src='/images/home/star-dg.png' alt='' /><img src='/images/home/star-dg.png' alt='' /><img src='/images/home/star-dg.png' alt='' /><img src='/images/home/star-dg.png' alt='' /><img src='/images/home/star-dg.png' alt='' />";
              } else if (item.rate >= 3.5 && item.rate < 4.5) {
                html += "<img src='/images/home/star-g.png' alt='' /><img src='/images/home/star-g.png' alt='' /><img src='/images/home/star-g.png' alt='' /><img src='/images/home/star-g.png' alt='' /><img src='/images/home/star-w.png' alt='' />";
              } else if (item.rate >= 2.5 && item.rate < 3.5) {
                html += "<img src='/images/home/star-y.png' alt='' /><img src='/images/home/star-y.png' alt='' /><img src='/images/home/star-y.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' />";
              } else if (item.rate >= 1.5 && item.rate < 2.5) {
                html += "<img src='/images/home/star-o.png' alt='' /><img src='/images/home/star-o.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' />";
              } else if (item.rate >= 0.5 && item.rate < 1.5) {
                html += "<img src='/images/home/star-r.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' />";
              } else {
                html += "<img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' /><img src='/images/home/star-w.png' alt='' />";
              }
              html += `<p>${item.rate.toFixed(1)}</p></div></div>`;
              this.ratingContent += html;
            });
          } else {
            this.ratingContent = "";
          }
        });
        const res = await axios.post("/api/check_channel", {
          customer_email: data.user.email,
          customer_id: data.user.id,
          consultant_id: this.authUser.user.id,
          consultant_email: this.authUser.user.email,
          type: data.user.role,
        });
        // console.log('check_channel res::', res)

        const chat_token = await this.fetchChatToken();
        await this.initializeChatClient(
          chat_token,
          this.current_user.user.id,
          res.data
        );
        await this.fetchMessages();
        if (type == "incoming") {
          this.is_incomingSession_modal = true;
          this.playAudio("incoming");
          this.time_clock = this.incoming_user.min * 60;
        }

      }
    },
    // accept or reject session start request
    async sessionAccept() {
      this.stopAudio("incoming");
      this.$socket.sendObj({
        command: "message",
        id: this.incoming_user.id,
        customer_id: "",
        customer_name: "accepted",
        type: "request",
        msg: ""
      });
      this.is_outgoing = false;
      this.is_incomingSession_modal = false;
      this.is_session = true;
      let self = this;
      this.interval = setInterval(function() {
        if (self.time_clock > 0 && !self.is_paused) {
          self.time_clock--;
        } else {
          clearInterval(self.interval);
        }
      }, 1000);
      this.setStatus("busy");
      this.current_user.user.status = "busy";
      this.sendStatusSocket("busy");
    },
    sessionReject() {
      this.stopAudio("incoming");
      this.$socket.sendObj({
        command: "message",
        id: this.incoming_user.id,
        customer_id: "",
        customer_name: "rejected",
        type: "request",
        msg: ""
      });
      this.time_clock = 0;
      this.is_incomingSession_modal = false;
    },

    acceptIncomingCall() {
      this.is_incomingCall_modal = false;
      this.is_call_modal = true;
      this.device_connection.accept();
      console.log("accepted incoming call");
    },
    async acceptIncomingVideoCall() {
      this.is_call_mode = true;
      this.is_video_mode = true;
      this.is_incomingVideo_modal = false;
      this.is_call_modal = true;
      // this.device_connection.accept();
      const self = this;

      if (this.$refs.self_video_tag.children.length == 0) {
        createLocalVideoTrack({ audio: true, video: { width: 150 } }).then(
          track => {
            self.$refs.self_video_tag.appendChild(track.attach());
          }
        );
      }

      const { data } = await axios.post("/api/video_token", {
        userName: this.authUser.user.first_name + this.authUser.user.last_name,
        roomName: `videoRoom-${this.authUser.user.id}-${this.current_user.user.id}`
      });
      Video.connect(data.token, { name: `videoRoom-${this.authUser.user.id}-${this.current_user.user.id}` }).then(
        room => {
          // console.log("Successfully joined a Room: ", room);
          self.activeRoom = room;

          // Subscribe to the media published by RemoteParticipants already in the Room.
          room.participants.forEach(participant=> {
            self.participantConnected(participant);
          });

          // Subscribe to the media published by RemoteParticipants joining the Room later.
          room.on("participantConnected", self.participantConnected);

          room.on("participantDisconnected", self.participantDisconnected);

          room.once("disconnected", error =>
            room.participants.forEach(self.participantDisconnected)
          );

          participantMutedOrUnmutedMedia(room, track => {
            track.detach().forEach(element => {
              element.remove();
            });
          }, track => {
              if (track.kind === 'audio') {
                audioPreview.appendChild(track.attach());
              }
              if (track.kind === 'video') {
                videoPreview.appendChild(track.attach());
              }
          });
        },
        err => {
          console.error("Unable to connect to Room: " + err.message);
        }
      );
    },

    // start session button which is in header
    startSession() {
      this.is_payment_modal = true;
    },
    continueSession() {
      this.sendRequestSocket("session_continue");
      this.is_paused = false;
      this.is_session_modal = false;
      let self = this;
      this.interval = setInterval(function() {
        if (self.time_clock > 0 && !self.is_paused) { // decrease time counter to zero unless session isn't paused
          self.time_clock--;
        } else {
          clearInterval(self.interval);
        }
      }, 1000);
    },
    pauseSession() {
      this.sendRequestSocket("session_pause");
      this.is_paused = true;
    },
    endSession() {
      this.sendRequestSocket("session_pause");
      this.is_paused = true;
      this.is_session_modal = true;
    },
    // start session button which is in modal
    async startMethod() {
      // show progress animation
      this.is_progress_loading = true;
      // validate cost input form in payment modal
      this.$v.form.$touch();
      if (this.$v.form.$error || Number(this.authUser.user.balance) < Number(this.form.minute) * Number(this.current_user.hourly_rate )) {
        this.is_progress_loading = false;
        this.is_minus_balance = true;
        return;
      } else {
        // await this.initializeVideoClient();

        this.is_payment_modal = false; // close payment modal
        // initiate payment modal values
        this.is_progress_loading = false;
        this.is_minus_balance = false;
        // update progress status
        this.progress = "connect";
        // open progress modal
        this.is_progress_modal = true;
        this.playAudio("outgoing"); // play calling sound
        // update progress status if consultant declined the request or not answered during 60 secs
        let self = this;
        setTimeout(function(){
          if (self.progress !== "connected" || self.progress !== "declined") {
            self.sendRequestSocket("session_cancel");
            self.progress = "notAnswered";
            self.stopAudio("outgoing");
          }
        }, 1000 * 60);
        // send session start request to consultant
        this.sendRequestSocket("session_start");
      }
    },
    // start timer if consultant accept request
    startTimer() {
      let self = this;
      this.interval = setInterval(function() {
        if (self.time_clock > 0 && !self.is_paused) { // decrease time counter to zero unless session isn't paused
          self.time_clock--;
        } else {
          clearInterval(self.interval);
        }
      }, 1000);
      this.setStatus("busy"); // update current user's status into DB for offline users
      this.current_user.user.status = "busy"; // update current selected consultant's stauts for detail view
      this.sendStatusSocket("busy"); // update current user's status on status socket server
    },

    // Handling Voice module
    startCall() {
      var params = {
        phone: this.current_user.user.phone,
        callerId: this.authUser.user.phone,
        name:
          this.current_user.user.first_name +
          this.current_user.user.last_name,
        type: "voice",
        roomName: ""
      };
      this.device.connect(params);
      this.is_call_mode = true;
      this.is_call_modal = true;
    },
    //Handling video module
    async startVideo() {
      this.is_call_mode = true;
      this.is_video_mode = true;
      this.is_call_modal = true;
      let self = this;

      if (self.$refs.self_video_tag.children.length == 0) {
        createLocalVideoTrack({ audio: true, video: { width: 150 } }).then(
          track => {
            self.$refs.self_video_tag.appendChild(track.attach());
          }
        );
      }

      var params = {
        phone: this.current_user.user.phone,
        callerId: this.authUser.user.phone,
        name:
          this.current_user.user.first_name +
          this.current_user.user.last_name,
        type: "video",
        roomName: `videoRoom-${this.current_user.user.id}-${this.authUser.user.id}`
      };
      this.device.connect(params);

      const token = await this.fetchVideoToken();
      Video.connect(token, {
        name: `videoRoom-${this.current_user.user.id}-${this.authUser.user.id}`
      }).then(
        room => {
          console.log("Successfully joined a Room: ", room);
          self.activeRoom = room;

          // Subscribe to the media published by RemoteParticipants already in the Room.
          room.participants.forEach(participant=> {
            self.participantConnected(participant);
          });

          room.on("participantConnected", self.participantConnected);

          room.on("participantDisconnected", self.participantDisconnected);

          room.once("disconnected", error =>
            room.participants.forEach(self.participantDisconnected)
          );

          participantMutedOrUnmutedMedia(room, track => {
            track.detach().forEach(element => {
              element.remove();
            });
          }, track => {
              if (track.kind === 'audio') {
                audioPreview.appendChild(track.attach());
              }
              if (track.kind === 'video') {
                videoPreview.appendChild(track.attach());
              }
          });
        },
        err => {
          console.error("Unable to connect to Room: " + err.message);
        }
      );
    },
    participantConnected(participant) {
      console.log('Participant123 "%s" connected', participant.identity);

      const div = document.createElement("div");
      div.ref = participant.sid;

      participant.on("trackSubscribed", track =>
        this.trackSubscribed(track)
      );
      participant.tracks.forEach(track => {
        this.trackSubscribed(track)
      });
      participant.on("trackUnsubscribed", this.trackUnsubscribed);

    },
    participantDisconnected(participant) {
      console.log('Participant "%s" disconnected', participant.identity);
      participant.tracks.forEach(track=>this.trackUnsubscribed(track));
    },
    trackSubscribed(track) {
      if (track.kind === 'audio') {
        this.$refs.audioPreview.appendChild(track.attach());
      }
      if (track.kind === 'video') {
        this.$refs.videoPreview.appendChild(track.attach());
      }
    },
    trackUnsubscribed(track, publication) {
      track.detach().forEach(element => element.remove());
    },

    // send request via socket
    sendRequestSocket(type) {
      this.$socket.sendObj({
        command: "message",
        type: "request",
        sub_type: type,
        id: this.current_user.user.id,
        customer_id: this.authUser.user.id,
        customer_name:
          this.authUser.user.first_name +
          " " +
          this.authUser.user.last_name,
        min: this.form.minute,
        img: this.authUser.profile.avatar
      });
    },
    // send status via socket
    sendStatusSocket(msg) {
      this.$socket.sendObj({
        command: "message",
        id: this.authUser.user.id,
        type: "status",
        msg: msg
      });
    },
    // set consultant's status into DB
    setStatus(status) {
      axios.post("/api/manage_status", {
        id: this.authUser.user.id,
        status
      });
    },

    minuteChange() {
      const val = Number(this.form.minute) * Number(this.current_user.hourly_rate);
      const endpoint = 'convert';
      const from = this.current_user.currency;
      const to = 'NOK';
      if (this.current_user.currency !== 'NOK') {
        $.ajax({
          url: 'https://api.currencylayer.com/' + endpoint + '?access_key=' + this.accessKey.key +'&from=' + from + '&to=' + to + '&amount=' + val,
          dataType: 'jsonp',
          success: function(json) {
            this.cost = json.result;
            this.formatted_cost = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(this.cost).replace('kr', 'NOK');
          }
        });
      } else {
        this.cost = val;
        this.formatted_cost = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(this.cost).replace('kr', 'NOK');
      }
    },
    submitReview() {
      axios
        .post("/api/submit_review", {
          sender_id: this.authUser.user_id,
          receiver_id: this.current_user.user_id,
          rate: this.rate,
          description: this.review_des,
          type: "CONTOCUS"
        })
        .then(res => {
          this.is_review_modal = false;
          this.is_call_modal = false;
          this.time_clock = 0;
        });
    },
    showSetting() {
      this.is_setting = true;
    },
    scrollToEnd() {
      var container = this.$el.querySelector("#scroll-view");
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },
    goProfile() {
      if (this.lang.data == "en") {
        window.location.href = window.location.origin + "/profile/" + this.current_user.user.id;
      } else {
        window.location.href = window.location.origin + "/no/profil/" + this.current_user.user.id;
      }
    },
    toHHMMSS(sec_num) {
      var hours = Math.floor(sec_num / 3600);
      var minutes = Math.floor((sec_num - hours * 3600) / 60);
      var seconds = sec_num - hours * 3600 - minutes * 60;

      if (hours < 10) {
        hours = "0" + hours;
      }
      if (minutes < 10) {
        minutes = "0" + minutes;
      }
      if (seconds < 10) {
        seconds = "0" + seconds;
      }
      return hours + ":" + minutes + ":" + seconds;
    },
    handleSessionEnd() {
      this.sendRequestSocket("session_end");
      this.setStatus("available");
      this.sendStatusSocket("available");
      clearInterval(this.interval);
      this.current_user.user.status = "available";
      this.time_clock = 0;
      this.is_session_modal = false;
      this.is_session = false;
      this.is_call_modal = false;
      this.is_review_modal = true;
      this.incoming_user = {};

      // Stop all tracks of local participant
      this.activeRoom.localParticipant.tracks.forEach(track=>{
        track.stop();
      })
      //Disconnect from the room
      this.activeRoom.disconnect();
    },
    handleClose(type) {
      switch (type) {
        case "progress":
          this.sendRequestSocket("cancel_request");
          this.stopAudio("outgoing");
          this.is_progress_modal = false;
          break;
        case "incoming_voice":
          this.is_incomingCall_modal = false;
          break;
        case "incoming_video":
          this.is_incomingVideo_modal = false;
          break;
        case "incoming_session":
          this.is_incomingSession_modal = false;
          break;
        case "session":
          this.is_session_modal = false;
          this.continueSession();
          break;
        case "setting":
          this.is_setting = false;
          break;
        case "review":
          this.is_review_modal = false;
          break;
        case "payment":
          this.is_payment_modal = false;
          break;
        case "pause":
          this.is_pause_modal = false;
          break;
        case "call":
          this.is_call_modal = false;
          this.device.disconnectAll();
          if (this.activeRoom) {
            this.activeRoom.localParticipant.tracks.forEach(function(track) {
              track.stop();
            });
            this.activeRoom.disconnect();
          }
          this.handleSessionEnd();
          break;
      }
    },
    handleCloseProgress() {
      this.is_progress_modal = false;
    },
    handlingCallMode(type) {
      switch (type) {
        case "audio":
          this.is_call_mode = !this.is_call_mode;
          if (!this.is_call_mode) {
            muteYourAudio(this.activeRoom)
          } else {
            if (this.is_session && !this.is_paused) {
              unmuteYourAudio(this.activeRoom)
            }
          }
          break;
        case "video":
          this.is_video_mode = !this.is_video_mode;
          if (!this.is_video_mode) {
            muteYourVideo(this.activeRoom)
          } else {
            if (this.is_session && !this.is_paused) {
              unmuteYourVideo(this.activeRoom)
            }
          }
          break;
        case "share":
          this.is_share_mode = !this.is_share_mode;
          break;
      }
    },

    async handlingShareMode() {
          this.is_share_mode = !this.is_share_mode;
          try {
            if( this.is_share_mode ) {
              // The LocalVideoTrack for your screen.
              let screenTrack;

              // Create and preview your local screen.
              screenTrack = await createScreenTrack(720, 1280);

              screenTrack.mediaStreamTrack.onended = () => { this.handlingShareMode() };
              //Disable Camera video track
              muteYourVideo(this.activeRoom);

              this.activeRoom.localParticipant.publishTrack(screenTrack, {
                name: 'screen', // Tracks can be named to easily find them later
                priority: 'low', // Priority is set to high by the subscriber when the video track is rendered
              }).then(trackPublication => {
                this.$refs.stopScreenShareRef.share = () => {
                  this.activeRoom.localParticipant.unpublishTrack(screenTrack);
                  // TODO: remove this if the SDK is updated to emit this event
                  this.activeRoom.localParticipant.emit('trackUnpublished', trackPublication);
                  screenTrack.stop();
                  screenTrack = null;
                };
              })
              .catch(error=>{
                console.log(error)
              });
            } else {
              this.$refs.stopScreenShareRef.share();
              //Enable Camera video track
              unmuteYourVideo(this.activeRoom);
            }

          } catch (e) {
            alert(e.message);
          }
    },

    playAudio(type) {
      if (type == "incoming") {
        this.incoming_audio = new Audio('/audio/call.mp3');
        this.incoming_audio.loop = true;
        this.incoming_audio.play();
      } else {
        this.outgoing_audio = new Audio('/audio/call.mp3');
        this.outgoing_audio.loop = true;
        this.outgoing_audio.play();
      }
    },
    stopAudio(type) {
      if (type == "incoming") {
        this.incoming_audio.pause();
      } else {
        this.outgoing_audio.pause();
      }
    },
    preventNav(event) {
      if (this.is_session) {
        event.preventDefault();
        event.returnValue = "";
        if (this.is_outgoing) {
          this.sendRequestSocket("session_end");
        }
      }
    },
    goToFindConsult() {
      location.href = this.findRoute.route;
    },
    Uri(url) {
      return window.location.origin + url;
    },
    dateTranslationFormt(str) {
      const translateInterface = {
        en: {
          "Mon": "Mon", "Tue": "Tue", "Wed": "Wed", "Thu": "Thu", "Fri": "Fri", "Sat": "Sat", "Sun": "Sun",
          "Jan": "Jan", "Feb": "Feb", "Mar": "Mar", "Apr": "Apr", "May": "May", "Jun": "Jun", "Jul": "Jul", "Aug": "Aug", "Sep": "Sep", "Oct": "Oct", "Nov": "Nov", "Dec": "Dec"
        },
        no: {
          "Mon": "Man", "Tue": "Tir", "Wed": "Ons", "Thu": "Tor", "Fri": "Fre", "Sat": "Lør", "Sun": "Søn",
          "Jan": "Jan", "Feb": "Feb", "Mar": "Mar", "Apr": "apr", "May": "Mai", "Jun": "Jun", "Jul": "Jul", "Aug": "Aug", "Sep": "Sep", "Oct": "Okt", "Nov": "Nov", "Dec": "Des"
        }
      };
      let res = [];
      const strArr = str.split(" ");
      strArr.forEach((word) => {
        res.push(translateInterface[this.lang.data][word] ? translateInterface[this.lang.data][word] : word);
      });
      return res.join(" ");
    }
  },
  beforeMount() {
    window.addEventListener("beforeunload", this.preventNav);
    this.$once("hook:beforeDestroy", () => {
      window.removeEventListener("beforeunload", this.preventNav);
    });
  },
  beforeRouteLeave(to, from, next) {
    if (!window.confirm($t('member.session-end-confirmation'))) {
      return;
    }
    next();
  },
  watch: {
    time_clock: function(cur, prev) {
      if (cur == 0 && this.is_session && this.is_outgoing) {
        this.handleSessionEnd();
      }
    }
  }
};
</script>
