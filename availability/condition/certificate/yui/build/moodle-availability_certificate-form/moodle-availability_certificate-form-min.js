YUI.add("moodle-availability_certificate-form",function(e,t){M.availability_certificate=M.availability_certificate||{},M.availability_certificate.form=e.Object(M.core_availability.plugin),M.availability_certificate.form.initInner=function(e){M.availability_certificate.certificate_instances=e},M.availability_certificate.form.getNode=function(t){var n=M.util.get_string("has_issued","availability_certificate");n+='<select class="custom-select">';for(var r in M.availability_certificate.certificate_instances)if(M.availability_certificate.certificate_instances.hasOwnProperty(r)){var i=M.availability_certificate.certificate_instances[r];t.certificate_id&&t.certificate_id==i.instance?n+='<option value="'+i.instance+'" selected>'+i.name+"</option>":n+='<option value="'+i.instance+'">'+i.name+"</option>"}n+="</select>";var s=M.str.availability_certificate,o=e.Node.create("<span>"+n+"</span>");if(!M.availability_certificate.form.addedEvents){M.availability_certificate.form.addedEvents=!0;var u=e.one(".availability-field");u.delegate("click",function(){M.core_availability.form.update()},".availability_certificate select")}return o},M.availability_certificate.form.fillValue=function(e,t){t.one("select").get("options").each(function(){this.get("selected")&&(e.certificate_id=this.get("value"))})},M.availability_certificate.form.fillErrors=function(e,t){}},"@VERSION@",{requires:["base","node","event","moodle-core_availability-form"]});
