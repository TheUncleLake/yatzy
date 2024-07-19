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
            $.ajax({type: "PUT", url: `api/select/${i}`}).then(function(data) {
                updateGame(data);
            });
        };
        dice.push(elem);
    }
    // Update game based on JSON output (rollNo, dice, keep, scoreBox)
    function updateGame(data) {
        if (data == null) return;
        if ("rollNo" in data) {
            if (data.rollNo >= 3 || data.rollNo > 0 && ("keep" in data) && data.keep.length >= 5)
                btnRoll.disabled = true;
            else btnRoll.disabled = false;
        }
        if ("dice" in data) {
            board.innerHTML = "";
            // Putting dots on dice
            if (data.dice.length == 5) {
                for (let i = 0; i < dice.length; i++) {
                    dice[i].innerHTML = "";
                    board.appendChild(dice[i]);
                    dice[i].className = dice[i].className.replace(/(?:^|\s)d\d(?!\S)/g, '');
                    dice[i].classList.add("d" + data.dice[i]);
                    let col = [];
                    if (data.dice[i] >= 4) {
                        for (let j = 0; j <= 1 + (data.dice[i] % 2); j++) {
                            col[j] = document.createElement("div");
                            col[j].classList.add("col");
                            dice[i].appendChild(col[j]);
                        }
                    }
                    for (let j = 0; j < data.dice[i]; j++) {
                        const elem = document.createElement("span");
                        elem.classList.add("dot");
                        if (data.dice[i] >= 4)
                            col[(j + 2) % col.length].appendChild(elem);
                        else dice[i].appendChild(elem);
                    }
                }
            }
        }
        if ("keep" in data) {
            for (let i = 0; i < 5; i++) {
                if (i in data.keep) dice[i].classList.add("selected");
                else dice[i].classList.remove("selected");
            }
        }
        if ("scoreBox" in data) {
            const ids = [
                "ones", "twos", "threes", "fours", "fives", "sixes",
                "onePair", "twoPairs", "threeKind", "fourKind",
                "smallStraight", "largeStraight", "fullHouse", "chance", "yatzy",
                "sum", "bonus", "total"
            ];
            for (const key of ids) {
                const elem = document.getElementById(key);
                if (key in data.scoreBox) {
                    const score = Object.entries(data.scoreBox[key])[0];
                    elem.textContent = score[1];
                    elem.style.color = score[0] == 0 ? "red" : score[0] == 1 ? "green" : "darkgoldenrod";
                }
                else elem.textContent = "";
            }
        }
    }
    // Load saved game if there is one
    $.ajax({type: "GET", url: "api/loadgame"}).then(function(data) {
        updateGame(data);
    });
    // Roll Dice button
    btnRoll.onclick = async function() {
        $.ajax({type: "PUT", url: "api/roll"}).then(function(data) {
            updateGame(data);
        });
    };
    // Start Game button
    btnStart.onclick = async function() {
        $.ajax({type: "PUT", url: "api/restart"}).then(function(data) {
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