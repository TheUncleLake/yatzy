
const scoreBoxFunctions = {
    // Upper section
    ones: sumNDice(1),
    twos: sumNDice(2),
    threes: sumNDice(3),
    fours: sumNDice(4),
    fives: sumNDice(5),
    sixes: sumNDice(6),
    // Lower section
    onePair: checkNGroups(1, 2),
    twoPairs: checkNGroups(2, 2),
    threeKind: checkNGroups(1, 3),
    fourKind: checkNGroups(1, 4),
    smallStraight: checkStraight(0),
    largeStraight: checkStraight(1),
    fullHouse: checkFullHouse,
    chance: sumAllDice,
    yatzy: checkYatzy,
}

function sumAllDice(dice) {
    return dice.reduce((p, c) => p + c, 0);
}

function checkFullHouse(dice) {
    let counts = countDice(dice);
    let kind2 = counts.indexOf(2);
    let kind3 = counts.indexOf(3);
    return (kind2 >= 0 && kind3 >= 0) ? sumAllDice(dice) : 0;
}

function checkYatzy(dice) {
    let counts = countDice(dice);
    return (counts.indexOf(5) >= 0) ? 50 : 0;
}

function countDice(dice) {
    let counts = [0, 0, 0, 0, 0, 0];
    for (die of dice) counts[die-1]++;
    return counts;
}

function checkStraight(offset) {
    return function(dice) {
        let counts = countDice(dice);
        for (let i = 0; i < 5; i++) {
            if (counts[i + offset] != 1) return 0;
        }
        return sumAllDice(dice);
    }
}

function checkNGroups(n, k) {
    return function(dice) {
        let sum = 0;
        let counts = countDice(dice);
        for (let i = 5, m = n; i >= 0 && m > 0; i--) {
            if (counts[i] >= k) {
                sum += k * (i+1);
                m--;
            }
        }
        return m == 0 ? sum : 0;
    }
}

function sumNDice(n) {
    return function(dice) {
        let sum = 0;
        for (die of dice) {
            if (die == n) sum += n;
        }
        return sum;
    }
}

function calculateScore(game, scoreBox) {
    return scoreBoxFunctions[scoreBox](game.dice);
}

function calculateScoreBonus(game) {
    let keys1to6 = ['ones', 'twos', 'threes', 'fours', 'fives', 'sixes'];
    let sum1to6 = 0;
    let sum = 0;
    for (key of Object.keys(scoreBoxFunctions)) {
        if (keys1to6.includes(key)) sum1to6 += game.scoreBox[key];
        sum += game.scoreBox[key];
    }
    return {score: sum, bonus: sum1to6 >= 63 ? 50 : 0};
}