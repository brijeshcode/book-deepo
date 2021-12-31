"use strict";(self.webpackChunk=self.webpackChunk||[]).push([[664],{8789:(e,t,o)=>{o.d(t,{Z:()=>l});var n=o(821),s={class:"text-sm text-gray-600"};const r=(0,n.defineComponent)({props:["on"]});const l=(0,o(3744).Z)(r,[["render",function(e,t,o,r,l,a){return(0,n.openBlock)(),(0,n.createElementBlock)("div",null,[(0,n.createVNode)(n.Transition,{"leave-active-class":"transition ease-in duration-1000","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",s,[(0,n.renderSlot)(e.$slots,"default")],512),[[n.vShow,e.on]])]})),_:3})])}]])},8050:(e,t,o)=>{o.d(t,{Z:()=>i});var n=o(821),s={class:"md:grid md:grid-cols-3 md:gap-6"},r={class:"mt-5 md:mt-0 md:col-span-2"},l={class:"px-4 py-5 sm:p-6 bg-white shadow sm:rounded-lg"};var a=o(5218);const c=(0,n.defineComponent)({components:{JetSectionTitle:a.Z}});const i=(0,o(3744).Z)(c,[["render",function(e,t,o,a,c,i){var d=(0,n.resolveComponent)("jet-section-title");return(0,n.openBlock)(),(0,n.createElementBlock)("div",s,[(0,n.createVNode)(d,null,{title:(0,n.withCtx)((function(){return[(0,n.renderSlot)(e.$slots,"title")]})),description:(0,n.withCtx)((function(){return[(0,n.renderSlot)(e.$slots,"description")]})),_:3}),(0,n.createElementVNode)("div",r,[(0,n.createElementVNode)("div",l,[(0,n.renderSlot)(e.$slots,"content")])])])}]])},7020:(e,t,o)=>{o.d(t,{Z:()=>l});var n=o(821),s=["type"];const r=(0,n.defineComponent)({props:{type:{type:String,default:"submit"}}});const l=(0,o(3744).Z)(r,[["render",function(e,t,o,r,l,a){return(0,n.openBlock)(),(0,n.createElementBlock)("button",{type:e.type,class:"inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:ring focus:ring-gray-300 disabled:opacity-25 transition"},[(0,n.renderSlot)(e.$slots,"default")],8,s)}]])},6336:(e,t,o)=>{o.d(t,{Z:()=>d});var n=o(821),s={class:"px-6 py-4"},r={class:"text-lg"},l={class:"mt-4"},a={class:"px-6 py-4 bg-gray-100 text-right"};var c=o(5658);const i=(0,n.defineComponent)({emits:["close"],components:{Modal:c.Z},props:{show:{default:!1},maxWidth:{default:"2xl"},closeable:{default:!0}},methods:{close:function(){this.$emit("close")}}});const d=(0,o(3744).Z)(i,[["render",function(e,t,o,c,i,d){var u=(0,n.resolveComponent)("modal");return(0,n.openBlock)(),(0,n.createBlock)(u,{show:e.show,"max-width":e.maxWidth,closeable:e.closeable,onClose:e.close},{default:(0,n.withCtx)((function(){return[(0,n.createElementVNode)("div",s,[(0,n.createElementVNode)("div",r,[(0,n.renderSlot)(e.$slots,"title")]),(0,n.createElementVNode)("div",l,[(0,n.renderSlot)(e.$slots,"content")])]),(0,n.createElementVNode)("div",a,[(0,n.renderSlot)(e.$slots,"footer")])]})),_:3},8,["show","max-width","closeable","onClose"])}]])},7292:(e,t,o)=>{o.d(t,{Z:()=>l});var n=o(821),s=["value"];const r=(0,n.defineComponent)({props:["modelValue"],emits:["update:modelValue"],methods:{focus:function(){this.$refs.input.focus()}}});const l=(0,o(3744).Z)(r,[["render",function(e,t,o,r,l,a){return(0,n.openBlock)(),(0,n.createElementBlock)("input",{class:"border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm",value:e.modelValue,onInput:t[0]||(t[0]=function(t){return e.$emit("update:modelValue",t.target.value)}),ref:"input"},null,40,s)}]])},675:(e,t,o)=>{o.d(t,{Z:()=>l});var n=o(821),s={class:"text-sm text-red-600"};const r=(0,n.defineComponent)({props:["message"]});const l=(0,o(3744).Z)(r,[["render",function(e,t,o,r,l,a){return(0,n.withDirectives)(((0,n.openBlock)(),(0,n.createElementBlock)("div",null,[(0,n.createElementVNode)("p",s,(0,n.toDisplayString)(e.message),1)],512)),[[n.vShow,e.message]])}]])},5658:(e,t,o)=>{o.d(t,{Z:()=>a});var n=o(821),s={class:"fixed inset-0 overflow-y-auto px-4 py-6 sm:px-0 z-50","scroll-region":""},r=[(0,n.createElementVNode)("div",{class:"absolute inset-0 bg-gray-500 opacity-75"},null,-1)];const l=(0,n.defineComponent)({emits:["close"],props:{show:{default:!1},maxWidth:{default:"2xl"},closeable:{default:!0}},watch:{show:{immediate:!0,handler:function(e){document.body.style.overflow=e?"hidden":null}}},setup:function(e,t){var o=t.emit,s=function(){e.closeable&&o("close")},r=function(t){"Escape"===t.key&&e.show&&s()};return(0,n.onMounted)((function(){return document.addEventListener("keydown",r)})),(0,n.onUnmounted)((function(){document.removeEventListener("keydown",r),document.body.style.overflow=null})),{close:s}},computed:{maxWidthClass:function(){return{sm:"sm:max-w-sm",md:"sm:max-w-md",lg:"sm:max-w-lg",xl:"sm:max-w-xl","2xl":"sm:max-w-2xl"}[this.maxWidth]}}});const a=(0,o(3744).Z)(l,[["render",function(e,t,o,l,a,c){return(0,n.openBlock)(),(0,n.createBlock)(n.Teleport,{to:"body"},[(0,n.createVNode)(n.Transition,{"leave-active-class":"duration-200"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",s,[(0,n.createVNode)(n.Transition,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0","enter-to-class":"opacity-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100","leave-to-class":"opacity-0"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",{class:"fixed inset-0 transform transition-all",onClick:t[0]||(t[0]=function(){return e.close&&e.close.apply(e,arguments)})},r,512),[[n.vShow,e.show]])]})),_:1}),(0,n.createVNode)(n.Transition,{"enter-active-class":"ease-out duration-300","enter-from-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95","enter-to-class":"opacity-100 translate-y-0 sm:scale-100","leave-active-class":"ease-in duration-200","leave-from-class":"opacity-100 translate-y-0 sm:scale-100","leave-to-class":"opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"},{default:(0,n.withCtx)((function(){return[(0,n.withDirectives)((0,n.createElementVNode)("div",{class:(0,n.normalizeClass)(["mb-6 bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:w-full sm:mx-auto",e.maxWidthClass])},[e.show?(0,n.renderSlot)(e.$slots,"default",{key:0}):(0,n.createCommentVNode)("",!0)],2),[[n.vShow,e.show]])]})),_:3})],512),[[n.vShow,e.show]])]})),_:3})])}]])},5515:(e,t,o)=>{o.d(t,{Z:()=>l});var n=o(821),s=["type"];const r=(0,n.defineComponent)({props:{type:{type:String,default:"button"}}});const l=(0,o(3744).Z)(r,[["render",function(e,t,o,r,l,a){return(0,n.openBlock)(),(0,n.createElementBlock)("button",{type:e.type,class:"inline-flex items-center px-4 py-2 bg-white border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest shadow-sm hover:text-gray-500 focus:outline-none focus:border-blue-300 focus:ring focus:ring-blue-200 active:text-gray-800 active:bg-gray-50 disabled:opacity-25 transition"},[(0,n.renderSlot)(e.$slots,"default")],8,s)}]])},5218:(e,t,o)=>{o.d(t,{Z:()=>d});var n=o(821),s={class:"md:col-span-1 flex justify-between"},r={class:"px-4 sm:px-0"},l={class:"text-lg font-medium text-gray-900"},a={class:"mt-1 text-sm text-gray-600"},c={class:"px-4 sm:px-0"};const i={},d=(0,o(3744).Z)(i,[["render",function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)("div",s,[(0,n.createElementVNode)("div",r,[(0,n.createElementVNode)("h3",l,[(0,n.renderSlot)(e.$slots,"title")]),(0,n.createElementVNode)("p",a,[(0,n.renderSlot)(e.$slots,"description")])]),(0,n.createElementVNode)("div",c,[(0,n.renderSlot)(e.$slots,"aside")])])}]])},8664:(e,t,o)=>{o.r(t),o.d(t,{default:()=>M});var n=o(821),s=(0,n.createTextVNode)(" Browser Sessions "),r=(0,n.createTextVNode)(" Manage and log out your active sessions on other browsers and devices. "),l=(0,n.createElementVNode)("div",{class:"max-w-xl text-sm text-gray-600"}," If necessary, you may log out of all of your other browser sessions across all of your devices. Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel your account has been compromised, you should also update your password. ",-1),a={key:0,class:"mt-5 space-y-6"},c={key:0,fill:"none","stroke-linecap":"round","stroke-linejoin":"round","stroke-width":"2",viewBox:"0 0 24 24",stroke:"currentColor",class:"w-8 h-8 text-gray-500"},i=[(0,n.createElementVNode)("path",{d:"M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"},null,-1)],d={key:1,xmlns:"http://www.w3.org/2000/svg",viewBox:"0 0 24 24","stroke-width":"2",stroke:"currentColor",fill:"none","stroke-linecap":"round","stroke-linejoin":"round",class:"w-8 h-8 text-gray-500"},u=[(0,n.createElementVNode)("path",{d:"M0 0h24v24H0z",stroke:"none"},null,-1),(0,n.createElementVNode)("rect",{x:"7",y:"4",width:"10",height:"16",rx:"1"},null,-1),(0,n.createElementVNode)("path",{d:"M11 5h2M12 17v.01"},null,-1)],m={class:"ml-3"},p={class:"text-sm text-gray-600"},f={class:"text-xs text-gray-500"},h={key:0,class:"text-green-500 font-semibold"},v={key:1},w={class:"flex items-center mt-5"},y=(0,n.createTextVNode)(" Log Out Other Browser Sessions "),g=(0,n.createTextVNode)(" Done. "),x=(0,n.createTextVNode)(" Log Out Other Browser Sessions "),k=(0,n.createTextVNode)(" Please enter your password to confirm you would like to log out of your other browser sessions across all of your devices. "),V={class:"mt-4"},C=(0,n.createTextVNode)(" Cancel "),b=(0,n.createTextVNode)(" Log Out Other Browser Sessions ");var N=o(8789),E=o(8050),B=o(7020),S=o(6336),Z=o(7292),$=o(675),T=o(5515);const _=(0,n.defineComponent)({props:["sessions"],components:{JetActionMessage:N.Z,JetActionSection:E.Z,JetButton:B.Z,JetDialogModal:S.Z,JetInput:Z.Z,JetInputError:$.Z,JetSecondaryButton:T.Z},data:function(){return{confirmingLogout:!1,form:this.$inertia.form({password:""})}},methods:{confirmLogout:function(){var e=this;this.confirmingLogout=!0,setTimeout((function(){return e.$refs.password.focus()}),250)},logoutOtherBrowserSessions:function(){var e=this;this.form.delete(route("other-browser-sessions.destroy"),{preserveScroll:!0,onSuccess:function(){return e.closeModal()},onError:function(){return e.$refs.password.focus()},onFinish:function(){return e.form.reset()}})},closeModal:function(){this.confirmingLogout=!1,this.form.reset()}}});const M=(0,o(3744).Z)(_,[["render",function(e,t,o,N,E,B){var S=(0,n.resolveComponent)("jet-button"),Z=(0,n.resolveComponent)("jet-action-message"),$=(0,n.resolveComponent)("jet-input"),T=(0,n.resolveComponent)("jet-input-error"),_=(0,n.resolveComponent)("jet-secondary-button"),M=(0,n.resolveComponent)("jet-dialog-modal"),L=(0,n.resolveComponent)("jet-action-section");return(0,n.openBlock)(),(0,n.createBlock)(L,null,{title:(0,n.withCtx)((function(){return[s]})),description:(0,n.withCtx)((function(){return[r]})),content:(0,n.withCtx)((function(){return[l,e.sessions.length>0?((0,n.openBlock)(),(0,n.createElementBlock)("div",a,[((0,n.openBlock)(!0),(0,n.createElementBlock)(n.Fragment,null,(0,n.renderList)(e.sessions,(function(e,t){return(0,n.openBlock)(),(0,n.createElementBlock)("div",{class:"flex items-center",key:t},[(0,n.createElementVNode)("div",null,[e.agent.is_desktop?((0,n.openBlock)(),(0,n.createElementBlock)("svg",c,i)):((0,n.openBlock)(),(0,n.createElementBlock)("svg",d,u))]),(0,n.createElementVNode)("div",m,[(0,n.createElementVNode)("div",p,(0,n.toDisplayString)(e.agent.platform)+" - "+(0,n.toDisplayString)(e.agent.browser),1),(0,n.createElementVNode)("div",null,[(0,n.createElementVNode)("div",f,[(0,n.createTextVNode)((0,n.toDisplayString)(e.ip_address)+", ",1),e.is_current_device?((0,n.openBlock)(),(0,n.createElementBlock)("span",h,"This device")):((0,n.openBlock)(),(0,n.createElementBlock)("span",v,"Last active "+(0,n.toDisplayString)(e.last_active),1))])])])])})),128))])):(0,n.createCommentVNode)("",!0),(0,n.createElementVNode)("div",w,[(0,n.createVNode)(S,{onClick:e.confirmLogout},{default:(0,n.withCtx)((function(){return[y]})),_:1},8,["onClick"]),(0,n.createVNode)(Z,{on:e.form.recentlySuccessful,class:"ml-3"},{default:(0,n.withCtx)((function(){return[g]})),_:1},8,["on"])]),(0,n.createVNode)(M,{show:e.confirmingLogout,onClose:e.closeModal},{title:(0,n.withCtx)((function(){return[x]})),content:(0,n.withCtx)((function(){return[k,(0,n.createElementVNode)("div",V,[(0,n.createVNode)($,{type:"password",class:"mt-1 block w-3/4",placeholder:"Password",ref:"password",modelValue:e.form.password,"onUpdate:modelValue":t[0]||(t[0]=function(t){return e.form.password=t}),onKeyup:(0,n.withKeys)(e.logoutOtherBrowserSessions,["enter"])},null,8,["modelValue","onKeyup"]),(0,n.createVNode)(T,{message:e.form.errors.password,class:"mt-2"},null,8,["message"])])]})),footer:(0,n.withCtx)((function(){return[(0,n.createVNode)(_,{onClick:e.closeModal},{default:(0,n.withCtx)((function(){return[C]})),_:1},8,["onClick"]),(0,n.createVNode)(S,{class:(0,n.normalizeClass)(["ml-2",{"opacity-25":e.form.processing}]),onClick:e.logoutOtherBrowserSessions,disabled:e.form.processing},{default:(0,n.withCtx)((function(){return[b]})),_:1},8,["onClick","class","disabled"])]})),_:1},8,["show","onClose"])]})),_:1})}]])}}]);