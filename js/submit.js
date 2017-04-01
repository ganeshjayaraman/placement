/**
 * Created by The Messenger on 8/31/2016.
 */
var SavedOne=[];
function saveBundle(qid){
    SavedOne.push(qid);
}

function gotosubmit(id1) {
    clearOptions();
    loadXMLDoc("id="+id1+"&t=" + Math.random(),"getAns.php",function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            foot=jQuery.parseJSON(xmlhttp.responseText);
            if(foot.length>0){
                id =foot[0];
                var quest = foot[1];
                var ans1 = foot[2];
                var ans2 = foot[3];
                var ans3 = foot[4];
                var ans4 = foot[5];
                var choice = foot[6];
                var dispqno = document.getElementById("dispqno");
                dispqno.innerHTML=id;
                if(id==40){
                    $("#fs").show();
                }else{
                    $("#fs").hide();
                }

                var dispquest = document.getElementById("dispquest");
                dispquest.innerHTML=quest;

                var in1 = document.getElementById("in1");
                var lab1 = document.getElementById("lab1");
                in1.value = ans1;
                lab1.innerHTML=ans1;

                var in2 = document.getElementById("in2");
                var lab2 = document.getElementById("lab2");
                in2.value = ans2;
                lab2.innerHTML=ans2;

                var in3 = document.getElementById("in3");
                var lab3 = document.getElementById("lab3");
                in3.value = ans3;
                lab3.innerHTML=ans3;

                var in4 = document.getElementById("in4");
                var lab4 = document.getElementById("lab4");
                in4.value = ans4;
                lab4.innerHTML=ans4;
                if(choice == "1"){
                    document.getElementById('in1').checked=true;



                }
                if(choice == "2"){
                    document.getElementById('in2').checked=true;
                }
                if(choice == "3"){
                    document.getElementById('in3').checked=true;
                }
                if(choice == "4"){
                    document.getElementById('in4').checked=true;
                }
            }

        }
    });
}
function exiton() {
   if(confirm("Are you sure?")==true) {
       min=0;
       secs=0;
       window.location = "dashboard.php";
   }

}
function submitData()
{
    var qidd = document.getElementById("qid"+id);
    var cname=qidd.className;
    saveBundle(id);
    var answerChoosed;
    if(document.getElementById('in1').checked){
        answerChoosed=document.getElementById('in1').value;
        document.getElementById('in1').checked=false;

        cname = cname+" teal";
        qidd.className=cname;
    }
    if(document.getElementById('in2').checked){
        answerChoosed=document.getElementById('in2').value;
        document.getElementById('in2').checked=false;
        cname = cname+" teal";
        qidd.className=cname;
    }
    if(document.getElementById('in3').checked){
        answerChoosed=document.getElementById('in3').value;
        document.getElementById('in3').checked=false;
        cname = cname+" teal";
        qidd.className=cname;
    }
    if(document.getElementById('in4').checked){
        answerChoosed=document.getElementById('in4').value;
        document.getElementById('in4').checked=false;
        cname = cname+" teal";
        qidd.className=cname;
    }
    loadXMLDoc("id="+id+"&ans="+answerChoosed+"&t=" + Math.random(),"submitAns.php",function()
    {
        if (xmlhttp.readyState==4 && xmlhttp.status==200)
        {
            foot=jQuery.parseJSON(xmlhttp.responseText);
            if(foot.length>0){

                id =foot[0];
                var quest = foot[1];
                var ans1 = foot[2];
                var ans2 = foot[3];
                var ans3 = foot[4];
                var ans4 = foot[5];

                var dispqno = document.getElementById("dispqno");
                dispqno.innerHTML=id;
                var dispquest = document.getElementById("dispquest");
                dispquest.innerHTML=quest;

                var in1 = document.getElementById("in1");
                var lab1 = document.getElementById("lab1");
                in1.value = ans1;
                lab1.innerHTML=ans1;
                if(id==40){
                    $("#fs").show();
                }else{
                    $("#fs").hide();
                }
                var in2 = document.getElementById("in2");
                var lab2 = document.getElementById("lab2");
                in2.value = ans2;
                lab2.innerHTML=ans2;

                var in3 = document.getElementById("in3");
                var lab3 = document.getElementById("lab3");
                in3.value = ans3;
                lab3.innerHTML=ans3;

                var in4 = document.getElementById("in4");
                var lab4 = document.getElementById("lab4");
                in4.value = ans4;
                lab4.innerHTML=ans4;

            }else{
                alert("Something is wrong");
            }

        }
    });

}
function clearOptions() {
    document.getElementById('in1').checked=false;
    document.getElementById('in2').checked=false;
    document.getElementById('in3').checked=false;
    document.getElementById('in4').checked=false;

}
