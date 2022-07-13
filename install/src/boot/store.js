import { boot } from 'quasar/wrappers'
import { useMasterStore } from "stores/master";

export default boot(async (ctx) => {
  AssetWorker.onmessage = function(event){
    const { type,payload } = event.data
    const masterStore = useMasterStore();
    masterStore[type](payload)
  }
})
