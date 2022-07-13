<template>
  <q-page class="flex flex-center column">
    <img alt="Elements Logo" src="~assets/favicon-128x128.png" style="width: 100px; height: 100px">
    <q-card>
      <q-card-section class="bg-red text-white text-bold" style="width: 300px">Imported Data Counts</q-card-section>
      <q-list dense separator>
        <q-item v-for="ITEM in master_master" :key="ITEM">
          <q-item-section>{{ ITEM }}</q-item-section>
          <q-item-section side class="text-info">{{ size(master[ITEM]) }}</q-item-section>
        </q-item>
      </q-list>
    </q-card>
  </q-page>
</template>

<script setup>
import { useMasterStore } from 'stores/master'
const master = useMasterStore()
const master_master = _.map(MASTERS);
const size = _.size
</script>
