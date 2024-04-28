
    function openTab(evt, tabName) {
        var i, tabcontent, tablinks;
        tabcontent = document.getElementsByClassName("tabcontent");
        for (i = 0; i < tabcontent.length; i++) {
            tabcontent[i].style.display = "none";
        }
        tablinks = document.getElementsByClassName("tablinks");
        for (i = 0; i < tablinks.length; i++) {
            tablinks[i].className = tablinks[i].className.replace(" btn-success text-white", "");
        }
        document.getElementById(tabName).style.display = "block";
        evt.currentTarget.className += " btn-success text-white";

        // Save the current tab in local storage
        localStorage.setItem("lastOpenTab", tabName);

        // Set a timer to clear local storage after 5 minutes (300,000 milliseconds)
        setTimeout(function () {
            localStorage.removeItem("lastOpenTab");
        }, 300000);
    }

    // Set the default open tab on page load
    var lastOpenTab = localStorage.getItem("lastOpenTab");
    if (lastOpenTab) {
        document.getElementById(lastOpenTab + "Btn").click();
    } else {
        document.getElementById("defaultOpen").click();
    }

