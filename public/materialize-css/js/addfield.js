/**
 * Created by avinash on 26/01/16.
 */

var counter = 1;
var limit = 5;
function addInput(divName) {
    if (counter == limit) {
        alert("You have reached the limit of adding " + counter + " slots");
    }
    else {
        var newdiv = document.createElement('div');
        newdiv.innerHTML = "Time Slot " + (counter+1) + '<div class="form-group"><label>Start Time</label><input type="datetime" name="starttime[' + counter + '][]"/><label>End Time</label><input type="datetime" name="endtime[' + counter + '][]"/></div><div class="form-group"><label>Monday</label><input type="checkbox" name="monday[' + counter + '][]" value="1"/><label>Tuesday</label><input type="checkbox" name="tuesday[' + counter + '][]" value="1"/><label>Wednesday</label><input type="checkbox" name="wednesday[' + counter + '][]" value="1"/><label>Thursday</label><input type="checkbox" name="thursday[' + counter + '][]" value="1"/><label>Friday</label><input type="checkbox" name="friday[' + counter + '][]" value="1"/><label>Saturday</label><input type="checkbox" name="saturday[' + counter + '][]" value="1"/><label>Sunday</label><input type="checkbox" name="sunday[' + counter + '][]" value="1"/></div>';
        //newdiv.innerHTML ='<div class="form-group"><label>Monday</label><input type="checkbox" name="monday'+[counter]+'[]">';
        document.getElementById(divName).appendChild(newdiv);
        counter++;
    }
}