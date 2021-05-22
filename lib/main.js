$(document).ready(function () {
    $("#submit").click(function() { 
        var id = $("#idggform").val()
        var time = parseInt($("#time").val())
        $(".bailam").removeAttr("style");
        startTimer(time)
        var count = 0
        document.addEventListener("visibilitychange", event => {
            $("#warning-tabs").removeAttr("style");
            if (document.visibilityState != "visible") {
                count++;
                $("#notify").text("Bạn đã chuyển tab " + count + "lần")
            }
            })
        
        
            $("#googleform").attr("src", "https://docs.google.com/forms/d/e/" + id +"/viewform?embedded=true")
        
    });
});


function startTimer(duration) {
    var timer = duration, minutes, seconds;
    setInterval(function () {
        minutes = parseInt(timer / 60, 10);
        seconds = parseInt(timer % 60, 10);

        minutes = minutes < 10 ? "0" + minutes : minutes;
        seconds = seconds < 10 ? "0" + seconds : seconds;

        $("#counttime").text(minutes + ":" + seconds);

        if (--timer < 0) {
            timer = duration;
        }
    }, 1000);
}

