
function rollDie() {
    return 1 + Math.floor(Math.random() * 6) % 6;
}

function rollDice(dice, idx) { // modifies the dice array, idx contains indices of which dice to reroll
    for (let i = 0; i < idx.length; i++) dice[idx[i]] = rollDie();
    return dice;
}