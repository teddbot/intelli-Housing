(()=>{function t(t,e){for(var n=0;n<e.length;n++){var a=e[n];a.enumerable=a.enumerable||!1,a.configurable=!0,"value"in a&&(a.writable=!0),Object.defineProperty(t,a.key,a)}}var e=function(){function e(){!function(t,e){if(!(t instanceof e))throw new TypeError("Cannot call a class as a function")}(this,e)}var n,a,o;return n=e,o=[{key:"changeProvince",value:function(t){var e=$(document).find("select[data-type=city]");t.data("related-city")&&(e=$(document).find("#"+t.data("related-city")));var n=t.data("change-state-url");null!==n&&""!==n&&""!==t.val()&&$.ajax({url:n,type:"GET",data:{state_id:t.val()},beforeSend:function(){t.closest("form").find("button[type=submit], input[type=submit]").prop("disabled",!0)},success:function(n){var a='<option value="">'+e.data("placeholder")+"</option>";$.each(n.data,(function(t,n){n.id===e.data("origin-value")?a+='<option value="'+n.id+'" selected="selected">'+n.name+"</option>":a+='<option value="'+n.id+'">'+n.name+"</option>"})),e.html(a),t.closest("form").find("button[type=submit], input[type=submit]").prop("disabled",!1)}})}}],(a=null)&&t(n.prototype,a),o&&t(n,o),e}();$(document).ready((function(){var t=$(document).find("select[data-type=state]");t.length>0&&($.each(t,(function(t,n){e.changeProvince($(n))})),$(document).on("change","select[data-type=state]",(function(t){e.changeProvince($(t.currentTarget))})))}))})();