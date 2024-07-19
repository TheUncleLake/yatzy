(function() {
    const btnRoll = document.getElementById("btnRoll");
    const btnStart = document.getElementById("btnStart");
    const modal = document.querySelector(".modal");
    const openlb = document.getElementById("openlb");
    const lb = document.getElementById("lb");
    const noscore = document.getElementById("noscore");
    const board = document.querySelector(".dice");
    const dice = [];
    // Initialize dice
    for (let i = 0; i < 5; i++) {
        const elem = document.createElement("div");
        elem.classList.add("die");
        elem.onclick = async function() {
            $.ajax({type: "GET", url: "api/keep"}).then(function(data) {
                console.log(data);
            });
        };
        dice.push(elem);
    }
    // Load saved game if there is one
    function updateGame(data) {
        console.log(data);
    }
    $.ajax({type: "GET", url: "api/loadgame"}).then(function(data) {
        updateGame(data);
    });
    // Roll Dice button
    btnRoll.onclick = async function() {
        $.ajax({type: "GET", url: "api/roll"}).then(function(data) {
            updateGame(data);
        });
    };
    // Open Leaderboard button
    openlb.onclick = async function() {
        $.ajax({type: "GET", url: "api/leaderboard"}).then(function(data) {
            lb.innerHTML = "";
            modal.style.display = "block";
            for (let i = 0; i < data.leaderboard.length; i++) {
                let tr = lb.insertRow();
                tr.insertCell().innerHTML = i + 1;
                tr.insertCell().innerHTML = data.leaderboard[i];
            }
            if (data.leaderboard.length > 0)
                noscore.style.display = "none";
            else
                noscore.style.display = "flex";
        });
    };
    window.onclick = function(event) {
        if (event.target == modal) modal.style.display = "none";
    };
})();