import{c,e as g,h as f}from"./render.5379f846.js";import{c as r,h as u,e as s,g as h,f as m,A as v,_ as x,E as b,F as y,G as _,I as q,J as B,O as C}from"./index.50ce5bc9.js";const $=["top","middle","bottom"];var Q=c({name:"QBadge",props:{color:String,textColor:String,floating:Boolean,transparent:Boolean,multiLine:Boolean,outline:Boolean,rounded:Boolean,label:[Number,String],align:{type:String,validator:e=>$.includes(e)}},setup(e,{slots:o}){const a=r(()=>e.align!==void 0?{verticalAlign:e.align}:null),t=r(()=>{const n=e.outline===!0&&e.color||e.textColor;return`q-badge flex inline items-center no-wrap q-badge--${e.multiLine===!0?"multi":"single"}-line`+(e.outline===!0?" q-badge--outline":e.color!==void 0?` bg-${e.color}`:"")+(n!==void 0?` text-${n}`:"")+(e.floating===!0?" q-badge--floating":"")+(e.rounded===!0?" q-badge--rounded":"")+(e.transparent===!0?" q-badge--transparent":"")});return()=>u("div",{class:t.value,style:a.value,role:"alert","aria-label":e.label},g(o.default,e.label!==void 0?[e.label]:[]))}}),p=c({name:"QPage",props:{padding:Boolean,styleFn:Function},setup(e,{slots:o}){const{proxy:{$q:a}}=h(),t=s(m);s(v,()=>{console.error("QPage needs to be child of QPageContainer")});const n=r(()=>{const l=(t.header.space===!0?t.header.size:0)+(t.footer.space===!0?t.footer.size:0);if(typeof e.styleFn=="function"){const d=t.isContainer.value===!0?t.containerHeight.value:a.screen.height;return e.styleFn(l,d)}return{minHeight:t.isContainer.value===!0?t.containerHeight.value-l+"px":a.screen.height===0?l!==0?`calc(100vh - ${l}px)`:"100vh":a.screen.height-l+"px"}}),i=r(()=>`q-page ${e.padding===!0?" q-layout-padding":""}`);return()=>u("main",{class:i.value,style:n.value},f(o.default))}}),P="/assets/quasar-logo-vertical.55e9c854.svg";const S=b({name:"IndexPage"}),F=C("img",{alt:"Quasar logo",src:P,style:{width:"100px",height:"100px"}},null,-1);function H(e,o,a,t,n,i){return y(),_(p,{class:"flex flex-center column"},{default:q(()=>[F,B(Q,{class:"q-mt-xl q-pa-md",label:"HAO",color:"amber"})]),_:1})}var A=x(S,[["render",H]]);export{A as default};
