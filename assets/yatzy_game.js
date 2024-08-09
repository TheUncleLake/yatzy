
const gameState = {
    rollNo: 0,
    dice: Array(5),
    keptDice: new Set(),
    scoreBox: {}
};

(function() {
    const btnRoll = document.getElementById("btnRoll");
    const btnStart = document.getElementById("btnStart");
    const board = document.querySelector(".dice");
    const dice = [];
    let hasRolled = false;
    // Initialize dice
    for (let i = 0; i < 5; i++) {
        const elem = document.createElement("div");
        elem.classList.add("die");
        elem.addEventListener("click", () => {
            if (gameState.keptDice.has(i)) {
                elem.classList.remove("selected");
                gameState.keptDice.delete(i);
            } else {
                elem.classList.add("selected");
                gameState.keptDice.add(i);
            }
            btnRoll.disabled = gameState.rollNo >= 3 || gameState.rollNo > 0 && gameState.keptDice.size >= 5;
        });
        dice.push(elem);
    }
    // Roll Dice button
    btnRoll.addEventListener("click", () => {
        if (gameState.rollNo >= 3) return;
        if (gameState.rollNo > 0 && gameState.keptDice.size >= 5) return;
        let list = new Set([0,1,2,3,4]);
        if (gameState.rollNo == 0) {
            gameState.keptDice.clear();
            for (const die of dice) die.classList.remove("selected");
        }
        else list = list.difference(gameState.keptDice);
        rollDice(gameState.dice, list);
        gameState.rollNo++;
        btnRoll.disabled = gameState.rollNo >= 3;
        board.innerHTML = "";
        // Putting dots on dice
        for (let i = 0; i < dice.length; i++) {
            dice[i].innerHTML = "";
            board.appendChild(dice[i]);
            dice[i].className = dice[i].className.replace(/(?:^|\s)d\d(?!\S)/g, '');
            dice[i].classList.add("d" + gameState.dice[i]);
            let col = [];
            if (gameState.dice[i] >= 4) {
                for (let j = 0; j <= 1 + (gameState.dice[i] % 2); j++) {
                    col[j] = document.createElement("div");
                    col[j].classList.add("col");
                    dice[i].appendChild(col[j]);
                }
            }
            for (let j = 0; j < gameState.dice[i]; j++) {
                const elem = document.createElement("span");
                elem.classList.add("dot");
                if (gameState.dice[i] >= 4)
                    col[(j + 2) % col.length].appendChild(elem);
                else dice[i].appendChild(elem);
            }
        }
        // Updating scores on score boxes
        hasRolled = true;
        for (const key of Object.keys(scoreBoxFunctions)) {
            if (key in gameState.scoreBox) continue;
            const elem = document.getElementById(key);
            elem.textContent = calculateScore(gameState, key);
            elem.style.color = "red";
        }
    });
    // Score Box buttons
    for (const key of Object.keys(scoreBoxFunctions)) {
        const elem = document.getElementById(key);
        elem.addEventListener("click", () => {
            if (!hasRolled || key in gameState.scoreBox) return;
            hasRolled = false;
            gameState.rollNo = 0;
            btnRoll.disabled = false;
            gameState.scoreBox[key] = calculateScore(gameState, key);
            elem.style.color = "green";
            let gameOver = true;
            for (const key of Object.keys(scoreBoxFunctions)) {
                if (key in gameState.scoreBox) continue;
                const elem = document.getElementById(key);
                elem.textContent = "";
                gameOver = false;
            }
            if (gameOver) {
                gameState.rollNo = 3;
                btnRoll.disabled = true;
                const scoreBonus = calculateScoreBonus(gameState);
                for (const [key, val] of Object.entries(scoreBonus)) {
                    const elem = document.getElementById(key);
                    elem.textContent = val;
                    elem.style.color = "darkgoldenrod";
                }
            }
        });
    }
    // Start Game button
    btnStart.addEventListener("click", () => {
        gameState.rollNo = 0;
        gameState.keptDice.clear();
        gameState.scoreBox = {};
        board.innerHTML = "";
        btnRoll.disabled = false;
        hasRolled = false;
        for (const die of dice) die.classList.remove("selected");
        for (const key of Object.keys(scoreBoxFunctions))
            document.getElementById(key).textContent = "";
        for (const key of ["sum", "bonus", "total"])
            document.getElementById(key).textContent = "";
    });
})();