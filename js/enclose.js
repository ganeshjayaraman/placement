/**
 * Created by The Messenger on 9/1/2016.
 */
function generateData() {
    loadXMLDoc("t=" + Math.random(),"generateData.php",function() {
        if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
            foot = jQuery.parseJSON(xmlhttp.responseText);
            if (foot.length > 0) {

            }
        }
    });
}