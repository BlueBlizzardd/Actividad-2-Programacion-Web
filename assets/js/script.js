const btn = document.querySelector('.submit');
const responseStatus = document.querySelector(".resp");
const responseTable = document.querySelector('#responseTable');
const results = document.querySelector('#results');
const students = [];

btn.addEventListener("click", () => {
    
    if(($('#math').val() < 0 || $('#math').val() > 20) || ($('#physics').val() < 0 || $('#math').val() > 20) || 
    ($('#prog').val() < 0 || $('#prog').val() > 20)) {
        alert("Grades have to be bigger or equal to 0 and smaller or equal to 20");
    } 
    else {
        const params = {
            "id": $('#id').val(),
            "fname": $('#fname').val(),
            "math": $('#math').val(),
            "physics": $('#physics').val(),
            "prog": $('#prog').val()
        };
    
        students.push(params);
    
        $.ajax({
            url: "assets/php/calculate.php",
            type: "POST",
            dataType: "json",
            data: { students: students },
            beforeSend: function() {
                responseStatus.textContent = "Awaiting for a response";
            },
            success: function(resp) {
                console.log(resp);
    
                let newRow = '';
                for(let i = 0; i < resp.students.length; i++) {
                    newRow += `<tr>
                        <td>${resp.students[i].id}</td>
                        <td>${resp.students[i].fname}</td>
                        <td>${resp.students[i].math}</td>
                        <td>${resp.students[i].physics}</td>
                        <td>${resp.students[i].prog}</td>
                    </tr>`;
                }
    
                responseTable.innerHTML = newRow;
                results.innerHTML = resp.results;
            },
            error: function(jqXHR, textStatus, errorThrown){
                console.log(jqXHR);
                responseStatus.textContent = `${textStatus, errorThrown}`;
            } 
    
        })
    }
    

    document.querySelector('.form').reset();
})