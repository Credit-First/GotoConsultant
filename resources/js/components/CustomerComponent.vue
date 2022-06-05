<template>
  <div class="full-chat-section">
      <br><br>
    <vue-loader :active.sync="isLoading" :is-full-page="true" />
    <div class="chat-left" v-if="contactedConsultants.length > 0 && is_contact_list">
      <h2>{{ $t('member.my-sessions') }}</h2>
      <div class="user-group">
        <div
          :class="[consultant.id == current_consultant.id ? 'chat-model active' : 'chat-model']"
          v-for="consultant in contactedUsers"
          :key="consultant.id"
          v-on:click="selectChannel(consultant)"
        >
          <div class="chat-icon" :style="{ 'background-image': 'url(' + consultant.profile.avatar + ')' }" v-if="consultant.profile != null && consultant.profile.avatar != '' && consultant.profile.avatar != undefined"></div>
          <div class="chat-icon" v-else>
            <label>{{consultant.user.first_name[0]}}{{consultant.user.last_name[0]}}</label>
          </div>
          <div
            :class="[consultant.user.status == 'available' ? 'chat-details' : consultant.user.status == 'offline' ? 'chat-details offline' : 'chat-details busy']"
          >
              <span :id="'wrapper_numberCircleRaisedSpan_' + consultant.user.id" v-if="consultant.sender_total">
                <span class="numberCircleRaised" :id="'numberCircleRaisedSpan_' + consultant.user.id" v-if="consultant.sender_total">
                  {{consultant.sender_total}}
                </span>
              </span>
            <label>
                {{consultant.user.first_name}} {{consultant.user.last_name}}
              <span>{{ $t(`member.${consultant.user.status}`) }}</span>
            </label>
            <legend
              v-if="consultant.profile && consultant.profile.profession"
            >{{ $t(`member.${consultant.profile.profession}`) }}</legend>
          </div>
        </div>
      </div>
    </div>
    <div class="select-box" v-if="!is_selected && !is_mobile">
      <div class="step">
        <img src="/images/mascot.svg" alt="no-image" />
        <div v-if="contactedConsultants.length > 0">
          <label>
            {{ $t('member.no-consultants')}}
          </label>
          <p class="text">{{ $t('member.no-consultants-des')}}</p>
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
    <div class="session-pane chatter-pro" v-if="is_sessionPane">
      <div class="title" style="padding: 0 !important;margin: 0 !important;">
        <h4>{{ $t('member.start-session') }}</h4>
      </div>
      <div :class="[current_consultant.user.status == 'available' ? 'rate-session chat-setting' : current_consultant.user.status == 'offline' ? 'rate-session offline' : 'rate-session busy']">
        <button class="link" v-on:click="goToContactList"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="chevron-left" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="svg-inline--fa fa-chevron-left fa-w-10 fa-lg"><path fill="currentColor" d="M34.52 239.03L228.87 44.69c9.37-9.37 24.57-9.37 33.94 0l22.67 22.67c9.36 9.36 9.37 24.52.04 33.9L131.49 256l154.02 154.75c9.34 9.38 9.32 24.54-.04 33.9l-22.67 22.67c-9.37 9.37-24.57 9.37-33.94 0L34.52 272.97c-9.37-9.37-9.37-24.57 0-33.94z" class=""></path></svg></button>
        <div
          v-bind:style="{ 'background-image': 'url(' + current_consultant.profile.avatar + ')' }"
          v-if="current_consultant.profile && current_consultant.profile.avatar"
          class="avatar"
          v-on:click="goProfile()"
        >
          <span :class="[current_consultant.user.status == 'available' ? 'absol-span available' : current_consultant.user.status == 'offline' ? 'absol-span offline' : 'absol-span busy']">&#8226;</span>
        </div>
        <b v-else>{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
        <p v-if="current_consultant.profile && current_consultant.profile.profession">{{ $t(`member.${current_consultant.profile.profession}`) }}</p>
        <h2>{{current_consultant.user.first_name}} {{current_consultant.user.last_name}}</h2>
        <small>{{current_consultant.currency}} {{current_consultant.hourly_rate}} p/m</small>
        <vue-custom-rate :_rate="current_consultant.rate ? parseInt(current_consultant.rate) : 0" :_type="'static'"></vue-custom-rate>
        <div class="btn-group">
          <button class="btn" :disabled="current_consultant.user.status != 'available'" v-on:click="Step2('chat')">
            <img
              :src="[current_consultant.user.status == 'available' ? '/images/home/msg.png' : current_consultant.user.status == 'In a call' ? '/images/home/msg-y.png': '/images/home/msg-g.png']"
              alt="no-img"
            />
          </button>
          <button class="btn" :disabled="current_consultant.user.status != 'available'" v-on:click="Step2('voice')">
            <img
              :src="[current_consultant.user.status == 'available' ? '/images/home/ph.png' : current_consultant.user.status == 'In a call' ? '/images/home/ph-y.png': '/images/home/ph-g.png']"
              alt="no-img"
            />
          </button>
          <button class="btn btn-mid" :disabled="current_consultant.user.status != 'available'" v-on:click="Step2('video')">
            <img
              :src="[current_consultant.user.status == 'available' ? '/images/home/video.png' : current_consultant.user.status == 'In a call' ? '/images/home/video-y.png': '/images/home/video-g.png']"
              alt="no-img"
            />
          </button>
        </div>
      </div>
      <div class="chat-records">
        <div class="records-left">
          <label>{{current_consultant.completed_sessions > 0 ? current_consultant.completed_sessions : 0}}</label>
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
          :datas="[{title: $t('member.details'), content: current_consultant.profile.description }, {title: $t('member.ratings'), content: ratingContent}]"
        />
      </div>
    </div>
    <div class="chat-room" v-if="is_mobile ? !is_sessionPane && is_selected : is_selected">
      <div class="chat-right">
        <div :class="[is_mobile ? 'chat-profile sticky' : 'chat-profile']">
          <div class="end-chat-right">
            <div class="timer">
              <img src="/images/timer.svg" />
              <p>{{toHHMMSS(time_clock)}}</p>
            </div>
            <div class="btn-group">
              <button class="btn-session start" v-on:click="startSession()" v-if="!is_session && current_consultant.user.status =='available'">{{ $t('member.start_session') }}</button>
              <div class="btn-session-group" v-else-if="is_session">
                <button class="btn-session pause" v-on:click="pauseSession()" v-if="!is_paused">{{ $t('member.pause_session') }}</button>
                <button class="btn-session pause" v-on:click="continueSession()" v-else>{{ $t('member.continue_session') }}</button>
                <button class="btn-session end" v-on:click="endSession()">{{ $t('member.end_session') }}</button>
                <button class="btn-image" v-on:click="startCall()"><img src="/images/call-session.svg" alt="voice"/></button>
                <button class="btn-image" v-on:click="startVideo()"><img src="/images/video-session.svg" alt="video"/></button>
              </div>
              <button class="btn-image" v-on:click="showSetting()" v-if="!is_setting"><img src="/images/user-profile.svg" alt="setting"/></button>
            </div>
          </div>
        </div>
        <div class="chat-history" id="scroll-view" v-if="messages.length > 0">
          <div class="chat-list" v-for="(message, index) in messages" v-bind:key="message.index">
            <div class="date-separate" v-if="index == 0">
              <legend>
                <span>{{ message.timestamp.toDateString() == today ? $t('member.today'): dateTranslationFormt(message.timestamp.toDateString()) }}</span>
              </legend>
            </div>
            <div
              class="date-separate"
              v-else-if="index > 0 && messages[index-1].timestamp.toDateString() !== message.timestamp.toDateString()"
            >
              <legend>
                <span>{{ message.timestamp.toDateString() == today ? $t('member.today'): dateTranslationFormt(message.timestamp.toDateString()) }}</span>
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
                <div :style="{'background-image': 'url(' + current_consultant.profile.avatar + ')'}" v-if="current_consultant.profile && current_consultant.profile.avatar"></div>
                <b
                  v-else
                >{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</b>
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
            <p>{{ $t('member.no-chat-history-des1')}} {{current_consultant.user.first_name}} {{ $t('member.no-chat-history-des2')}}</p>
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
            :class="[current_consultant.user.status == 'available' ? 'rate-session chat-setting' : current_consultant.user.status == 'offline' ? 'rate-session offline' : 'rate-session busy']"
          >
            <div class="chat-icon" v-on:click="goProfile()" :style="{ 'background-image': 'url(' + current_consultant.profile.avatar + ')' }" v-if="current_consultant.profile != null && current_consultant.profile.avatar != '' && current_consultant.profile.avatar != undefined">
              <span v-if="current_consultant.company"><img src="/images/mortarboard-w.svg" alt="no-img" /></span>
            </div>
            <div class="chat-icon" v-on:click="goProfile()" v-else>
              <span v-if="current_consultant.company"><img src="/images/mortarboard-w.svg" alt="no-img" /></span>
              <label>{{current_consultant.user.first_name[0]}}{{current_consultant.user.last_name[0]}}</label>
            </div>
            <span :class="[current_consultant.user.status == 'available' ? 'absol-span consultant available' : current_consultant.user.status == 'offline' ? 'absol-span consultant offline' : 'absol-span consultant busy']">&#8226;</span>
            <p
              v-if="current_consultant.profile && current_consultant.profile.profession"
            >{{current_consultant.profile.profession}}</p>
            <h2>{{current_consultant.user.first_name}} {{current_consultant.user.last_name}}</h2>
            <small>{{current_consultant.currency}} {{current_consultant.hourly_rate}} p/m</small>
            <vue-custom-rate :_rate="current_consultant.rate ? parseInt(current_consultant.rate) : 0" :_type="'static'"></vue-custom-rate>
          </div>
          <div class="chat-records">
            <div class="records-left">
              <label>{{current_consultant.completed_sessions > 0 ? current_consultant.completed_sessions : 0}}</label>
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
              :datas="[{title: $t('member.details'), content: current_consultant.profile.description }, {title: $t('member.ratings'), content: ratingContent}]"
            />
          </div>
        </div>
      <!-- </vue-drawer> -->
    </div>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('payment')" v-show="is_payment_modal" class="payment">
      <div class="modal-body">
        <div class="avatar icon" :style="{'background-image': 'url(/images/earnings-icon.svg)'}"></div>
        <div class="content" style="">
          <h2 style="padding:0; margin:0">{{ $t('member.start-session-dialog') }}</h2>
          <p>
            <b>{{ $t('member.account-balance')}} {{balance}}</b>
          </p>
          <p style="font-size: small; padding:0; margin:0">{{ $t('member.balance-charge-question')}}</p>
          <div :class="[$v.form.$error ? 'hasError input-box': 'input-box']">
            <input type="text" v-model="form.minute" v-on:keyup="minuteChange(vatPercent)" />
            <label>min</label>
          </div>
          <p class="total" v-show="vatPercent">
              Vat percent:
              <b>{{vatPercent}}%</b>
              <span v-show="calculatedVat">
                ,&nbsp;&nbsp;vat:
                <b>{{formattedCalculatedVat}}</b>
              </span>
          </p>
          <p class="total" style="margin-bottom: 30px !important;">
            {{ $t('member.total-cost')}}:
            <b>{{formatted_cost}}</b>
              <span v-show="totalWithVat">
                &nbsp;<br>with vat
                <b>{{formattedTotalWithVat}}</b>
              </span>
          </p>

        </div>
      </div>
      <div class="modal-footer">
        <button class="btn review" v-on:click="startMethod()" :disabled="authUser.user.balance == 0">{{ $t('member.start-session') }} <vue-loading :color="'#fff'" v-if="is_progress_loading"/></button>
      </div>
    </drag-dialog>
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('review')" v-show="is_review_modal" class="review">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_consultant.profile.avatar + ')'}" v-if="current_consultant.profile && current_consultant.profile.avatar != '' && current_consultant.profile.avatar != undefined" ></div>
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
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('session')" v-show="is_session_modal" class="session">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_consultant.profile.avatar + ')'}" v-if="current_consultant.profile && current_consultant.profile.avatar != '' && current_consultant.profile.avatar != undefined" ></div>
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
        <div class="avatar" :style="{'background-image': 'url(' + current_consultant.profile.avatar + ')'}" v-if="current_consultant.profile && current_consultant.profile.avatar != '' && current_consultant.profile.avatar != undefined" ></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <h2>{{ $t('member.progress-start') }}</h2>
        <p>{{ $t('member.progress-start-des') }} {{current_consultant.user.first_name}}</p>
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
    <drag-dialog :options="{ buttonPin:false }" @close="handleClose('pause')" v-show="is_pause_modal" class="pause">
      <div class="modal-body">
        <div class="avatar" :style="{'background-image': 'url(' + current_consultant.profile.avatar + ')'}" v-if="current_consultant.profile && current_consultant.profile.avatar != '' && current_consultant.profile.avatar != undefined" ></div>
        <div class="default-pic" v-else><img src="/images/white-logo.svg"/></div>
        <h2>{{ $t('member.session-pause-modal') }}</h2>
        <p>{{ $t('member.session-pause-modal-des1') }} {{current_consultant.user.first_name}} {{ $t('member.session-pause-modal-des2')}}</p>
      </div>
      <div class="modal-footer">
        <button class="btn decline" v-on:click="handleClose('pause')">{{$t('member.close')}}</button>
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
  </div>
</template>

<script>
// import axios from "../Http";
import StarRate from "vue-cute-rate";
import VueAccordion from "accordion-vue";
import Loading from 'vue-loading-overlay';
import Drawer from "vue-simple-drawer";
import DialogDrag from 'vue-dialog-drag';
import moment from "moment";
import { Device } from "twilio-client";
import { required, minValue } from "vuelidate/lib/validators";
import { isMobile } from "mobile-device-detect";
import EllipsisLoader from './Loader';
import CustomStarRating from './CustomRating';
import { createScreenTrack } from "../helpers/screenshare";
import {
  muteYourAudio,
  unmuteYourAudio,
  muteYourVideo,
  unmuteYourVideo,
  participantMutedOrUnmutedMedia
} from '../helpers/local-media-controls';

const Video = require("twilio-video");
const {
  connect,
  createLocalTracks,
  createLocalVideoTrack
} = require("twilio-video");
window.$ = window.jQuery = require('jquery')

export default {
  name: "customer-component",
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
    contactedConsultants: {
      type: Array,
      required: true
    },
    vatPercent: {
      type: Number,
      required: true
    },
    selectedId: {
      type: Number,
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
      is_mobile: false,
      is_paused: false,
      chat_accepted: false,
      is_sessionPane: false,
      is_session: false,
      isLoading: false,
      is_progress_modal: false,
      is_selected: false,
      is_setting: false,
      is_contact_list: true,
      is_call_modal: false,
      is_session_modal: false,
      is_review_modal: false,
      is_payment_modal: false,
      is_progress_loading: false,
      is_pause_modal: false,
      is_call_mode: false,
      is_video_mode: false,
      is_share_mode: false,
      device: new Device(),
      activeRoom: null,
      progress: "connect",
      messages: [],
      time_clock: 0,
      cost: 0,
      rate: 0,
      outgoing_audio: null,
      interval: null,
      ratingContent: "",
      redirect_url: null,
      newMessage: null,
      channel: null,
      balance: null,
      formatted_cost: null,
      totalWithVat: null,
      formattedTotalWithVat: null,
      calculatedVat: null,
      formattedCalculatedVat: null,
      today: null,
      review_des: null,
      contactedUsers: [],
      current_consultant: {
        user: {
          first_name: "",
          last_name: ""
        },
        profile: {}
      },
      form: {
        minute: 0
      },
      screenTrack: null,
      isFullscreen: false
    };
  },
  validations: {
    form: {
      minute: { required, min: minValue(1) }
    }
  },
  mounted() {
    console.log("customer chat service started!");
    this.today = moment(new Date()).format("ddd MMM DD YYYY");
    this.is_mobile = isMobile ? true : false;
    this.contactedUsers = [...this.contactedConsultants];
    this.balance = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(this.authUser.user.balance).replace('kr', 'NOK');
    this.setStatus("available");

    let self = this;

    if (this.selectedId != 0) {
      const user = this.consultants.find(element => parseInt(element.user_id) === this.selectedId);
      this.selectChannel(user);
    }

    this.$socket.onopen = () => {
      this.$socket.onmessage = data => {
        var msg = JSON.parse(data.data);
        console.log(msg);
        if (msg.type == "token") {
          self.voice_token_name = msg.token;
        }
        if (msg.type == "request") {
          self.stopAudio(); // pause sound even consultant accept or reject the request
          if (!msg.sub_type && msg.name == "accepted") {
            self.time_clock = Number(self.form.minute) * 60; // set time count value
            self.progress = "connected";
            self.is_progress_modal = false; // open connecting progress modal
            self.is_session = true; // let user can't select other consultant from the list
            self.startTimer(); // start time interval
            // process the transaction if the consultant accept the session request
            axios.post("/api/manage_transaction", {
              id: self.authUser.user.id,
              cost: self.cost,
              vat_amount: self.calculatedVat,
              total_amount: self.totalWithVat,
              time: self.form.minute,
              consultant_id: self.current_consultant.id
            }).then(res => {
              self.cost = 0;
              self.form.minute = 0;
              self.balance = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(res).replace('kr', 'NOK'); // update balance into new reducted value
            });
          } else if(!msg.sub_type && msg.name == "rejected") {
            self.progress = "declined"; // update progress modal status
            self.is_session = false;
          } else {
            if (msg.sub_type == "session_pause") {
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
              self.is_call_modal = false;
              self.is_pause_modal = false;
              self.is_review_modal = true;
            }
          }
        } else { // get other user's updated status and update it for list
          const consultant = self.contactedUsers.find(element => parseInt(element.user_id) === parseInt(msg.id));
          consultant.user.status = msg.status;
        }
      };
      this.$socket.sendObj({
        command: "subscribe",
        channel: this.authUser.user.id
      });
    };
    Echo.private('status').listen('UserStatus', (e) => {
      this.contactedUsers.forEach((consultant) => {
        if (consultant.user.id == e.id) {
          consultant.user.status = e.status;
          console.log("update consultant's status: ", e.status);
        }
      });
    });
    this.device.incoming(async function(connection) {
      console.log("device incoming: ", connection);
      var type = connection.customParameters.get("type");
      var roomName = connection.customParameters.get("roomName");
      self.is_call_modal = true;
      if (type == "voice") {
        connection.accept();
      } else {
        connection.accept();
        if (self.$refs.self_video_tag.children.length == 0) {
          createLocalVideoTrack({ name: "camera", audio: true, video: { width: 150 } }).then(
            track => {
              self.$refs.self_video_tag.appendChild(track.attach());
            }
          );
        }

        const { data } = await axios.post("/api/video_token", {
          userName:
            self.authUser.user.first_name +
            self.authUser.user.last_name,
          roomName: roomName
        });
        Video.connect(data.token, { name: roomName }).then(
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
      }
    });
    this.device.disconnect(function(connection) {
      self.is_call_modal = false;
    });
    this.device.connect(function(connection) {
      console.log(connection);
    });
    this.device.error(function(error) {
      console.error("ERROR: " + error.message);
      if (error.code == 31205) {
        self.initializeCallClient();
      }
    });

    window.addEventListener('click', this.handleClickEvent);
  },
  methods: {
    // initiate voice call twilio client
    async initializeCallClient() {
      axios
        .post("/api/call_token", {
          name:
            this.current_consultant.user.first_name +
            this.current_consultant.user.last_name
        })
        .then(res => {
          this.device.setup(res.data.token, { debug: true });
        });
    },
    // initiate video twilio client
    async initializeVideoClient() {
      await axios
        .post("/api/create_room", {
          name: `videoRoom-${this.current_consultant.user.id}-${this.authUser.user.id}`
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
        roomName: `videoRoom-${this.current_consultant.user.id}-${this.authUser.user.id}`
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
          self.scrollToEnd();
        }, 100);
      this.isLoading = false;
    },
    // message send event
    sendMessage() {
      this.channel.sendMessage(this.newMessage);
      this.newMessage = "";
    },

    goToContactList() {
      this.is_contact_list = true;
      this.is_selected = false;
      this.is_sessionPane = false;
    },
    async Step2 (type) {
      this.isLoading = true;
      // alert('Step2 before check_channel 1')
      const res = await axios.post("/api/check_channel", {
        customer_email: this.authUser.user.email,
        customer_id: this.authUser.user.id,
        consultant_id: this.current_consultant.user.id,
        consultant_email: this.current_consultant.user.email,
        type: this.authUser.user.role
      });
      const chat_token = await this.fetchChatToken();
      await this.initializeChatClient(
        chat_token,
        this.current_consultant.user.id,
        res.data
      );
      await this.fetchMessages();
      await this.setMissedNotifications(data.user.id, this.authUser.user.id);

      this.is_sessionPane = false;
      this.isLoading = false;
      if (type != 'chat') {
        this.startSession();
      }
    },
    // if user click consultant on the list
    async selectChannel(data) {
      this.is_contact_list = this.is_mobile ? false : true;
      this.is_selected = true; // update UI status
      this.isLoading = true; // show loading screen while initiate chat module
      if (!this.is_session) {
        this.current_consultant = data;
        const res = await axios.post("/api/get_reviews", data);
        const reviews = res.data.data;
        if (reviews.length > 0) {
          reviews.forEach((item, index) => {
            const cus = this.customers.find(element => parseInt(element.user_id) === parseInt(item.sender_id));
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
        if (this.is_mobile) {
           this.is_sessionPane = this.is_mobile ? true : false;
           this.isLoading = false;
        } else {
            // alert('Step2 before check_channel 12')
          const res = await axios.post("/api/check_channel", {
            customer_email: this.authUser.user.email,
            customer_id: this.authUser.user.id,
            consultant_id: data.user.id,
            consultant_email: data.user.email,
            type: this.authUser.user.role
          });
          const chat_token = await this.fetchChatToken();
          await this.initializeChatClient(
            chat_token,
            this.current_consultant.user.id,
            res.data
          );
          await this.fetchMessages();
          await this.setMissedNotifications(data.user.id, this.authUser.user.id);
        }
      }
    },

    async setMissedNotifications(consultant_id, customer_id ) {
      const missedNotificationsRes = await axios.post("/api/check_missed_notifications", {
        customer_id: customer_id,
        consultant_id: consultant_id,
      });

      if(missedNotificationsRes.data.missedNotificationsCount==0) {
        $("#wrapper_member_sidebar_calcCommonMissedNotificationsCount").html("");
      } else {
        $("#member_sidebar_calcCommonMissedNotificationsCount").html(missedNotificationsRes.data.missedNotificationsCount);
      }

      // console.log('$("#numberCircleRaisedSpan_" + consultant_id::')
      // console.log( "#numberCircleRaisedSpan_" + consultant_id )

      $("#wrapper_numberCircleRaisedSpan_" + consultant_id).html("");
    },

      // the event of start session button which is in header
    startSession() {
      this.is_payment_modal = true;
    },
    pauseSession() {
      this.sendRequestSocket("session_pause");
      this.is_paused = true;
    },
    continueSession() {
      this.sendRequestSocket("session_continue");
      this.is_session_modal = false;
      this.is_paused = false;
      let self = this;
      this.interval = setInterval(function() {
        if (self.time_clock > 0 && !self.is_paused) { // decrease time counter to zero unless session isn't paused
          self.time_clock--;
        } else {
          clearInterval(self.interval);
        }
      }, 1000);
    },
    endSession() {
      this.sendRequestSocket("session_pause");
      this.is_paused = true;
      this.is_session_modal = true;
    },
    // the event of start session button which is in modal
    async startMethod() {
      // show progress animation
      this.is_progress_loading = true;
      // validate cost input form in payment modal
      this.$v.form.$touch();
      if (this.$v.form.$error || Number(this.authUser.user.balance) < Number(this.form.minute) * Number(this.current_consultant.hourly_rate )) {
        this.is_progress_loading = false;
        return;
      } else {
        await this.initializeCallClient();
        // await this.initializeVideoClient();

        this.is_payment_modal = false; // close payment modal
        // initiate payment modal values
        this.is_progress_loading = false;
        // update progress status
        this.progress = "connect";
        // open progress modal
        this.is_progress_modal = true;
        this.playAudio(); // play calling sound
        // update progress status if consultant declined the request or not answered during 60 secs
        let self = this;
        setTimeout(function(){
          console.log('startMethod setTimeout self.progress::')
          console.log(self.progress)

          if(self.progress == 'connect') { // there were no answer
            $.ajax({
              type: 'post',
              dataType: 'json',
              url: '/api/add_missed_notification',
              data: {"sender_id": self.authUser.user.id, "receiver_id": self.selectedId},
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              },
              success: function (e) {
              }
            });

          } // if(self.progress == 'connect') { // there were no answer

          if (self.progress !== "connected" || self.progress !== "declined") {
            self.sendRequestSocket("session_cancel");
            self.progress = "notAnswered";
            self.stopAudio();
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
      this.current_consultant.user.status = "busy"; // update current selected consultant's stauts for detail view
      this.sendStatusSocket("busy"); // update current user's status on status socket server
    },

    // send request via socket
    sendRequestSocket(type) {
      this.$socket.sendObj({
        command: "message",
        type: "request",
        sub_type: type,
        id: this.current_consultant.user.id,
        customer_id: this.authUser.user.id,
        customer_name:
          this.authUser.user.first_name +
          " " +
          this.authUser.user.last_name,
        min: this.form.minute,
        img: this.authUser.profile.avatar
      });
    },
    // send status via socket to another all users
    sendStatusSocket(msg) {
      this.$socket.sendObj({ command: "message", type: "status", id: this.authUser.user.id, msg });
    },
    // update self status into DB
    setStatus(status) {
      axios.post("/api/manage_status", { id: this.authUser.user.id, status});
    },
    // Handling Voice module
    startCall() {
      var params = {
        phone: this.current_consultant.user.phone,
        callerId: this.authUser.user.phone,
        name:
          this.current_consultant.user.first_name +
          this.current_consultant.user.last_name,
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

      // var params = {
      //   phone: this.current_consultant.user.phone,
      //   callerId: this.authUser.user.phone,
      //   name:
      //     this.current_consultant.user.first_name +
      //     this.current_consultant.user.last_name,
      //   type: "video",
      //   roomName: `videoRoom-${this.current_consultant.user.id}-${this.authUser.user.id}`
      // };
      // this.device.connect(params);

      const token = await this.fetchVideoToken();
      Video.connect(token, {
        name: `videoRoom-${this.current_consultant.user.id}-${this.authUser.user.id}`
      }).then(
        room => {
          // console.log("Successfully joined a Room: ", room);
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

          //Send video call start request when the room is ready
          this.sendRequestSocket("video_call_start");
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
    trackUnsubscribed(track) {
      track.detach().forEach(element => element.remove());
    },

    // Handling button events
    minuteChange(vatPercent) {
      const val = Number(this.form.minute) * Number(this.current_consultant.hourly_rate);
      const endpoint = 'convert';
      const from = this.current_consultant.currency;
      const to = 'NOK';
      console.log('resources/js/components/CustomerComponent.vue minuteChange this.current_consultant.currency::')
      console.log(this.current_consultant.currency)
      const self = this;

      if (val !== 0){
          if (this.current_consultant.currency !== 'NOK') {
            console.log('NOT NOK ::')
            console.log('https://api.currencylayer.com/' + endpoint + '?access_key=' + this.accessKey.key +'&from=' + from + '&to=' + to + '&amount=' + val)
            $.ajax({
            url: 'https://api.currencylayer.com/' + endpoint + '?access_key=' + this.accessKey.key +'&from=' + from + '&to=' + to + '&amount=' + val,
            dataType: 'jsonp',
            success: function(json) {

                console.log('-1 BOT NOK minuteChange json::')
                console.log(json)

                self.cost = json.result;
                console.log('this.vatPercent::')
                console.log(vatPercent)

                if(vatPercent > 0) {
                self.calculatedVat= self.cost / 100 * vatPercent
                console.log('-2 minuteChange this.calculatedVat::')
                console.log(self.calculatedVat)

                self.formattedCalculatedVat= new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(self.calculatedVat).replace('kr', 'NOK')
                self.totalWithVat= self.calculatedVat + self.cost
                console.log('-3 minuteChange this.totalWithVat::')
                console.log(self.totalWithVat)
                self.formattedTotalWithVat = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(self.totalWithVat).replace('kr', 'NOK');
                }

                self.formatted_cost = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(self.cost).replace('kr', 'NOK');
                console.log('-4 minuteChange this.formatted_cost::')
                console.log(self.formatted_cost)
            }
            });
        } else {
            console.log('NOK ::')
            self.cost = val;
            if(vatPercent > 0) {
                console.log('-91 minuteChange this.vatPercent::')
                console.log(vatPercent)

                self.calculatedVat= self.cost / 100 * vatPercent
                self.formattedCalculatedVat= new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(self.calculatedVat).replace('kr', 'NOK')
                console.log('-92 minuteChange this.formattedCalculatedVat::')
                console.log(self.formattedCalculatedVat)

                self.totalWithVat= self.calculatedVat + self.cost
                self.formattedTotalWithVat = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(self.totalWithVat).replace('kr', 'NOK');
                console.log('-93 minuteChange this.formattedTotalWithVat::')
                console.log(self.formattedTotalWithVat)
            }

            self.formatted_cost = new Intl.NumberFormat('no-NO', { style: 'currency', currency: 'NOK' }).format(self.cost).replace('kr', 'NOK');
            console.log('-94 minuteChange this.formatted_cost::')
            console.log(self.formatted_cost)
        }
      } else {
          self.totalWithVat = null
          self.formattedCalculatedVat = null
          self.formattedTotalWithVat = null
          self.calculatedVat = null
          self.formatted_cost = null
      }
    },
    submitReview() {
      axios
        .post("/api/submit_review", {
          sender_id: this.authUser.user_id,
          receiver_id: this.current_consultant.user_id,
          rate: this.rate,
          description: this.review_des,
          type: "CUSTOCON"
        })
        .then(res => {
          this.is_review_modal = false;
          this.is_call_modal = false;
          this.time_clock = 0;
        });
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
    scrollToEnd() {
      var container = this.$el.querySelector("#scroll-view");
      if (container) {
        container.scrollTop = container.scrollHeight;
      }
    },
    showSetting() {
      this.is_setting = true;
    },
    goProfile() {
      if (this.lang.data == "en") {
        window.location.href = window.location.origin + "/profile/" + this.current_consultant.user.id;
      } else {
        window.location.href = window.location.origin + "/no/profil/" + this.current_consultant.user.id;
      }
    },
    handleClose(type) {
      switch (type) {
        case "progress":
          this.sendRequestSocket("cancel_request");
          this.is_progress_modal = false;
          this.stopAudio();
          break;
        case "call":
          this.is_call_modal = false;
          if (this.is_session) {
            this.device.disconnectAll();
          }
          if (this.activeRoom) {
            this.activeRoom.localParticipant.tracks.forEach(function(track) {
              track.stop();
            });
            this.activeRoom.disconnect();
          }
          this.handleSessionEnd();
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
      }
    },
    handleCloseProgress() {
      this.is_progress_modal = false;
    },
    handleSessionEnd() {
      this.sendRequestSocket("session_end");
      this.setStatus("available");
      this.sendStatusSocket("available");
      this.current_consultant.user.status = "available";
      clearInterval(this.interval);
      this.is_session_modal = false;
      this.is_call_modal = false;
      this.is_session = false;
      this.is_review_modal = true;

      // Stop all tracks of local participant
      this.activeRoom.localParticipant.tracks.forEach(track=>{
        track.stop();
      })
      //Disconnect from the room
      this.activeRoom.disconnect();
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
    playAudio() {
      this.outgoing_audio = new Audio('/audio/call.mp3');
      this.outgoing_audio.loop = true;
      this.outgoing_audio.play();
    },
    stopAudio() {
      this.outgoing_audio.pause();
    },
    preventNav(event) {
      if (this.is_session) {
        event.preventDefault();
        event.returnValue = "";
        console.log("sending session end request before page reloading");
        this.sendRequestSocket("session_end");
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
      if (cur == 0 && this.is_session) {
        this.handleSessionEnd();
      }
    }
  }
};
</script>
