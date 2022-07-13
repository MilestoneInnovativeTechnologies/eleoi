import { defineStore } from 'pinia'

export const useMasterStore = defineStore('master', {
  state: () => {
    const masters = _(MASTERS).mapKeys().mapValues(() => ({})).value()
    return {
      masters: {},
      props: {},
      ...masters
    }
  },
  getters: {
    properties(state){ return _.flatMap(state.props) }
  },
  actions: {
    data(Data){ _.forEach(Data,(data,key) => this[key] = data) },
    property(Data){ _.forEach(Data,(data,key) => this.props[key] = data) },
    master(Data){ _.forEach(Data,(data,key) => this.masters[key] = data) },
  }
})
