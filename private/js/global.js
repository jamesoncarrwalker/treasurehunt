/**
 * Created by jamesskywalker on 02/06/2019.
 */
var BASE = '/';

function ajaxRequest(method,call,response,data,file) {
    var xmlhttp;
    if (window.XMLHttpRequest)  {
        xmlhttp=new XMLHttpRequest();
    } else {
        xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange=function() {
        if (xmlhttp.readyState==4 && xmlhttp.status==200) {
            if(xmlhttp.responseText != ''  ) eval(response + "('"+xmlhttp.responseText+"')");
        }
    }
    var requested = new Date().getTime();
    xmlhttp.open(method,"/treasurehunt/ajax/?ajaxCall="+call+"&data="+encodeURIComponent(data)+"&requested="+requested,true);
    if(file) {
        var formData  = new FormData();
        formData.append('file',file);
        xmlhttp.send(formData);
    } else {
        xmlhttp.send();
    }

}

function checkErrors(object) {
    if(object.hasOwnProperty("SET_ERROR")) {
        alert(object.SET_ERROR);
        return true;
    }
    return false;
}