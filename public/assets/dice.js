
function rollDie() {
    return 1 + Math.floor(Math.random() * 6) % 6;
}

function rollDice(dice, idx) { // modifies the dice array, idx contains indices of which dice to reroll
    for (i of idx) dice[i] = rollDie();
    return dice;
}