<template>
  <div id="app">
    <TheHeader />
    <transition name="fade" mode="out-in">
      <router-view></router-view>
    </transition>
    <TheFooter />
  </div>
</template>

<script>
import TheHeader from '@/components/TheHeader';
import TheFooter from '@/components/TheFooter';

export default {
  name: 'App',
  components: {
    TheHeader,
    TheFooter,
  },
};
</script>
