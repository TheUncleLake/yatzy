(function() {
    const btnRoll = document.getElementById("btnRoll");
    const openlb = document.getElementById("openlb");
    const lb = document.getElementById("lb");
    const noscore = document.getElementById("noscore");
    btnRoll.onclick = async function() {
        $.ajax({
            type: "GET",
            url: "api/roll"
        }).then(function(data) {
            console.log(data.value);
        });
    };
    openlb.onclick = async function() {
        $.ajax({
            type: "GET",
            url: "api/leaderboard"
        }).then(function(data) {
            lb.innerHTML = "";
            for (let i = 0; i < Math.min(data.leaderboard.length, 10); i++) {
                let tr = lb.insertRow();
                tr.insertCell().innerHTML = i + 1;
                tr.insertCell().innerHTML = data.leaderboard[i];
            }
            if (data.leaderboard.length > 0)
                noscore.style.display = "none";
            else
                noscore.style.display = "inline";
        });
    };
})();