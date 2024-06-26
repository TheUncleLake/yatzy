
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
        });
        dice.push(elem);
    }
    btnRoll.addEventListener("click", () => {
        if (gameState.rollNo >= 3) return;
        const list = (new Set([0,1,2,3,4])).difference(gameState.keptDice);
        rollDice(gameState.dice, list);
        gameState.rollNo++;
        btnRoll.disabled = (gameState.rollNo >= 3);
        board.innerHTML = "";
        for (const die of dice) board.appendChild(die);
    });
    btnStart.addEventListener("click", () => {
        gameState.rollNo = 0;
        gameState.keptDice.clear();
        gameState.scoreBox = {};
        board.innerHTML = "";
        for (const die of dice) die.classList.remove("selected");
    });
})();