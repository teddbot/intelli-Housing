(()=>{"use strict";var e={3744:(e,t)=>{t.Z=(e,t)=>{const n=e.__vccOpts||e;for(const[e,r]of t)n[e]=r;return n}}},t={};function n(r){var o=t[r];if(void 0!==o)return o.exports;var a=t[r]={exports:{}};return e[r](a,a.exports,n),a.exports}(()=>{const e=Vue;var t={key:0,class:"note note-warning"},r=["href"];const o={props:{verifyUrl:{type:String,default:function(){return null},required:!0},settingUrl:{type:String,default:function(){return null},required:!0}},data:function(){return{verified:!0}},mounted:function(){this.verifyLicense()},methods:{verifyLicense:function(){var e=this;axios.get(this.verifyUrl).then((function(t){t.data.error&&(e.verified=!1)}))}}};var a=n(3744);const l=(0,a.Z)(o,[["render",function(n,o,a,l,s,i){return s.verified?(0,e.createCommentVNode)("",!0):((0,e.openBlock)(),(0,e.createElementBlock)("div",t,[(0,e.createElementVNode)("p",null,[(0,e.createTextVNode)(" Your license is invalid, please contact support. If you didn't setup license code, please go to "),(0,e.createElementVNode)("a",{href:a.settingUrl},"Settings",8,r),(0,e.createTextVNode)(" to activate license! ")])]))}]]);var s={key:0,class:"note note-warning"},i=["href"];const d={props:{checkUpdateUrl:{type:String,default:function(){return null},required:!0},settingUrl:{type:String,default:function(){return null},required:!0}},data:function(){return{hasNewVersion:!1,message:null}},mounted:function(){this.checkUpdate()},methods:{checkUpdate:function(){var e=this;axios.get(this.checkUpdateUrl).then((function(t){!t.data.error&&t.data.data.has_new_version&&(e.hasNewVersion=!0,e.message=t.data.message)}))}}},c=(0,a.Z)(d,[["render",function(t,n,r,o,a,l){return a.hasNewVersion?((0,e.openBlock)(),(0,e.createElementBlock)("div",s,[(0,e.createElementVNode)("p",null,[(0,e.createTextVNode)((0,e.toDisplayString)(a.message)+", please go to ",1),(0,e.createElementVNode)("a",{href:r.settingUrl},"System Updater",8,i),(0,e.createTextVNode)(" to upgrade to the latest version!")])])):(0,e.createCommentVNode)("",!0)}]]);function u(e,t){for(var n=0;n<t.length;n++){var r=t[n];r.enumerable=r.enumerable||!1,r.configurable=!0,"value"in r&&(r.writable=!0),Object.defineProperty(e,r.key,r)}}"undefined"!=typeof vueApp&&vueApp.booting((function(e){e.component("verify-license-component",l),e.component("check-update-component",c)}));var p={},f=function(){function e(){!function(e,t){if(!(e instanceof t))throw new TypeError("Cannot call a class as a function")}(this,e)}var t,n,r;return t=e,r=[{key:"loadWidget",value:function(t,n,r,o){var a=t.closest(".widget_item"),l=a.attr("id");void 0!==o&&(p[l]=o);var s=a.find("a.collapse-expand");if(!s.length||!s.hasClass("collapse")){Botble.blockUI({target:t,iconOnly:!0,overlayColor:"none"}),void 0!==r&&null!=r||(r={});var i=a.find("select[name=predefined_range]");i.length&&(r.predefined_range=i.val()),$.ajax({type:"GET",cache:!1,url:n,data:r,success:function(n){Botble.unblockUI(t),n.error?t.html('<div class="dashboard_widget_msg col-12"><p>'+n.message+"</p>"):(t.html(n.data),void 0!==o?o():p[l]&&p[l](),0!==t.find(".scroller").length&&Botble.callScroll(t.find(".scroller")),$(".equal-height").equalHeights(),e.initSortable())},error:function(e){Botble.unblockUI(t),Botble.handleError(e)}})}}},{key:"initSortable",value:function(){if($("#list_widgets").length>0){var e=document.getElementById("list_widgets");Sortable.create(e,{group:"widgets",sort:!0,delay:0,disabled:!1,store:null,animation:150,handle:".portlet-title",ghostClass:"sortable-ghost",chosenClass:"sortable-chosen",dataIdAttr:"data-id",forceFallback:!1,fallbackClass:"sortable-fallback",fallbackOnBody:!1,scroll:!0,scrollSensitivity:30,scrollSpeed:10,onUpdate:function(){var e=[];$.each($(".widget_item"),(function(t,n){e.push($(n).prop("id"))})),$.ajax({type:"POST",cache:!1,url:route("dashboard.update_widget_order"),data:{items:e},success:function(e){e.error?Botble.showError(e.message):Botble.showSuccess(e.message)},error:function(e){Botble.handleError(e)}})}})}}}],(n=[{key:"init",value:function(){var t=$("#list_widgets");$(document).on("click",".portlet > .portlet-title .tools > a.remove",(function(e){e.preventDefault(),$("#hide-widget-confirm-bttn").data("id",$(e.currentTarget).closest(".widget_item").prop("id")),$("#hide_widget_modal").modal("show")})),t.on("click",".page_next, .page_previous",(function(t){t.preventDefault();var n=$(t.currentTarget),r=n.prop("href");r&&e.loadWidget(n.closest(".portlet").find(".portlet-body"),r)})),t.on("change",".number_record .numb",(function(t){t.preventDefault();var n=$(t.currentTarget),r=n.closest(".number_record").find(".numb").val();!isNaN(r)&&r>0?e.loadWidget(n.closest(".portlet").find(".portlet-body"),n.closest(".widget_item").attr("data-url"),{paginate:r}):Botble.showError("Please input a number!")})),t.on("click",".btn_change_paginate",(function(e){e.preventDefault();var t=$(e.currentTarget),n=t.closest(".number_record").find(".numb"),r=parseInt(n.prop("min")||5),o=parseInt(n.prop("max")||100),a=parseInt(n.prop("step")||5),l=parseInt(n.val());t.hasClass("btn_up")?l<o&&(l+=a):t.hasClass("btn_down")&&(l-a>0?l-=a:l=a,l<r&&(l=r)),l!=parseInt(n.val())&&n.val(l).trigger("change")})),$("#hide-widget-confirm-bttn").on("click",(function(e){e.preventDefault();var t=$(e.currentTarget).data("id");$.ajax({type:"GET",cache:!1,url:route("dashboard.hide_widget",{name:t}),success:function(n){n.error?Botble.showError(n.message):($("#"+t).fadeOut(),Botble.showSuccess(n.message)),$("#hide_widget_modal").modal("hide");var r=$(e.currentTarget).closest(".portlet");$(document).hasClass("page-portlet-fullscreen")&&$(document).removeClass("page-portlet-fullscreen"),r.find("[data-bs-toggle=tooltip]").tooltip("destroy"),r.remove()},error:function(e){Botble.handleError(e)}})})),$(document).on("click",".portlet:not(.widget-load-has-callback) > .portlet-title .tools > a.reload",(function(t){t.preventDefault();var n=$(t.currentTarget);e.loadWidget(n.closest(".portlet").find(".portlet-body"),n.closest(".widget_item").attr("data-url"))})),$(document).on("click",".portlet > .portlet-title .tools > .collapse, .portlet .portlet-title .tools > .expand",(function(t){t.preventDefault();var n=$(t.currentTarget),r=n.closest(".portlet"),o=$.trim(n.data("state"));"expand"===o?(r.find(".portlet-body").removeClass("collapse").addClass("expand"),e.loadWidget(r.find(".portlet-body"),n.closest(".widget_item").attr("data-url"))):r.find(".portlet-body").removeClass("expand").addClass("collapse"),$.ajax({type:"POST",cache:!1,url:route("dashboard.edit_widget_setting_item"),data:{name:n.closest(".widget_item").prop("id"),setting_name:"state",setting_value:o},success:function(){"collapse"===o?(n.data("state","expand"),r.find(".predefined-ranges").addClass("d-none"),r.find("a.reload").addClass("d-none"),r.find("a.fullscreen").addClass("d-none")):(n.data("state","collapse"),r.find(".predefined-ranges").removeClass("d-none"),r.find("a.reload").removeClass("d-none"),r.find("a.fullscreen").removeClass("d-none"))},error:function(e){Botble.handleError(e)}})})),$(document).on("change",".portlet select[name=predefined_range]",(function(t){t.preventDefault();var n=$(t.currentTarget);e.loadWidget(n.closest(".portlet").find(".portlet-body"),n.closest(".widget_item").attr("data-url"),{changed_predefined_range:1})}));var n=$("#manage_widget_modal");$(document).on("click",".manage-widget",(function(e){e.preventDefault(),n.modal("show")})),n.on("change",".swc_wrap input",(function(e){$(e.currentTarget).closest("section").find("i").toggleClass("widget_none_color")}))}}])&&u(t.prototype,n),r&&u(t,r),e}();$(document).ready((function(){(new f).init(),window.BDashboard=f}))})()})();