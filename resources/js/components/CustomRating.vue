<template>
  <div class="rate-stars" v-if="_type == 'dynamic'" @mouseleave="curHover = 0">
    <img :src="[curHover == 5 || rate == 5 ? imgStar5 : curHover == 4 || rate == 4 ? imgStar4 : curHover == 3 || rate == 3 ? imgStar3 : curHover == 2 || rate == 2 ? imgStar2 : curHover == 1 || rate == 1 ? imgStar1 : imgStar0]" @mouseover="curHover = 1" v-on:click="submitReview()" alt="no-image" />
    <img :src="[curHover == 5 || rate == 5 ? imgStar5 : curHover == 4 || rate == 4 ? imgStar4 : curHover == 3 || rate == 3 ? imgStar3 : curHover == 2 || rate == 2 ? imgStar2 : imgStar0]" @mouseover="curHover = 2" v-on:click="submitReview()" alt="no-image" />
    <img :src="[curHover == 5 || rate == 5 ? imgStar5 : curHover == 4 || rate == 4 ? imgStar4 : curHover == 3 || rate == 3 ? imgStar3 : imgStar0]" @mouseover="curHover = 3" v-on:click="submitReview()" alt="no-image" />
    <img :src="[curHover == 5 || rate == 5 ? imgStar5 : curHover == 4 || rate == 4 ? imgStar4 : imgStar0]" @mouseover="curHover = 4" v-on:click="submitReview()" alt="no-image" />
    <img :src="[curHover == 5 || rate == 5 ? imgStar5 : imgStar0]" @mouseover="curHover = 5" v-on:click="submitReview()" alt="no-image" />
    <p>{{this.rate}}.0</p>
  </div>
  <div class="rate-stars" v-else>
    <img :src="[_rate == 5 ? imgStar5 : _rate == 4 ? imgStar4 : _rate == 3 ? imgStar3 : _rate == 2 ? imgStar2 : _rate == 1 ? imgStar1 : imgStar0]" alt="no-image" />
    <img :src="[_rate == 5 ? imgStar5 : _rate == 4 ? imgStar4 : _rate == 3 ? imgStar3 : _rate == 2 ? imgStar2 : imgStar0]" alt="no-image" />
    <img :src="[_rate == 5 ? imgStar5 : _rate == 4 ? imgStar4 : _rate == 3 ? imgStar3 : imgStar0]" alt="no-image" />
    <img :src="[_rate == 5 ? imgStar5 : _rate == 4 ? imgStar4 : imgStar0]" alt="no-image" />
    <img :src="[_rate == 5 ? imgStar5 : imgStar0]" alt="no-image" />
    <p>{{this._rate.toFixed(1)}}</p>
  </div>
</template>

<script>

export default {
  name: 'CustomStarRating',
  props: {
    _rate: {
      type: Number,
      default: 0,
    },
    _type: {
      type: String,
      default: 'static',
    },
  },
  data() {
    return {
      imgStar0: "/images/home/star-w.png",
      imgStar1: "/images/home/star-r.png",
      imgStar2: "/images/home/star-o.png",
      imgStar3: "/images/home/star-y.png",
      imgStar4: "/images/home/star-g.png",
      imgStar5: "/images/home/star-dg.png",
      curHover: 0,
      rate: 0,
      isConfirmed: false
    }
  },
  methods: {
    submitReview() {
      this.rate = this.curHover;
      this.$emit('input', this.rate);
    }
  }
}
</script>