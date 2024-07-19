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
    // Roll Dice button
    btnRoll.onclick = async function() {
        $.ajax({type: "GET", url: "api/roll"}).then(function(data) {
            console.log(data.value);
        });
    };
    // Open Leaderboard button
    openlb.onclick = async function() {
        $.ajax({type: "GET", url: "api/leaderboard"}).then(function(data) {
            lb.innerHTML = "";
            modal.style.display = "block";
            for (let i = 0; i < Math.min(data.leaderboard.length, 10); i++) {
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