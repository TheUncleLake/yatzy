
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
        dice.push(elem);
    }
    btnRoll.addEventListener("click", () => {
        if (gameState.rollNo >= 3) return;
        const list = (new Set([0,1,2,3,4])).difference(gameState.keptDice);
        rollDice(gameState.dice, list);
        gameState.rollNo++;
        btnRoll.disabled = (gameState.rollNo >= 3);
        board.innerHTML = "";
        for (const die of list) board.appendChild(dice[die]);
    });
})();