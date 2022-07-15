self.importScripts("/lodash.min.js");

self.onmessage = function(e){
  const { type,payload } = e.data
  self[type](payload)
}

let PROPERTIES = {}, PROP_SET = {}, MASTERS = [], STORE_MASTER = {};

function init({ property_time,masters,master_time }){
  for(let id in masters) MASTERS.push([id,masters[id],master_time[id]||0])
  if(property_time) fetch(url('asset',property_time,'properties')).then(handlePropertiesResponse)
}

function url(item,time,name,id){
  let parts = [location.origin,item];
  if(time !== undefined) parts.push(time)
  if(id !== undefined) parts.push(id)
  if(name !== undefined) parts.push(name)
  return parts.join('/') + '.json'
}

function handlePropertiesResponse(response){
  if(!response.ok) return;
  response.json().then(function(properties){
    PROPERTIES = properties;
    _.forEach(PROPERTIES,function(properties,master){
      let pObj = new Object({});
      _.forEach(properties,function(property){
        pObj[property.name] = property['nature'] === 'Y/N' ? false : (property['nature'] === 'Multiple' ? [] : ((property['value_master'] || property['index'] === 'Y') ? { master:property['value_master'],data:null,value:null } : null))
      })
      PROP_SET[String(master)] = pObj
    })
    doFetchMasterData(0)
  })
}

function doFetchMasterData(idx){
  if(MASTERS.length <= idx) return MastersFetched();
  let master = MASTERS[idx]; STORE_MASTER[master[1]] = new Object({});
  fetch(url('asset',master[2],master[1],master[0])).then(response => response.json()).then(json => handleMasterDataResponse(idx,json))
}

function doFetchMasterDataProperties(idx){
  if(MASTERS.length <= idx) return PropertiesFetched(); let master = MASTERS[idx];
  fetch(url('asset','properties',master[1],master[0])).then(response => response.json()).then(PAry => handleDataPropertiesResponse(idx,PAry))
}

function MastersFetched(){
  doFetchMasterDataProperties(0)
}
function PropertiesFetched(){
  self.postMessage({ payload:STORE_MASTER,type:'data' })
  self.postMessage({ payload:PROPERTIES,type:'property' })
  self.postMessage({ payload:MASTERS,type:'master' })
}

function handleMasterDataResponse(idx,MAry){
  let mName = MASTERS[idx][1], mId = String(MASTERS[idx][0]);
  _.forEach(MAry,function(master){
    let id = String(master[0]), name = _.trim(master[1]);
    STORE_MASTER[mName][id] = _.cloneDeep(Object.assign({ id,name },_.get(PROP_SET,mId)))
  })
  let BProps = _(_.get(PROPERTIES,mId)).filter(['nature','Y/N']).mapKeys('name').mapValues(prop => _.get(prop,['masters',0,'ids'],[])).value(), dBProp = {};
  _.forEach(BProps,function(ids,prop_name){
    let valObj = { [prop_name]:true }, SMI = _(ids).mapKeys().mapValues(() => valObj).value();
    _.merge(STORE_MASTER[mName],SMI)
  })
  doFetchMasterData(idx+1)
}

function handleDataPropertiesResponse(idx,PAry){
  let mName = MASTERS[idx][1], mId = String(MASTERS[idx][0]), mProps = _.get(PROPERTIES,mId,[]).filter(prop => prop['nature'] !== 'Y/N')
  _.forEach(PAry,function(dObj,property_id){
    let SMI = {}, property = _.find(mProps,['id',parseInt(property_id)]), pName = property.name;
    if(property && property.index === 'N'){
      if(!property['value_master']){
        const vlFn = (property['nature'] === 'Single')
          ? (Ary) => new Object({ [pName]:Ary[0] })
          : (Ary) => new Object({ [pName]:Ary })
        SMI = _.mapValues(dObj,vlFn)
      } else {
        let val_master = _.find(MASTERS,mAry => mAry[0] == property['value_master']), val_mas_id = val_master[0], val_mas_name = val_master[1], val_mas_data = STORE_MASTER[val_mas_name]
        const vlFn = (property['nature'] === 'Single')
          ? (ids) => new Object({ [pName]:{ data:ids[0],value:_.get(val_mas_data,[ids[0],'name'],null) } })
          : (ids) => _.map(ids,id => new Object({ [pName]:{ master:val_mas_id,data:id,value:_.get(val_mas_data,[id,'name'],null) } }))
        SMI = _.mapValues(dObj,vlFn)
      }
    }
    _.merge(STORE_MASTER[mName],SMI)
  })
  const iProps = _.filter(mProps,['index','Y'])
  _.forEach(iProps,function(property){
    let SMI = {}, pName = property.name;
    if(!property['value_master']){
      _.forEach(property['masters'],function({ value,ids }){
        if(property['nature'] === 'Single'){
          let propObj = new Object({ [pName]:value })
          _.forEach(ids,function(id){ SMI[id] = propObj })
        } else {
          const prObj = new Object({ [pName]:[value] })
          _.forEach(ids,function(id){
            if(!SMI.hasOwnProperty(id)) {
              SMI[id] = _.cloneDeep(prObj)
            } else {
              if(!SMI[id].hasOwnProperty(pName)){
                SMI[id][pName] = [value]
              } else if(SMI[id][pName].indexOf(value)) SMI[id][pName].push(value)
            }
          })
        }
      })
    } else {
      let val_master = _.find(MASTERS,mAry => mAry[0] == property['value_master']), val_mas_id = val_master[0], val_mas_name = val_master[1], val_mas_data = STORE_MASTER[val_mas_name]
      const valTxt = (id) => _.get(val_mas_data,[id,'name']);
      _.forEach(property['masters'],function({ data,ids }){
        const valObj = new Object({ master:property['value_master'],data,value:valTxt(data) })
        if(property['nature'] === 'Single'){
          const valPropObj = new Object({ [pName]:valObj })
          _.forEach(ids,function(id){ SMI[id] = valPropObj })
        } else {
          const valPropObj = new Object({ [pName]:[valObj] })
          _.forEach(ids,function(id){
            if(!SMI.hasOwnProperty(id)) {
              SMI[id] = valPropObj
            } else {
              if(!SMI[id].hasOwnProperty(pName)){
                SMI[id][pName] = [valObj]
              } else SMI[id][pName].push(valObj)
            }
          })
        }
      })
    }
    _.merge(STORE_MASTER[mName],SMI)
  })
  doFetchMasterDataProperties(idx+1)
}
